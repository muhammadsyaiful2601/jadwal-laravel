<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $userId = $request->session()->get('user_id');
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan');
        }

        // Cek apakah sudah terverifikasi
        if ($user->email_verified_at) {
            return redirect('/admin/profile')->with('error', 'Email sudah terverifikasi.');
        }

        // Cek apakah email sudah diisi
        if (empty($user->email)) {
            return redirect('/admin/profile')->with('error', 'Silakan isi email terlebih dahulu.');
        }

        // Generate token verifikasi
        $token = Str::random(60);

        // Simpan token
        DB::table('users')->where('id', $userId)->update([
            'email_verified_token' => $token,
            'updated_at' => now(),
        ]);

        // Buat link verifikasi
        $verificationUrl = url('/verify-email/' . $token);

        try {
            // Kirim email verifikasi
            Mail::to($user->email)->send(new VerificationEmail($verificationUrl, $user->username));

            // Log aktivitas
            DB::table('activity_logs')->insert([
                'user_id' => $userId,
                'action' => 'Kirim Verifikasi Email',
                'description' => 'Email verifikasi telah dikirim ke ' . $user->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return redirect('/admin/profile')->with('success', 'Link verifikasi telah dikirim ke email ' . $user->email . '. Silakan cek inbox email Anda.');
        } catch (\Exception $e) {
            return redirect('/admin/profile')->with('error', 'Gagal mengirim email verifikasi: ' . $e->getMessage());
        }
    }

    public function verifyEmail(Request $request, $token)
    {
        // Cari user berdasarkan token
        $user = DB::table('users')->where('email_verified_token', $token)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Token verifikasi tidak valid atau sudah kadaluarsa.');
        }

        // Update status verifikasi
        DB::table('users')->where('id', $user->id)->update([
            'email_verified_at' => now(),
            'email_verified_token' => null,
            'updated_at' => now(),
        ]);

        // Log aktivitas
        DB::table('activity_logs')->insert([
            'user_id' => $user->id,
            'action' => 'Verifikasi Email',
            'description' => 'Email ' . $user->email . ' berhasil diverifikasi',
            'created_at' => now(),
        ]);

        // Jika user sedang login, redirect ke profile
        if ($request->session()->has('user_id') && $request->session()->get('user_id') == $user->id) {
            return redirect('/admin/profile')->with('success', 'Email berhasil diverifikasi!');
        }

        return redirect('/login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function updateEmail(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $userId = $request->session()->get('user_id');
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan');
        }

        $request->validate([
            'new_email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Verifikasi password
        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect('/admin/profile')->with('error', 'Password yang dimasukkan salah!');
        }

        $newEmail = $request->input('new_email');

        // Cek apakah email sudah digunakan user lain
        $existingUser = DB::table('users')
            ->where('email', $newEmail)
            ->where('id', '!=', $userId)
            ->first();

        if ($existingUser) {
            return redirect('/admin/profile')->with('error', 'Email sudah digunakan oleh akun lain.');
        }

        // Update email dan reset verifikasi
        DB::table('users')->where('id', $userId)->update([
            'email' => $newEmail,
            'email_verified_at' => null,
            'email_verified_token' => null,
            'updated_at' => now(),
        ]);

        // Log aktivitas
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => 'Update Email',
            'description' => 'Email diubah menjadi ' . $newEmail,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return redirect('/admin/profile')->with('success', 'Email berhasil diperbarui! Silakan kirim verifikasi ke email baru Anda.');
    }
}
