<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Cek apakah email terdaftar
        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Email tidak terdaftar dalam sistem.'], 404);
            }
            return back()->with('error', 'Email tidak terdaftar dalam sistem.');
        }

        // Generate token
        $token = Str::random(60);

        // Simpan token ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Buat link reset password
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($email));

        try {
            // Kirim email reset password
            Mail::to($email)->send(new ResetPasswordEmail($resetUrl, $user->username));

            // Log aktivitas
            DB::table('activity_logs')->insert([
                'user_id' => $user->id,
                'action' => 'Kirim Reset Password',
                'description' => 'Link reset password telah dikirim ke ' . $email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Link reset password telah dikirim ke email ' . $email . '. Silakan cek inbox email Anda.']);
            }

            return redirect('/forgot-password')->with('success', 'Link reset password telah dikirim ke email ' . $email . '. Silakan cek inbox email Anda.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Gagal mengirim email reset password: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal mengirim email reset password: ' . $e->getMessage());
        }
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect('/forgot-password')->with('error', 'Link reset password tidak valid.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');

        // Verifikasi token
        $resetData = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$resetData || !Hash::check($token, $resetData->token)) {
            return back()->with('error', 'Token reset password tidak valid atau sudah kadaluarsa.');
        }

        // Cek apakah token masih berlaku (1 jam)
        $createdAt = strtotime($resetData->created_at);
        if (time() - $createdAt > 3600) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect('/forgot-password')->with('error', 'Token reset password sudah kadaluarsa. Silakan ulangi.');
        }

        // Update password
        DB::table('users')->where('email', $email)->update([
            'password' => Hash::make($password),
            'updated_at' => now(),
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Log activity
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            DB::table('activity_logs')->insert([
                'user_id' => $user->id,
                'action' => 'Reset Password',
                'description' => 'Password berhasil direset melalui lupa password',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        }

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
