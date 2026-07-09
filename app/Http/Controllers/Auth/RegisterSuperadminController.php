<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterSuperadminController extends Controller
{
    public function showRegisterForm()
    {
        // Cek apakah superadmin sudah terdaftar
        $superadminRegistered = Setting::getValue('superadmin_registered', '0');

        if ($superadminRegistered == '1') {
            return redirect('/login');
        }

        return view('auth.register-superadmin');
    }

    public function register(Request $request)
    {
        // Cek apakah superadmin sudah terdaftar
        $superadminRegistered = Setting::getValue('superadmin_registered', '0');

        if ($superadminRegistered == '1') {
            return redirect('/login');
        }

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'nullable|email|max:100',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            // Insert superadmin
            DB::table('users')->insert([
                'username' => $username,
                'password' => Hash::make($password),
                'email' => $email,
                'role' => 'superadmin',
                'is_active' => true,
                'failed_attempts' => 0,
                'lockout_multiplier' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update setting bahwa superadmin sudah terdaftar
            Setting::getValue('superadmin_registered', '0');
            // Update using DB directly since Setting model doesn't have update method
            DB::table('settings')->where('setting_key', 'superadmin_registered')->update([
                'setting_value' => '1',
                'updated_at' => now(),
            ]);

            return redirect('/login')->with('success', 'Super Admin berhasil didaftarkan! Silakan login.');
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('username', 'email'))
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
