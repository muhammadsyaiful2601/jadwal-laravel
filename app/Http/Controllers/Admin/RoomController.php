<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get all rooms
        $rooms = DB::table('rooms')->orderBy('nama_ruang')->get();

        // Statistics
        $totalRooms = $rooms->count();
        $withPhoto = $rooms->where('foto_path', '!=', null)->count();
        $totalCapacity = $rooms->sum('kapasitas');

        // Get used rooms
        $usedRooms = DB::table('schedules')->distinct('ruang')->pluck('ruang')->toArray();
        $usedCount = count($usedRooms);

        return view('admin.manage-rooms', compact(
            'rooms',
            'totalRooms',
            'withPhoto',
            'totalCapacity',
            'usedCount'
        ));
    }

    public function store(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $request->validate([
                    'nama_ruang' => 'required|string|max:100|unique:rooms,nama_ruang',
                    'deskripsi' => 'nullable|string',
                    'kapasitas' => 'nullable|integer|min:0',
                    'fasilitas' => 'nullable|string',
                    'foto' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
                ]);

                $namaRuang = trim($request->input('nama_ruang'));
                $deskripsi = trim($request->input('deskripsi'));
                $kapasitas = $request->input('kapasitas', 0);
                $fasilitas = trim($request->input('fasilitas', ''));

                $roomId = DB::table('rooms')->insertGetId([
                    'nama_ruang' => $namaRuang,
                    'deskripsi' => $deskripsi,
                    'kapasitas' => $kapasitas,
                    'fasilitas' => $fasilitas,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Upload foto jika ada
                if ($request->hasFile('foto')) {
                    $foto = $request->file('foto');
                    $extension = $foto->getClientOriginalExtension();
                    $filename = 'room_' . $roomId . '_' . time() . '.' . $extension;

                    $foto->storeAs('uploads/rooms', $filename, 'public');

                    DB::table('rooms')->where('id', $roomId)->update([
                        'foto_path' => $filename,
                        'updated_at' => now(),
                    ]);
                }

                $this->logActivity($request->session()->get('user_id'), 'Tambah Ruangan', $namaRuang);

                $room = DB::table('rooms')->where('id', $roomId)->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan berhasil ditambahkan!',
                    'data' => $room
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan ruangan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        return $this->storeLegacy($request);
    }

    // Legacy method for non-AJAX fallback
    private function storeLegacy(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:100|unique:rooms,nama_ruang',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        $namaRuang = trim($request->input('nama_ruang'));
        $deskripsi = trim($request->input('deskripsi'));
        $kapasitas = $request->input('kapasitas', 0);
        $fasilitas = trim($request->input('fasilitas', ''));

        DB::beginTransaction();

        try {
            $roomId = DB::table('rooms')->insertGetId([
                'nama_ruang' => $namaRuang,
                'deskripsi' => $deskripsi,
                'kapasitas' => $kapasitas,
                'fasilitas' => $fasilitas,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $extension = $foto->getClientOriginalExtension();
                $filename = 'room_' . $roomId . '_' . time() . '.' . $extension;

                $foto->storeAs('uploads/rooms', $filename, 'public');

                DB::table('rooms')->where('id', $roomId)->update([
                    'foto_path' => $filename,
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            $this->logActivity($request->session()->get('user_id'), 'Tambah Ruangan', $namaRuang);

            return redirect('/admin/manage-rooms')->with('success', 'Ruangan berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan ruangan: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id = null)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // If ID is not in route, get it from POST data
        if (!$id) {
            $id = $request->input('id');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $room = DB::table('rooms')->where('id', $id)->first();
                if (!$room) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ruangan tidak ditemukan'
                    ]);
                }

                $request->validate([
                    'nama_ruang' => 'required|string|max:100|unique:rooms,nama_ruang,' . $id,
                    'deskripsi' => 'nullable|string',
                    'kapasitas' => 'nullable|integer|min:0',
                    'fasilitas' => 'nullable|string',
                    'foto' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
                ]);

                $namaRuang = trim($request->input('nama_ruang'));
                $deskripsi = trim($request->input('deskripsi'));
                $kapasitas = $request->input('kapasitas', 0);
                $fasilitas = trim($request->input('fasilitas', ''));

                // Update data ruangan
                DB::table('rooms')->where('id', $id)->update([
                    'nama_ruang' => $namaRuang,
                    'deskripsi' => $deskripsi,
                    'kapasitas' => $kapasitas,
                    'fasilitas' => $fasilitas,
                    'updated_at' => now(),
                ]);

                // Upload foto baru jika ada
                if ($request->hasFile('foto')) {
                    $foto = $request->file('foto');
                    $extension = $foto->getClientOriginalExtension();
                    $filename = 'room_' . $id . '_' . time() . '.' . $extension;

                    // Hapus foto lama jika ada
                    if ($room->foto_path) {
                        $oldPath = 'public/uploads/rooms/' . $room->foto_path;
                        if (Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }
                    }

                    $foto->storeAs('uploads/rooms', $filename, 'public');

                    DB::table('rooms')->where('id', $id)->update([
                        'foto_path' => $filename,
                        'updated_at' => now(),
                    ]);
                }

                $this->logActivity($request->session()->get('user_id'), 'Edit Ruangan', $namaRuang);

                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan berhasil diperbarui!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui ruangan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        return $this->updateLegacy($request, $id);
    }

    // Legacy method for non-AJAX fallback
    private function updateLegacy(Request $request, $id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room) {
            return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak ditemukan');
        }

        $request->validate([
            'nama_ruang' => 'required|string|max:100|unique:rooms,nama_ruang,' . $id,
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        $namaRuang = trim($request->input('nama_ruang'));
        $deskripsi = trim($request->input('deskripsi'));
        $kapasitas = $request->input('kapasitas', 0);
        $fasilitas = trim($request->input('fasilitas', ''));

        DB::beginTransaction();

        try {
            DB::table('rooms')->where('id', $id)->update([
                'nama_ruang' => $namaRuang,
                'deskripsi' => $deskripsi,
                'kapasitas' => $kapasitas,
                'fasilitas' => $fasilitas,
                'updated_at' => now(),
            ]);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $extension = $foto->getClientOriginalExtension();
                $filename = 'room_' . $id . '_' . time() . '.' . $extension;

                if ($room->foto_path) {
                    $oldPath = 'public/uploads/rooms/' . $room->foto_path;
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                $foto->storeAs('uploads/rooms', $filename, 'public');

                DB::table('rooms')->where('id', $id)->update([
                    'foto_path' => $filename,
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            $this->logActivity($request->session()->get('user_id'), 'Edit Ruangan', $namaRuang);

            return redirect('/admin/manage-rooms')->with('success', 'Ruangan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui ruangan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $room = DB::table('rooms')->where('id', $id)->first();
                if (!$room) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ruangan tidak ditemukan'
                    ]);
                }

                // Cek apakah ruangan digunakan di jadwal
                $used = DB::table('schedules')->where('ruang', $room->nama_ruang)->count();

                if ($used > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ruangan tidak dapat dihapus karena masih digunakan dalam jadwal!'
                    ]);
                }

                // Hapus foto jika ada
                if ($room->foto_path) {
                    $fotoPath = 'public/uploads/rooms/' . $room->foto_path;
                    if (Storage::exists($fotoPath)) {
                        Storage::delete($fotoPath);
                    }
                }

                DB::table('rooms')->where('id', $id)->delete();

                $this->logActivity($request->session()->get('user_id'), 'Hapus Ruangan', "ID: $id");

                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan berhasil dihapus!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus ruangan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room) {
            return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak ditemukan');
        }

        $used = DB::table('schedules')->where('ruang', $room->nama_ruang)->count();

        if ($used > 0) {
            return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak dapat dihapus karena masih digunakan dalam jadwal!');
        }

        DB::beginTransaction();

        try {
            if ($room->foto_path) {
                $fotoPath = 'public/uploads/rooms/' . $room->foto_path;
                if (Storage::exists($fotoPath)) {
                    Storage::delete($fotoPath);
                }
            }

            DB::table('rooms')->where('id', $id)->delete();

            DB::commit();

            $this->logActivity($request->session()->get('user_id'), 'Hapus Ruangan', "ID: $id");

            return redirect('/admin/manage-rooms')->with('success', 'Ruangan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/manage-rooms')->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }

    public function deletePhoto(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        if ($request->ajax()) {
            try {
                $room = DB::table('rooms')->where('id', $id)->first();
                if (!$room || !$room->foto_path) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Foto tidak ditemukan'
                    ]);
                }

                // Hapus file foto
                $fotoPath = 'public/uploads/rooms/' . $room->foto_path;
                if (Storage::exists($fotoPath)) {
                    Storage::delete($fotoPath);
                }

                // Update database
                DB::table('rooms')->where('id', $id)->update([
                    'foto_path' => null,
                    'updated_at' => now(),
                ]);

                $this->logActivity($request->session()->get('user_id'), 'Hapus Foto Ruangan', "Room: {$room->nama_ruang}");

                return response()->json([
                    'success' => true,
                    'message' => 'Foto ruangan berhasil dihapus!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus foto: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room || !$room->foto_path) {
            return redirect('/admin/manage-rooms')->with('error', 'Foto tidak ditemukan');
        }

        try {
            $fotoPath = 'public/uploads/rooms/' . $room->foto_path;
            if (Storage::exists($fotoPath)) {
                Storage::delete($fotoPath);
            }

            DB::table('rooms')->where('id', $id)->update([
                'foto_path' => null,
                'updated_at' => now(),
            ]);

            $this->logActivity($request->session()->get('user_id'), 'Hapus Foto Ruangan', "Room: {$room->nama_ruang}");

            return redirect('/admin/manage-rooms')->with('success', 'Foto ruangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-rooms')->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    private function logActivity($userId, $action, $description)
    {
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
