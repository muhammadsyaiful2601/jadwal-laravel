<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Check if the current superadmin user has verified their email.
     * If not verified, block all write/action requests by redirecting to profile.
     * AJAX requests receive a 403 response.
     * Returns true if verified or if user is not a superadmin.
     */
    protected function checkSuperadminVerified(Request $request)
    {
        $role = $request->session()->get('role');

        // Only applies to superadmin
        if ($role !== 'superadmin') {
            return true;
        }

        $userId = $request->session()->get('user_id');
        if (!$userId) {
            return true;
        }

        $user = \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return true;
        }

        $isVerified = !is_null($user->email_verified_at);

        if (!$isVerified) {
            // Block all write/action requests regardless of HTTP method
            if ($request->ajax()) {
                abort(403, 'Akun superadmin belum terverifikasi. Silakan verifikasi email terlebih dahulu.');
            }
            return redirect('/admin/profile')
                ->with('error', 'Akun superadmin belum terverifikasi. Silakan verifikasi email terlebih dahulu untuk mengakses fitur ini.');
        }

        return $isVerified;
    }
}