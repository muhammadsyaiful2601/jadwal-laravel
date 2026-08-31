<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Jadwal paralel diturunkan dari jadwal yang sudah ada: satu jadwal dasar
     * (tabel `schedules`) dipakai bersama oleh beberapa kelas tambahan.
     * Kolom `schedule_id` menunjuk ke jadwal dasar, kolom `kelas` menyimpan
     * daftar kelas tambahan yang dipisahkan koma (contoh: "TI-1B, TI-1C").
     */
    public function up(): void
    {
        Schema::dropIfExists('parallel_schedules');

        Schema::create('parallel_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->string('kelas');
            $table->timestamps();

            $table->index('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parallel_schedules');
    }
};