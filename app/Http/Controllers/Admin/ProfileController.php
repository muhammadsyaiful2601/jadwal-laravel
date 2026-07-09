<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $userId = $request->session()->get('user_id');
        $user = DB::table('users')->where('id', $userId)->first();

        // Get maintenance status
        $maintenanceStatus = DB::table('settings')
            ->where('setting_key', 'maintenance_mode')
            ->value('setting_value');
        $isMaintenance = ($maintenanceStatus == '1');

        $currentUserRole = $request->session()->get('role');
        $currentUserId = $request->session()->get('user_id');

        return view('admin.profile', compact(
            'user',
            'isMaintenance',
            'currentUserRole',
            'currentUserId'
        ));
    }

    public function update(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $userId = $request->session()->get('user_id');
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan');
        }

        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        // Validasi password saat ini
        if (empty($current_password)) {
            return redirect('/admin/profile')->with('error', 'Password saat ini harus diisi!');
        } else if (!Hash::check($current_password, $user->password)) {
            return redirect('/admin/profile')->with('error', 'Password saat ini salah!');
        }

        // Update data dasar
        $username = trim($request->input('username'));
        $email = $request->input('email');

        $updateData = [
            'username' => $username,
            'email' => $email,
            'updated_at' => now(),
        ];

        // Update password jika diisi
        if (!empty($new_password)) {
            if (strlen($new_password) < 6) {
                return redirect('/admin/profile')->with('error', 'Password baru minimal 6 karakter!');
            } else if ($new_password !== $confirm_password) {
                return redirect('/admin/profile')->with('error', 'Password baru dan konfirmasi tidak cocok!');
            } else {
                $updateData['password'] = Hash::make($new_password);
            }
        }

        DB::table('users')->where('id', $userId)->update($updateData);

        // Update session username
        $request->session()->put('username', $username);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => 'Update Profile',
            'description' => 'Memperbarui profil pengguna',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return redirect('/admin/profile')->with('success', 'Profile berhasil diperbarui!');
    }
}
