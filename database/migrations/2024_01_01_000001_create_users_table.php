<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->nullable();
            $table->enum('role', ['admin', 'superadmin'])->default('admin');
            $table->boolean('is_active')->default(true);
            $table->integer('failed_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->integer('lockout_multiplier')->default(1);
            $table->timestamp('last_failed_attempt')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
