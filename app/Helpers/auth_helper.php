<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

if (!function_exists('formatLockoutTime')) {
    function formatLockoutTime($seconds)
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

if (!function_exists('getProgressBarClass')) {
    function getProgressBarClass($percentage)
    {
        if ($percentage >= 80) return 'progress-locked';
        if ($percentage >= 60) return 'progress-danger';
        if ($percentage >= 40) return 'progress-warning';
        return 'progress-caution';
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        return Setting::getValue($key, $default);
    }
}

if (!function_exists('isSuperadminVerified')) {
    /**
     * Check if the currently logged-in superadmin has verified their email.
     * Returns true if:
     * - User is not logged in
     * - User is not a superadmin
     * - User is a superadmin and email is verified
     * Returns false only if user is a superadmin with unverified email.
     */
    function isSuperadminVerified($session)
    {
        $role = $session->get('role');

        // Only applies to superadmin
        if ($role !== 'superadmin') {
            return true;
        }

        $userId = $session->get('user_id');
        if (!$userId) {
            return true;
        }

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return true;
        }

        // Superadmin is considered verified if email_verified_at is not null
        return !is_null($user->email_verified_at);
    }
}
