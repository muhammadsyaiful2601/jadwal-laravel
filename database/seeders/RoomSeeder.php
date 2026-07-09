<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['nama_ruang' => 'Lab. Komputer A', 'kapasitas' => 30, 'fasilitas' => 'Komputer, LCD, AC, Wi-Fi', 'deskripsi' => 'Laboratorium komputer untuk praktikum'],
            ['nama_ruang' => 'Lab. Komputer B', 'kapasitas' => 35, 'fasilitas' => 'Komputer, LCD, AC, Wi-Fi', 'deskripsi' => 'Laboratorium komputer untuk praktikum'],
            ['nama_ruang' => 'Lab. Jaringan', 'kapasitas' => 25, 'fasilitas' => 'Router, Switch, Server, AC', 'deskripsi' => 'Laboratorium jaringan komputer'],
            ['nama_ruang' => 'Lab. Multimedia', 'kapasitas' => 20, 'fasilitas' => 'Komputer High-End, Kamera, Green Screen, AC', 'deskripsi' => 'Laboratorium multimedia dan desain grafis'],
            ['nama_ruang' => 'Ruang 101', 'kapasitas' => 40, 'fasilitas' => 'Meja, Kursi, Whiteboard, LCD', 'deskripsi' => 'Ruang kuliah reguler'],
            ['nama_ruang' => 'Ruang 102', 'kapasitas' => 40, 'fasilitas' => 'Meja, Kursi, Whiteboard, LCD', 'deskripsi' => 'Ruang kuliah reguler'],
            ['nama_ruang' => 'Ruang 201', 'kapasitas' => 45, 'fasilitas' => 'Meja, Kursi, Whiteboard, LCD, AC', 'deskripsi' => 'Ruang kuliah reguler'],
            ['nama_ruang' => 'Ruang 202', 'kapasitas' => 45, 'fasilitas' => 'Meja, Kursi, Whiteboard, LCD, AC', 'deskripsi' => 'Ruang kuliah reguler'],
            ['nama_ruang' => 'Aula', 'kapasitas' => 200, 'fasilitas' => 'Sound System, Proyektor, AC, Panggung', 'deskripsi' => 'Aula serbaguna untuk acara besar'],
            ['nama_ruang' => 'Perpustakaan', 'kapasitas' => 50, 'fasilitas' => 'Buku, Meja Baca, AC, Wi-Fi', 'deskripsi' => 'Perpustakaan kampus'],
            ['nama_ruang' => 'Ruang Dosen', 'kapasitas' => 10, 'fasilitas' => 'Meja, Kursi, AC, Wi-Fi', 'deskripsi' => 'Ruang kerja dosen'],
            ['nama_ruang' => 'Lab. Bahasa', 'kapasitas' => 25, 'fasilitas' => 'Headset, Komputer, AC', 'deskripsi' => 'Laboratorium bahasa untuk pembelajaran listening dan speaking'],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert([
                'nama_ruang' => $room['nama_ruang'],
                'kapasitas' => $room['kapasitas'],
                'fasilitas' => $room['fasilitas'],
                'deskripsi' => $room['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
