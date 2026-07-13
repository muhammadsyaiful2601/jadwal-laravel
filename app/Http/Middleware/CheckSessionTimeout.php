<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckSessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session tersedia dan user sudah login
        if ($request->hasSession() && (Auth::check() || $request->session()->has('user_id'))) {
            $userId = $request->session()->get('user_id');

            // Ambil setting session timeout (dalam menit)
            $sessionTimeout = (int) DB::table('settings')
                ->where('setting_key', 'session_timeout_minutes')
                ->value('setting_value') ?: 30; // Default 30 menit

            // Cek apakah ada aktivitas terakhir yang tercatat
            $lastActivityTime = $request->session()->get('last_activity_time');
            $currentTime = time();

            // Jika ada waktu aktivitas terakhir
            if ($lastActivityTime) {
                // Cek apakah sudah melebihi timeout (dalam detik)
                $timeoutSeconds = $sessionTimeout * 60;
                if (($currentTime - $lastActivityTime) > $timeoutSeconds) {
                    // Session expired, lakukan logout
                    $this->logoutUser($request);

                    // Redirect ke login dengan pesan expired
                    return redirect('/login?expired=1');
                }
            }

            // Update waktu aktivitas terakhir
            $request->session()->put('last_activity_time', $currentTime);
        }

        return $next($request);
    }

    private function logoutUser(Request $request)
    {
        $userId = $request->session()->get('user_id');

        // Log activity logout
        if ($userId) {
            DB::table('activity_logs')->insert([
                'user_id' => $userId,
                'action' => 'Auto Logout (Session Timeout)',
                'description' => 'Automatic logout due to session timeout (inactivity)',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        }

        // Hapus session
        $request->session()->forget(['user_id', 'username', 'role', 'last_activity_time']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Logout dari Auth juga jika menggunakan Auth::check()
        if (Auth::check()) {
            Auth::logout();
        }
    }
}
