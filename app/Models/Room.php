<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'nama_ruang',
        'kapasitas',
        'fasilitas',
        'foto_path',
        'deskripsi',
    ];
}
