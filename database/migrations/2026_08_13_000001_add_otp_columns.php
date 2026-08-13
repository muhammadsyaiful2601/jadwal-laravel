<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom OTP untuk verifikasi email (dipakai bersama link verifikasi)
        if (!Schema::hasColumn('users', 'email_otp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email_otp')->nullable()->after('email_verified_token');
                $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp');
            });
        }

        // Kolom OTP untuk reset password (dipakai bersama link reset)
        if (!Schema::hasColumn('password_reset_tokens', 'otp')) {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->string('otp')->nullable()->after('token');
                $table->timestamp('otp_expires_at')->nullable()->after('otp');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'email_otp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['email_otp', 'email_otp_expires_at']);
            });
        }

        if (Schema::hasColumn('password_reset_tokens', 'otp')) {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropColumn(['otp', 'otp_expires_at']);
            });
        }
    }
};
