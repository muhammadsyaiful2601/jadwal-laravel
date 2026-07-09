<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $currentUserRole = $request->session()->get('role');
        $currentUserId = $request->session()->get('user_id');

        // Ambil statistik
        $stats = [];

        // Total jadwal per kelas
        $stats['per_kelas'] = DB::table('schedules')
            ->select('kelas', DB::raw('COUNT(*) as total'))
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get()
            ->toArray();

        // Total jadwal per hari
        $stats['per_hari'] = DB::table('schedules')
            ->select('hari', DB::raw('COUNT(*) as total'))
            ->groupBy('hari')
            ->orderByRaw("FIELD(hari, 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT')")
            ->get()
            ->toArray();

        // Total jadwal per ruangan
        $stats['per_ruangan'] = DB::table('schedules')
            ->select('ruang', DB::raw('COUNT(*) as total'))
            ->groupBy('ruang')
            ->orderBy('ruang')
            ->get()
            ->toArray();

        // Aktivitas per user
        $stats['aktivitas_user'] = DB::table('activity_logs as a')
            ->select('u.username', DB::raw('COUNT(a.id) as total'))
            ->leftJoin('users as u', 'a.user_id', '=', 'u.id')
            ->groupBy('a.user_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->toArray();

        // Statistik umum
        $stats['total_jadwal'] = DB::table('schedules')->count();
        $stats['total_kelas'] = DB::table('schedules')->distinct('kelas')->count('kelas');
        $stats['total_ruang_digunakan'] = DB::table('schedules')->distinct('ruang')->count('ruang');

        // Get maintenance status
        $maintenanceStatus = DB::table('settings')
            ->where('setting_key', 'maintenance_mode')
            ->value('setting_value');
        $isMaintenance = ($maintenanceStatus == '1');

        return view('admin.reports', compact(
            'stats',
            'isMaintenance',
            'currentUserRole',
            'currentUserId'
        ));
    }
}
