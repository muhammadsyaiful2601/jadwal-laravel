<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Jadwal paralel: satu jadwal perkuliahan (mata kuliah, dosen, ruang,
     * hari, waktu) yang dipakai bersama oleh beberapa kelas pada satu hari.
     * Kolom `kelas` menyimpan daftar kelas yang dipisahkan koma (contoh: "A1, A2").
     */
    public function up(): void
    {
        Schema::create('parallel_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('kelas');
            $table->string('hari');
            $table->string('jam_ke');
            $table->string('waktu');
            $table->string('mata_kuliah');
            $table->string('dosen');
            $table->string('ruang');
            $table->string('semester');
            $table->string('tahun_akademik');
            $table->timestamps();

            $table->index(['kelas', 'hari', 'jam_ke']);
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