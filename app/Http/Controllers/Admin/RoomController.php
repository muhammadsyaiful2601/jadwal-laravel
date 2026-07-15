<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    // Fungsi pembantu untuk mendapatkan nama disk secara dinamis dari .env
    private function getDisk()
    {
        return config('filesystems.default');
    }

    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $rooms = DB::table('rooms')->orderBy('nama_ruang')->get();

        $totalRooms = $rooms->count();
        $withPhoto = $rooms->where('foto_path', '!=', null)->count();
        $totalCapacity = $rooms->sum('kapasitas');

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

                if ($request->hasFile('foto')) {
                    $foto = $request->file('foto');
                    $extension = $foto->getClientOriginalExtension();
                    $filename = 'room_' . $roomId . '_' . time() . '.' . $extension;

                    // Mengunggah secara dinamis sesuai disk (.env) dengan visibilitas public
                    Storage::disk($this->getDisk())->putFileAs('uploads/rooms', $foto, $filename, 'public');

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

        return $this->storeLegacy($request);
    }

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

                Storage::disk($this->getDisk())->putFileAs('uploads/rooms', $foto, $filename, 'public');

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

                    // Hapus foto lama dari disk yang aktif
                    if ($room->foto_path) {
                        $oldPath = 'uploads/rooms/' . $room->foto_path;
                        if (Storage::disk($this->getDisk())->exists($oldPath)) {
                            Storage::disk($this->getDisk())->delete($oldPath);
                        }
                    }

                    Storage::disk($this->getDisk())->putFileAs('uploads/rooms', $foto, $filename, 'public');

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

        return $this->updateLegacy($request, $id);
    }

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
                    $oldPath = 'uploads/rooms/' . $room->foto_path;
                    if (Storage::disk($this->getDisk())->exists($oldPath)) {
                        Storage::disk($this->getDisk())->delete($oldPath);
                    }
                }

                Storage::disk($this->getDisk())->putFileAs('uploads/rooms', $foto, $filename, 'public');

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

                $used = DB::table('schedules')->where('ruang', $room->nama_ruang)->count();
                if ($used > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ruangan tidak dapat dihapus karena masih digunakan dalam jadwal!'
                    ]);
                }

                if ($room->foto_path) {
                    $fotoPath = 'uploads/rooms/' . $room->foto_path;
                    if (Storage::disk($this->getDisk())->exists($fotoPath)) {
                        Storage::disk($this->getDisk())->delete($fotoPath);
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

        return $this->destroyLegacy($request, $id);
    }

    private function destroyLegacy(Request $request, $id)
    {
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
                $fotoPath = 'uploads/rooms/' . $room->foto_path;
                if (Storage::disk($this->getDisk())->exists($fotoPath)) {
                    Storage::disk($this->getDisk())->delete($fotoPath);
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

                $fotoPath = 'uploads/rooms/' . $room->foto_path;
                if (Storage::disk($this->getDisk())->exists($fotoPath)) {
                    Storage::disk($this->getDisk())->delete($fotoPath);
                }

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

        return $this->deletePhotoLegacy($request, $id);
    }

    private function deletePhotoLegacy(Request $request, $id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room || !$room->foto_path) {
            return redirect('/admin/manage-rooms')->with('error', 'Foto tidak ditemukan');
        }

        try {
            $fotoPath = 'uploads/rooms/' . $room->foto_path;
            if (Storage::disk($this->getDisk())->exists($fotoPath)) {
                Storage::disk($this->getDisk())->delete($fotoPath);
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

    private function checkSuperadminVerified(Request $request)
    {
        return true;
    }
}
