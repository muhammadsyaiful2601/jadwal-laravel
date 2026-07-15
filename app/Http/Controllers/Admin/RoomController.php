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
        // Check if user is authenticated
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get all rooms
        $rooms = DB::table('rooms')->orderBy('nama_ruang')->get();

        // Calculate stats
        $totalRooms = $rooms->count();
        $withPhoto = $rooms->where('foto_path', '!=', '')->whereNotNull('foto_path')->count();
        $totalCapacity = $rooms->sum('kapasitas');

        // Count rooms that are used in schedules
        $usedRoomNames = DB::table('schedules')->distinct()->pluck('ruang')->toArray();
        $usedCount = $rooms->whereIn('nama_ruang', $usedRoomNames)->count();

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

        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $data = [
                'nama_ruang' => $request->input('nama_ruang'),
                'kapasitas' => $request->input('kapasitas', 0),
                'fasilitas' => $request->input('fasilitas', ''),
                'deskripsi' => $request->input('deskripsi', ''),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Handle photo upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads/rooms', $filename, 'public');
                $data['foto_path'] = $filename;
            }

            DB::table('rooms')->insert($data);

            $this->logActivity(
                $request->session()->get('user_id'),
                'Tambah Ruangan',
                "Ruangan: {$request->input('nama_ruang')}"
            );

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan berhasil ditambahkan!'
                ]);
            }

            return redirect('/admin/manage-rooms')->with('success', 'Ruangan berhasil ditambahkan!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }

            return redirect('/admin/manage-rooms')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id = null)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // Get ID from request if not in URL
        if (!$id) {
            $id = $request->input('id');
        }

        $room = DB::table('rooms')->where('id', $id)->first();
        if (!$room) {
            return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak ditemukan.');
        }

        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $data = [
                'nama_ruang' => $request->input('nama_ruang'),
                'kapasitas' => $request->input('kapasitas', 0),
                'fasilitas' => $request->input('fasilitas', ''),
                'deskripsi' => $request->input('deskripsi', ''),
                'updated_at' => now(),
            ];

            // Handle photo upload
            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($room->foto_path) {
                    Storage::disk('public')->delete('uploads/rooms/' . $room->foto_path);
                }

                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads/rooms', $filename, 'public');
                $data['foto_path'] = $filename;
            }

            DB::table('rooms')->where('id', $id)->update($data);

            $this->logActivity(
                $request->session()->get('user_id'),
                'Edit Ruangan',
                "Ruangan: {$request->input('nama_ruang')}"
            );

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan berhasil diperbarui!'
                ]);
            }

            return redirect('/admin/manage-rooms')->with('success', 'Ruangan berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }

            return redirect('/admin/manage-rooms')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

        try {
            $room = DB::table('rooms')->where('id', $id)->first();
            if (!$room) {
                return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak ditemukan.');
            }

            // Delete photo if exists
            if ($room->foto_path) {
                Storage::disk('public')->delete('uploads/rooms/' . $room->foto_path);
            }

            DB::table('rooms')->where('id', $id)->delete();

            $this->logActivity(
                $request->session()->get('user_id'),
                'Hapus Ruangan',
                "Ruangan: {$room->nama_ruang}"
            );

            return redirect('/admin/manage-rooms')->with('success', 'Ruangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-rooms')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deletePhoto(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        try {
            $room = DB::table('rooms')->where('id', $id)->first();
            if (!$room) {
                return redirect('/admin/manage-rooms')->with('error', 'Ruangan tidak ditemukan.');
            }

            if ($room->foto_path) {
                Storage::disk('public')->delete('uploads/rooms/' . $room->foto_path);
                DB::table('rooms')->where('id', $id)->update([
                    'foto_path' => null,
                    'updated_at' => now(),
                ]);

                $this->logActivity(
                    $request->session()->get('user_id'),
                    'Hapus Foto Ruangan',
                    "Ruangan: {$room->nama_ruang}"
                );
            }

            return redirect('/admin/manage-rooms')->with('success', 'Foto ruangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-rooms')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
