<?php

use App\Models\Setting;

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
