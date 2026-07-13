<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Cek apakah session expired
        $sessionExpired = $request->query('expired') == 1;

        // Cek apakah sudah ada superadmin
        $superadminExists = DB::table('users')
            ->where('role', 'superadmin')
            ->exists();

        // Get lockout settings
        $maxLoginAttempts = Setting::getValue('max_login_attempts', '5');
        $initialDuration = Setting::getValue('lockout_initial_duration', '15');

        // Get session timeout settings
        $sessionTimeoutMinutes = (int) Setting::getValue('session_timeout_minutes', '30');

        // Get flash messages from session
        $error = session('error');
        $lockoutUsername = session('lockout_username');
        $lockoutTime = session('lockout_time');
        $multiplier = session('multiplier', 1);
        $attemptsInfo = session('attempts_info');
        $showProgress = session('show_progress', false);
        $inactiveAccount = session('inactive_account');

        return view('auth.login', compact(
            'sessionExpired',
            'superadminExists',
            'maxLoginAttempts',
            'initialDuration',
            'sessionTimeoutMinutes',
            'error',
            'lockoutUsername',
            'lockoutTime',
            'multiplier',
            'attemptsInfo',
            'showProgress',
            'inactiveAccount'
        ));
    }

    public function login(Request $request)
    {
        // Check if AJAX request
        if ($request->ajax()) {
            $credentials = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $username = $credentials['username'];
            $password = $credentials['password'];

            // Find user
            $user = DB::table('users')->where('username', $username)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username tidak ditemukan'
                ]);
            }

            // Check if account is inactive
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun ' . $username . ' telah dinonaktifkan'
                ]);
            }

            // Check if email is verified (for non-superadmin accounts)
            if ($user->role !== 'superadmin' && !$user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun ' . $username . ' belum terverifikasi. Silakan hubungi superadmin untuk verifikasi email.'
                ]);
            }

            // Check if account is locked
            if ($user->locked_until && strtotime($user->locked_until) > time()) {
                $remaining = strtotime($user->locked_until) - time();
                $formatted = $this->formatLockoutTime($remaining);

                return response()->json([
                    'success' => false,
                    'locked' => true,
                    'message' => "Akun '$username' terkunci. Silakan coba lagi dalam {$formatted}",
                    'lockout_time' => $remaining,
                    'multiplier' => $user->lockout_multiplier ?? 1,
                    'attempts_info' => $this->getRemainingAttemptsInfo($user->id)
                ]);
            }

            // Verify password
            if (Hash::check($password, $user->password)) {
                // Reset failed attempts
                DB::table('users')->where('id', $user->id)->update([
                    'failed_attempts' => 0,
                    'locked_until' => null,
                    'lockout_multiplier' => 1,
                    'last_failed_attempt' => null,
                    'last_login' => now(),
                ]);

                // Manual login
                Auth::loginUsingId($user->id);
                session([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                ]);

                // Log activity
                DB::table('activity_logs')->insert([
                    'user_id' => $user->id,
                    'action' => 'Login',
                    'description' => 'Login berhasil',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'created_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'redirect' => url('/admin/dashboard')
                ]);
            } else {
                // Handle failed login
                $result = $this->handleFailedLogin($user->id);

                if ($result && isset($result['locked']) && $result['locked']) {
                    $formatted = $this->formatLockoutTime($result['duration']);
                    return response()->json([
                        'success' => false,
                        'locked' => true,
                        'message' => "Terlalu banyak percobanan gagal. Akun '$username' terkunci selama {$formatted}",
                        'lockout_time' => $result['duration'],
                        'multiplier' => $result['multiplier'] ?? 1,
                        'attempts_info' => $this->getRemainingAttemptsInfo($user->id)
                    ]);
                }

                $attemptsInfo = $this->getRemainingAttemptsInfo($user->id);
                $attemptsLeft = $attemptsInfo['attempts_left'] ?? 0;

                $errorMsg = "Password salah!";
                if ($attemptsLeft <= 2) {
                    $errorMsg .= " Percobaan tersisa: {$attemptsLeft}. Akun akan terkunci setelah percobaan terakhir.";
                } else {
                    $errorMsg .= " Percobaan tersisa: {$attemptsLeft}";
                }

                return response()->json([
                    'success' => false,
                    'message' => $errorMsg,
                    'show_progress' => true,
                    'attempts_info' => $attemptsInfo
                ]);
            }
        }

        // Non-AJAX fallback
        return $this->loginLegacy($request);
    }

    // Legacy method for non-AJAX fallback
    private function loginLegacy(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $credentials['username'];
        $password = $credentials['password'];

        $user = DB::table('users')->where('username', $username)->first();

        if (!$user) {
            return back()->withInput($request->only('username'))->with('error', 'Username tidak ditemukan');
        }

        if (!$user->is_active) {
            return back()->withInput($request->only('username'))->with('inactive_account', true)->with('error', 'Akun ' . $username . ' telah dinonaktifkan');
        }

        // Check if email is verified (for non-superadmin accounts)
        if ($user->role !== 'superadmin' && !$user->email_verified_at) {
            return back()->withInput($request->only('username'))->with('error', 'Akun ' . $username . ' belum terverifikasi. Silakan hubungi superadmin untuk verifikasi email.');
        }

        if ($user->locked_until && strtotime($user->locked_until) > time()) {
            $remaining = strtotime($user->locked_until) - time();
            $formatted = $this->formatLockoutTime($remaining);
            $multiplierInfo = $this->getLockoutMultiplierInfo($user->id);
            $multiplier = $multiplierInfo['multiplier'] ?? 1;

            return back()
                ->withInput($request->only('username'))
                ->with('error', "Akun '$username' terkunci. Silakan coba lagi dalam {$formatted}")
                ->with('lockout_username', $username)
                ->with('lockout_time', $remaining)
                ->with('multiplier', $multiplier)
                ->with('attempts_info', $this->getRemainingAttemptsInfo($user->id));
        }

        if (Hash::check($password, $user->password)) {
            DB::table('users')->where('id', $user->id)->update([
                'failed_attempts' => 0,
                'locked_until' => null,
                'lockout_multiplier' => 1,
                'last_failed_attempt' => null,
                'last_login' => now(),
            ]);

            Auth::loginUsingId($user->id);
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]);

            DB::table('activity_logs')->insert([
                'user_id' => $user->id,
                'action' => 'Login',
                'description' => 'Login berhasil',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return redirect('/admin/dashboard');
        } else {
            $result = $this->handleFailedLogin($user->id);

            if ($result && isset($result['locked']) && $result['locked']) {
                $formatted = $this->formatLockoutTime($result['duration']);
                return back()
                    ->withInput($request->only('username'))
                    ->with('error', "Terlalu banyak percobanan gagal. Akun '$username' terkunci selama {$formatted}")
                    ->with('lockout_username', $username)
                    ->with('lockout_time', $result['duration'])
                    ->with('multiplier', $result['multiplier'] ?? 1)
                    ->with('attempts_info', $this->getRemainingAttemptsInfo($user->id));
            }

            $attemptsInfo = $this->getRemainingAttemptsInfo($user->id);
            $attemptsLeft = $attemptsInfo['attempts_left'] ?? 0;

            $errorMsg = "Password salah!";
            if ($attemptsLeft <= 2) {
                $errorMsg .= " <strong>Percobaan tersisa: {$attemptsLeft}</strong>. Akun akan terkunci setelah percobaan terakhir.";
            } else {
                $errorMsg .= " Percobaan tersisa: {$attemptsLeft}";
            }

            return back()
                ->withInput($request->only('username'))
                ->with('error', $errorMsg)
                ->with('show_progress', true)
                ->with('attempts_info', $attemptsInfo);
        }
    }

    public function logout(Request $request)
    {
        // Handle AJAX logout
        if ($request->ajax()) {
            if (Auth::check()) {
                DB::table('activity_logs')->insert([
                    'user_id' => Auth::id(),
                    'action' => 'Logout',
                    'description' => 'Logout berhasil',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'created_at' => now(),
                ]);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
                'redirect' => url('/login')
            ]);
        }

        // Non-AJAX fallback
        if (Auth::check()) {
            DB::table('activity_logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'Logout',
                'description' => 'Logout berhasil',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function handleFailedLogin($userId)
    {
        $maxAttempts = (int) Setting::getValue('max_login_attempts', '5');
        $initialDuration = (int) Setting::getValue('lockout_initial_duration', '15');
        $maxMultiplier = (int) Setting::getValue('lockout_max_multiplier', '10');

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) return false;

        $failedAttempts = $user->failed_attempts + 1;
        $currentMultiplier = $user->lockout_multiplier;

        if ($failedAttempts >= $maxAttempts) {
            $lockoutSeconds = $initialDuration * pow(2, $currentMultiplier - 1);
            $newMultiplier = min($currentMultiplier + 1, $maxMultiplier);
            $lockedUntil = now()->addSeconds($lockoutSeconds);

            DB::table('users')->where('id', $userId)->update([
                'failed_attempts' => $failedAttempts,
                'locked_until' => $lockedUntil,
                'lockout_multiplier' => $newMultiplier,
                'last_failed_attempt' => now(),
            ]);

            DB::table('activity_logs')->insert([
                'user_id' => $userId,
                'action' => 'Account Locked',
                'description' => "Akun terkunci selama {$lockoutSeconds} detik (Level Lockout: {$currentMultiplier})",
                'created_at' => now(),
            ]);

            return [
                'locked' => true,
                'duration' => $lockoutSeconds,
                'multiplier' => $currentMultiplier,
            ];
        } else {
            DB::table('users')->where('id', $userId)->update([
                'failed_attempts' => $failedAttempts,
                'last_failed_attempt' => now(),
            ]);

            return ['locked' => false];
        }
    }

    private function getRemainingAttemptsInfo($userId)
    {
        $maxAttempts = (int) Setting::getValue('max_login_attempts', '5');
        $user = DB::table('users')->where('id', $userId)->first(['failed_attempts', 'locked_until']);

        if (!$user) return null;

        $failedAttempts = $user->failed_attempts;
        $attemptsLeft = $maxAttempts - $failedAttempts;
        $isLocked = $user->locked_until && strtotime($user->locked_until) > time();

        return [
            'failed_attempts' => $failedAttempts,
            'attempts_left' => $attemptsLeft,
            'is_locked' => $isLocked,
            'max_attempts' => $maxAttempts,
            'percentage' => ($failedAttempts / $maxAttempts) * 100,
        ];
    }

    private function getLockoutMultiplierInfo($userId)
    {
        $user = DB::table('users')->where('id', $userId)->first(['lockout_multiplier']);
        return $user ? ['multiplier' => $user->lockout_multiplier] : null;
    }

    private function formatLockoutTime($seconds)
    {
        if ($seconds < 60) {
            return "{$seconds} detik";
        } elseif ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            $secs = $seconds % 60;
            return "{$minutes} menit " . ($secs > 0 ? "{$secs} detik" : '');
        } else {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            return "{$hours} jam " . ($minutes > 0 ? "{$minutes} menit" : '');
        }
    }
}
