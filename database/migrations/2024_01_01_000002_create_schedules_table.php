<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
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

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
