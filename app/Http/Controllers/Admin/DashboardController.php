<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get stats
        $stats = [];
        $stats['total_jadwal'] = DB::table('schedules')->count();
        $stats['total_ruangan'] = DB::table('rooms')->count();
        $stats['total_kelas'] = DB::table('schedules')->distinct('kelas')->count('kelas');
        $stats['total_saran'] = DB::table('suggestions')->count();
        $stats['pending_saran'] = DB::table('suggestions')->where('status', 'pending')->count();

        // Get maintenance status
        $isMaintenance = Setting::getValue('maintenance_mode', '0') == '1';

        // Get recent activities
        $activities = DB::table('activity_logs as a')
            ->leftJoin('users as u', 'a.user_id', '=', 'u.id')
            ->select('a.*', 'u.username')
            ->orderBy('a.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'isMaintenance',
            'activities'
        ));
    }
}
