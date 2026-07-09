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

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $extension = $foto->getClientOriginalExtension();
                $filename = 'room_' . $roomId . '_' . time() . '.' . $extension;

                // Store in public/uploads/rooms
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

    public function update(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

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

                // Upload foto baru
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

        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room) {
            return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak ditemukan');
        }

        // Cek apakah ruangan digunakan di jadwal
        $used = DB::table('schedules')->where('ruang', $room->nama_ruang)->count();

        if ($used > 0) {
            return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak dapat dihapus karena masih digunakan dalam jadwal!');
        }

        DB::beginTransaction();

        try {
            // Hapus foto jika ada
            if ($room->foto_path) {
                $fotoPath = 'public/uploads/rooms/' . $room->foto_path;
                if (Storage::exists($fotoPath)) {
                    Storage::delete($fotoPath);
                }
            }

            // Hapus data ruangan
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

        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room || !$room->foto_path) {
            return redirect('/admin/manage-rooms')->with('error', 'Foto tidak ditemukan');
        }

        try {
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
