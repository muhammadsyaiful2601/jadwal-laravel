<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get all settings
        $settings = [];
        $settingsData = DB::table('settings')->get();
        foreach ($settingsData as $setting) {
            $settings[$setting->setting_key] = $setting->setting_value;
        }

        // Get maintenance status
        $maintenanceStatus = DB::table('settings')
            ->where('setting_key', 'maintenance_mode')
            ->value('setting_value');
        $isMaintenance = ($maintenanceStatus == '1');

        // Check if superadmin
        $isSuperAdmin = $request->session()->get('role') === 'superadmin';

        return view('admin.manage-settings', compact(
            'settings',
            'isMaintenance',
            'isSuperAdmin'
        ));
    }

    public function update(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Update all settings from form
        $settingsToUpdate = [
            'tahun_akademik',
            'institusi_nama',
            'institusi_lokasi',
            'program_studi',
            'fakultas',
            'admin_email',
            'running_text_enabled',
            'running_text_content',
            'running_text_speed',
            'running_text_color',
            'running_text_bg_color',
            'max_login_attempts',
            'header_logo_type',
            'header_title_1',
            'header_title_2',
        ];

        foreach ($settingsToUpdate as $key) {
            $value = $request->input($key, '');

            // Handle checkbox for running_text_enabled
            if ($key === 'running_text_enabled') {
                $value = $request->has('running_text_enabled') ? '1' : '0';
            }

            DB::table('settings')->updateOrInsert(
                ['setting_key' => $key],
                [
                    'setting_value' => $value,
                    'updated_at' => now(),
                ]
            );
        }

        // Invalidate all cache to ensure settings changes are immediately visible
        if (\Illuminate\Support\Facades\Cache::getStore() instanceof \Illuminate\Cache\NullStore) {
            // Do nothing if cache is disabled
        } else {
            \Illuminate\Support\Facades\Cache::flush();
        }

        $this->logActivity($request->session()->get('user_id'), 'Update Settings', 'Memperbarui pengaturan sistem');

        return redirect('/admin/manage-settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function resetData(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        try {
            DB::beginTransaction();

            // Delete all schedules
            DB::table('schedules')->delete();

            // Delete all activity logs
            DB::table('activity_logs')->delete();

            DB::commit();

            $this->logActivity($request->session()->get('user_id'), 'Reset Data Jadwal', 'Menghapus semua data jadwal dan log');

            return redirect('/admin/manage-settings')->with('success', 'Semua data jadwal berhasil direset!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/manage-settings')->with('error', 'Gagal reset data: ' . $e->getMessage());
        }
    }

    public function clearLogs(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        try {
            DB::table('activity_logs')->delete();

            $this->logActivity($request->session()->get('user_id'), 'Hapus Log Aktivitas', 'Menghapus semua log aktivitas');

            return redirect('/admin/manage-settings')->with('success', 'Semua log aktivitas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')->with('error', 'Gagal menghapus log: ' . $e->getMessage());
        }
    }

    public function backupDatabase(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        // For now, just show a message (actual backup implementation would require additional packages)
        $this->logActivity($request->session()->get('user_id'), 'Backup Database', 'Mencoba backup database');

        return redirect('/admin/manage-settings')->with('info', 'Fitur backup database sedang dalam pengembangan. Silakan hubungi administrator sistem.');
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
