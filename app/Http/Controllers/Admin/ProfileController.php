<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        $userId = $request->session()->get('user_id');
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan');
        }

        $updateData = [
            'updated_at' => now(),
        ];

        // Update username (tidak perlu password)
        $username = trim($request->input('username'));
        if (!empty($username) && $username !== $user->username) {
            $updateData['username'] = $username;
        }

        // Update phone (tidak perlu password)
        $phone = trim($request->input('phone', ''));
        if ($phone !== ($user->phone ?? '')) {
            $updateData['phone'] = $phone ?: null;
        }

        // Handle foto upload (tidak perlu password)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedTypes)) {
                return redirect('/admin/profile')->with('error', 'Format foto harus JPG, JPEG, PNG, GIF, atau WEBP!');
            }

            if ($file->getSize() > 2048 * 1024) {
                return redirect('/admin/profile')->with('error', 'Ukuran foto maksimal 2MB!');
            }

            // Delete old foto if exists
            if ($user->foto) {
                $oldPath = public_path(str_replace(url('/'), '', $user->foto));
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Store new foto to public/uploads/profile
            $uploadDir = public_path('uploads/profile');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filename = 'user_' . $userId . '_' . time() . '.' . $extension;
            $file->move($uploadDir, $filename);
            $updateData['foto'] = '/uploads/profile/' . $filename;
        }

        // Update email (perlu password)
        $email = $request->input('email');
        if (!empty($email) && $email !== $user->email) {
            $current_password = $request->input('current_password');
            if (empty($current_password)) {
                return redirect('/admin/profile')->with('error', 'Password saat ini harus diisi untuk mengubah email!');
            } else if (!Hash::check($current_password, $user->password)) {
                return redirect('/admin/profile')->with('error', 'Password saat ini salah!');
            }
            $updateData['email'] = $email;
        }

        // Update password (perlu password lama)
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        if (!empty($new_password)) {
            $current_password = $request->input('current_password');
            if (empty($current_password)) {
                return redirect('/admin/profile')->with('error', 'Password saat ini harus diisi untuk mengubah password!');
            } else if (!Hash::check($current_password, $user->password)) {
                return redirect('/admin/profile')->with('error', 'Password saat ini salah!');
            }

            if (strlen($new_password) < 6) {
                return redirect('/admin/profile')->with('error', 'Password baru minimal 6 karakter!');
            } else if ($new_password !== $confirm_password) {
                return redirect('/admin/profile')->with('error', 'Password baru dan konfirmasi tidak cocok!');
            } else {
                $updateData['password'] = Hash::make($new_password);
            }
        }

        // Only update if there are changes
        if (count($updateData) > 1) {
            DB::table('users')->where('id', $userId)->update($updateData);
        }

        // Update session
        if (isset($updateData['username'])) {
            $request->session()->put('username', $updateData['username']);
        } else {
            $request->session()->put('username', $user->username);
        }
        if (isset($updateData['foto'])) {
            $request->session()->put('user_foto', $updateData['foto']);
        }

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

    public function changePassword(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Hanya superadmin yang bisa akses
        $role = $request->session()->get('role');
        if ($role !== 'superadmin') {
            return redirect('/admin/dashboard')->with('error', 'Akses ditolak. Hanya superadmin yang dapat mengakses halaman ini.');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
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

        return view('admin.change-password', compact(
            'user',
            'isMaintenance',
            'currentUserRole',
            'currentUserId'
        ));
    }

    public function updatePassword(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Hanya superadmin yang bisa akses
        $role = $request->session()->get('role');
        if ($role !== 'superadmin') {
            return redirect('/admin/dashboard')->with('error', 'Akses ditolak. Hanya superadmin yang dapat mengakses fitur ini.');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
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
            return redirect('/admin/change-password')->with('error', 'Password saat ini harus diisi!');
        } else if (!Hash::check($current_password, $user->password)) {
            return redirect('/admin/change-password')->with('error', 'Password saat ini salah!');
        }

        // Validasi password baru
        if (empty($new_password)) {
            return redirect('/admin/change-password')->with('error', 'Password baru harus diisi!');
        } else if (strlen($new_password) < 6) {
            return redirect('/admin/change-password')->with('error', 'Password baru minimal 6 karakter!');
        } else if ($new_password !== $confirm_password) {
            return redirect('/admin/change-password')->with('error', 'Password baru dan konfirmasi tidak cocok!');
        }

        // Update password
        DB::table('users')->where('id', $userId)->update([
            'password' => Hash::make($new_password),
            'updated_at' => now(),
        ]);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => 'Change Password',
            'description' => 'Ganti password melalui halaman khusus',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return redirect('/admin/change-password')->with('success', 'Password berhasil diubah!');
    }
}
