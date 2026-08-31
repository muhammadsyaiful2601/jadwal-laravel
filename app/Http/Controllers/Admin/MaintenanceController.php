<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get maintenance status
        $isMaintenance = Setting::getValue('maintenance_mode', '0') == '1';

        // Get maintenance message
        $currentMessage = Setting::getValue('maintenance_message', 'Sistem sedang dalam perbaikan untuk peningkatan layanan. Mohon maaf atas ketidaknyamanannya.');

        // Get maintenance logs
        $maintenanceLogs = DB::table('activity_logs as al')
            ->leftJoin('users as u', 'al.user_id', '=', 'u.id')
            ->where('al.action', 'like', '%Maintenance%')
            ->select('al.*', 'u.username')
            ->orderBy('al.created_at', 'desc')
            ->limit(10)
            ->get();

        // Get maintenance count
        $maintenanceCount = DB::table('activity_logs')->where('action', 'like', '%Maintenance%')->count();

        return view('admin.maintenance', compact(
            'isMaintenance',
            'currentMessage',
            'maintenanceLogs',
            'maintenanceCount'
        ));
    }

    public function toggle(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        $isMaintenance = Setting::getValue('maintenance_mode', '0') == '1';
        $newStatus = $isMaintenance ? '0' : '1';

        // Update setting
        DB::table('settings')->updateOrInsert(
            ['setting_key' => 'maintenance_mode'],
            [
                'setting_value' => $newStatus,
                'updated_at' => now(),
            ]
        );

        // Log activity
        $action = $newStatus == '1' ? 'Aktifkan Maintenance Mode' : 'Nonaktifkan Maintenance Mode';
        DB::table('activity_logs')->insert([
            'user_id' => $request->session()->get('user_id'),
            'action' => $action,
            'description' => $action,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return redirect('/admin/maintenance')->with('success', 'Status maintenance berhasil diubah!');
    }

    public function updateMessage(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $request->validate([
            'maintenance_message' => 'required|string|min:10',
        ]);

        $message = trim($request->input('maintenance_message'));

        if (mb_strlen($message) < 10) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['maintenance_message' => ['Pesan maintenance minimal 10 karakter.']]
                ], 422);
            }
            return back()->with('error', 'Pesan maintenance minimal 10 karakter.')->withInput();
        }

        // Update setting
        DB::table('settings')->updateOrInsert(
            ['setting_key' => 'maintenance_message'],
            [
                'setting_value' => $message,
                'updated_at' => now(),
            ]
        );

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => $request->session()->get('user_id'),
            'action' => 'Update Maintenance Message',
            'description' => 'Update pesan maintenance',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan maintenance berhasil diperbarui!'
            ]);
        }

        return redirect('/admin/maintenance')->with('success', 'Pesan maintenance berhasil diperbarui!');
    }
}
