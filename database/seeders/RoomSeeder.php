<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'nama_ruang' => 'Ruang Serbaguna',
                'kapasitas' => 50,
                'fasilitas' => 'Meja, Kursi, Whiteboard, LCD, Proyektor, AC',
                'deskripsi' => 'Ruang serbaguna untuk berbagai kegiatan perkuliahan',
                'foto_path' => 'ruang serbaguna.jpg',
            ],
            [
                'nama_ruang' => 'Labor Jaringan',
                'kapasitas' => 25,
                'fasilitas' => 'Router, Switch, Server, Komputer, AC',
                'deskripsi' => 'Laboratorium jaringan komputer',
                'foto_path' => 'Labor jaringan.jpg',
            ],
            [
                'nama_ruang' => 'Labor Multi Media',
                'kapasitas' => 20,
                'fasilitas' => 'Komputer High-End, Kamera, Green Screen, AC, Audio System',
                'deskripsi' => 'Laboratorium multimedia dan desain grafis',
                'foto_path' => 'mulmed.jpg',
            ],
            [
                'nama_ruang' => 'Ruang Sipil',
                'kapasitas' => 30,
                'fasilitas' => 'Meja Gambar, Komputer, Alat Ukur, AC',
                'deskripsi' => 'Ruang praktikum teknik sipil',
                'foto_path' => 'ruang sipil.jpg',
            ],
            [
                'nama_ruang' => 'Labor Perakitan',
                'kapasitas' => 20,
                'fasilitas' => 'Meja Kerja, Alat Perakitan, Komponen Elektronik, AC',
                'deskripsi' => 'Laboratorium perakitan dan praktikum elektronika',
                'foto_path' => 'perakitan.jpg',
            ],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->updateOrInsert(
                ['nama_ruang' => $room['nama_ruang']],
                [
                    'kapasitas' => $room['kapasitas'],
                    'fasilitas' => $room['fasilitas'],
                    'deskripsi' => $room['deskripsi'],
                    'foto_path' => $room['foto_path'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
