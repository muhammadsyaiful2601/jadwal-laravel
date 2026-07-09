<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get all semesters
        $semesters = DB::table('semester_settings')
            ->orderBy('tahun_akademik', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // Get active semester
        $activeSemester = DB::table('semester_settings')
            ->where('is_active', true)
            ->first();

        // Get maintenance status
        $maintenanceStatus = DB::table('settings')
            ->where('setting_key', 'maintenance_mode')
            ->value('setting_value');
        $isMaintenance = ($maintenanceStatus == '1');

        return view('admin.manage-semester', compact(
            'semesters',
            'activeSemester',
            'isMaintenance'
        ));
    }

    public function store(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $request->validate([
            'tahun_akademik' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'semester' => 'required|string|in:GANJIL,GENAP',
        ]);

        $tahunAkademik = trim($request->input('tahun_akademik'));
        $semester = $request->input('semester');

        // Check if semester already exists
        $exists = DB::table('semester_settings')
            ->where('tahun_akademik', $tahunAkademik)
            ->where('semester', $semester)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Semester ini sudah ada!')->withInput();
        }

        DB::table('semester_settings')->insert([
            'tahun_akademik' => $tahunAkademik,
            'semester' => $semester,
            'is_active' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->logActivity(
            $request->session()->get('user_id'),
            'Tambah Semester',
            "$semester $tahunAkademik"
        );

        return redirect('/admin/manage-semester')->with('success', 'Semester berhasil ditambahkan!');
    }

    public function setActive(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $semester = DB::table('semester_settings')->where('id', $id)->first();

        if (!$semester) {
            return redirect('/admin/manage-semester')->with('error', 'Semester tidak ditemukan');
        }

        // Deactivate all semesters
        DB::table('semester_settings')->update(['is_active' => false]);

        // Activate selected semester
        DB::table('semester_settings')->where('id', $id)->update([
            'is_active' => true,
            'updated_at' => now(),
        ]);

        $this->logActivity(
            $request->session()->get('user_id'),
            'Ubah Semester Aktif',
            "{$semester->semester} {$semester->tahun_akademik}"
        );

        return redirect('/admin/manage-semester')->with('success', 'Semester aktif berhasil diubah!');
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $semester = DB::table('semester_settings')->where('id', $id)->first();

        if (!$semester) {
            return redirect('/admin/manage-semester')->with('error', 'Semester tidak ditemukan');
        }

        // Check if this is the active semester
        if ($semester->is_active) {
            return redirect('/admin/manage-semester')->with('error', 'Tidak bisa menghapus semester aktif!');
        }

        // Check if semester has schedules
        $scheduleCount = DB::table('schedules')
            ->where('tahun_akademik', $semester->tahun_akademik)
            ->where('semester', $semester->semester)
            ->count();

        if ($scheduleCount > 0) {
            return redirect('/admin/manage-semester')->with(
                'error',
                'Tidak bisa menghapus semester yang memiliki ' . $scheduleCount . ' jadwal!'
            );
        }

        DB::table('semester_settings')->where('id', $id)->delete();

        $this->logActivity(
            $request->session()->get('user_id'),
            'Hapus Semester',
            "{$semester->semester} {$semester->tahun_akademik}"
        );

        return redirect('/admin/manage-semester')->with('success', 'Semester berhasil dihapus!');
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
