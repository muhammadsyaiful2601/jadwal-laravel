<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang')->unique();
            $table->integer('kapasitas')->default(0);
            $table->text('fasilitas')->nullable();
            $table->string('foto_path')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('nama_ruang');
            $table->index('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
