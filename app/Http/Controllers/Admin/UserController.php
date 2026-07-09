<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $currentUserRole = $request->session()->get('role');
        $currentUserId = $request->session()->get('user_id');

        // Get all users with other active count
        $users = DB::select("
            SELECT u.*, 
                   (SELECT COUNT(*) FROM users WHERE is_active = TRUE AND id != u.id) as other_active_count
            FROM users u 
            ORDER BY u.role DESC, u.username ASC
        ");

        // Get maintenance status
        $maintenanceStatus = DB::table('settings')
            ->where('setting_key', 'maintenance_mode')
            ->value('setting_value');
        $isMaintenance = ($maintenanceStatus == '1');

        // Check if superadmin
        $isSuperAdmin = $currentUserRole === 'superadmin';

        // Check if current user is the last active account
        $activeCount = DB::table('users')->where('is_active', true)->count();
        $currentUser = DB::table('users')->where('id', $currentUserId)->first();
        $isLastActive = ($activeCount == 1 && $currentUser->is_active);

        return view('admin.manage-users', compact(
            'users',
            'isMaintenance',
            'isSuperAdmin',
            'currentUserRole',
            'currentUserId',
            'isLastActive'
        ));
    }

    public function store(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Only superadmin can add admin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-users')->with('error', 'Hanya superadmin yang dapat menambah admin baru.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'email' => 'nullable|email|max:255|unique:users,email',
            'role' => 'required|in:admin,superadmin',
        ]);

        $username = trim($request->input('username'));
        $email = $request->input('email');
        $role = $request->input('role');
        $password = $request->input('password');

        // Check if email already exists (if provided)
        if (!empty($email)) {
            $emailExists = DB::table('users')->where('email', $email)->exists();
            if ($emailExists) {
                return redirect('/admin/manage-users')->with('error', "Email '$email' sudah digunakan!")->withInput();
            }
        }

        DB::table('users')->insert([
            'username' => $username,
            'password' => Hash::make($password),
            'email' => $email,
            'role' => $role,
            'is_active' => true,
            'failed_attempts' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userId = DB::getPdo()->lastInsertId();

        $this->logActivity($request->session()->get('user_id'), 'Tambah Admin', $username);

        return redirect('/admin/manage-users')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $userId = (int) $request->input('id');
        $currentUserRole = $request->session()->get('role');
        $currentUserId = $request->session()->get('user_id');

        // Get target user
        $targetUser = DB::table('users')->where('id', $userId)->first();

        if (!$targetUser) {
            return redirect('/admin/manage-users')->with('error', 'User tidak ditemukan');
        }

        $error = false;
        $errorMessage = "";

        // 1. Check if user is editing themselves
        if ($userId == $currentUserId) {
            if ($request->has('role') && $request->input('role') != $targetUser->role) {
                $error = true;
                $errorMessage = "Tidak dapat mengubah role akun sendiri.";
            }

            if ($request->has('is_active') != $targetUser->is_active) {
                $error = true;
                $errorMessage = "Tidak dapat mengubah status aktif akun sendiri.";
            }
        }
        // 2. Regular admin trying to edit superadmin
        else if ($currentUserRole !== 'superadmin' && $targetUser->role === 'superadmin') {
            $error = true;
            $errorMessage = "Admin biasa tidak dapat mengedit akun superadmin.";
        }
        // 3. Regular admin trying to change role to superadmin
        else if ($currentUserRole !== 'superadmin' && $request->has('role') && $request->input('role') === 'superadmin') {
            $error = true;
            $errorMessage = "Admin biasa tidak dapat membuat atau mengubah akun menjadi superadmin.";
        }

        if ($error) {
            return redirect('/admin/manage-users')->with('error', $errorMessage);
        }

        // Check if this is the last active account
        $activeCount = DB::table('users')->where('is_active', true)->where('id', '!=', $userId)->count();

        if ($activeCount == 0 && $targetUser->is_active && !$request->has('is_active')) {
            return redirect('/admin/manage-users')->with('error', 'Tidak dapat menonaktifkan akun aktif terakhir.');
        }

        // Build update query
        $updateData = [
            'username' => trim($request->input('username')),
            'email' => $request->input('email'),
            'updated_at' => now(),
        ];

        // Only superadmin or if not editing superadmin can change role
        if (
            $request->has('role') &&
            ($currentUserRole === 'superadmin' ||
                ($currentUserRole !== 'superadmin' && $targetUser->role !== 'superadmin'))
        ) {
            $updateData['role'] = $request->input('role');
        }

        // Only superadmin or if not editing superadmin can change active status
        if (
            ($currentUserRole === 'superadmin' ||
                ($currentUserRole !== 'superadmin' && $targetUser->role !== 'superadmin'))
        ) {
            if ($request->has('is_active')) {
                $updateData['is_active'] = 1;
            } else {
                $updateData['is_active'] = 0;
            }
        }

        DB::table('users')->where('id', $userId)->update($updateData);

        $this->logActivity($currentUserId, 'Edit Admin', trim($request->input('username')));

        return redirect('/admin/manage-users')->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Only superadmin can delete
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-users')->with('error', 'Hanya superadmin yang dapat menghapus admin.');
        }

        $targetId = (int) $request->query('delete');

        // Get target user
        $targetUser = DB::table('users')->where('id', $targetId)->first();

        if (!$targetUser) {
            return redirect('/admin/manage-users')->with('error', 'User tidak ditemukan');
        }

        // Check if trying to delete superadmin
        if ($targetUser->role === 'superadmin') {
            return redirect('/admin/manage-users')->with('error', 'Tidak dapat menghapus akun superadmin.');
        }

        // Check if this is the last active account
        $activeCount = DB::table('users')->where('is_active', true)->count();

        if ($activeCount <= 1 && $targetUser->is_active) {
            return redirect('/admin/manage-users')->with('error', 'Tidak dapat menghapus akun aktif terakhir.');
        }

        $username = $targetUser->username;

        DB::table('users')->where('id', $targetId)->delete();

        $this->logActivity($request->session()->get('user_id'), 'Hapus Admin', "ID: {$targetId}");

        return redirect('/admin/manage-users')->with('success', 'Admin berhasil dihapus!');
    }

    public function resetLockout(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Only superadmin can reset lockout
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-users')->with('error', 'Hanya superadmin yang dapat mereset lockout.');
        }

        $targetId = (int) $request->query('reset_lockout');

        DB::table('users')->where('id', $targetId)->update([
            'failed_attempts' => 0,
            'locked_until' => null,
            'lockout_multiplier' => 1,
            'last_failed_attempt' => null,
            'updated_at' => now(),
        ]);

        $this->logActivity($request->session()->get('user_id'), 'Reset Lockout', "Reset lockout untuk user ID: {$targetId}");

        return redirect('/admin/manage-users')->with('success', 'Lockout berhasil direset!');
    }

    public function cancelLockout(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Only superadmin can cancel lockout
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-users')->with('error', 'Hanya superadmin yang dapat membatalkan lockout.');
        }

        $targetId = (int) $request->query('cancel_lockout');

        DB::table('users')->where('id', $targetId)->update([
            'locked_until' => null,
            'updated_at' => now(),
        ]);

        $this->logActivity($request->session()->get('user_id'), 'Cancel Lockout', "Membatalkan lockout untuk user ID: {$targetId}");

        return redirect('/admin/manage-users')->with('success', 'Lockout berhasil dibatalkan!');
    }

    public function formatLockoutTime($seconds)
    {
        if ($seconds <= 0) {
            return '0 detik';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        $parts = [];
        if ($hours > 0) {
            $parts[] = $hours . ' jam';
        }
        if ($minutes > 0) {
            $parts[] = $minutes . ' menit';
        }
        if ($seconds > 0) {
            $parts[] = $seconds . ' detik';
        }

        return implode(', ', $parts);
    }

    private function logActivity($userId, $action, $description)
    {
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
