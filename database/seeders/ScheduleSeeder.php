<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $semester = 'GANJIL';
        $tahunAkademik = '2026/2027';

        // Foto dummy per kelas (via picsum.photos - ID konsisten)
        $fotoPerKelas = [
            '1A' => 'https://picsum.photos/seed/kelas1a/400/300',
            '1B' => 'https://picsum.photos/seed/kelas1b/400/300',
            '2A' => 'https://picsum.photos/seed/kelas2a/400/300',
            '2B' => 'https://picsum.photos/seed/kelas2b/400/300',
            '3A' => 'https://picsum.photos/seed/kelas3a/400/300',
            '3B' => 'https://picsum.photos/seed/kelas3b/400/300',
        ];

        // Jadwal Senin
        $senin = [
            ['kelas' => '1A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Pemrograman Dasar', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/pemrograman1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Matematika Diskrit', 'dosen' => 'Dra. Siti Rahmawati, M.Pd', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/matdis1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Jaringan Komputer', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/jarkom2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Desain Grafis', 'dosen' => 'Maya Sari, S.Kom, M.Ds', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/desgraf2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Struktur Beton', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/beton3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Sistem Operasi', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/sisop3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Matematika Diskrit', 'dosen' => 'Dra. Siti Rahmawati, M.Pd', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/matdis1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Pemrograman Dasar', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/pemrograman1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Basis Data', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/basdat2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Jaringan Komputer', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/jarkom2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Manajemen Proyek', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/manpro3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Struktur Beton', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/beton3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Bahasa Inggris', 'dosen' => 'Dian Purnama, S.S, M.Hum', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/inggris1a/400/300'],
            ['kelas' => '2A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Pemrograman Web', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/web2a/400/300'],
            ['kelas' => '3A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Mekanika Tanah', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/mektan3a/400/300'],

            ['kelas' => '1B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Bahasa Inggris', 'dosen' => 'Dian Purnama, S.S, M.Hum', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/inggris1b/400/300'],
            ['kelas' => '2B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Pemrograman Web', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/web2b/400/300'],
            ['kelas' => '3B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Mekanika Tanah', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/mektan3b/400/300'],
        ];

        // Jadwal Selasa
        $selasa = [
            ['kelas' => '1A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Pengantar Teknologi Informasi', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/pti1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Logika Informatika', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/loginfo1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Multimedia', 'dosen' => 'Maya Sari, S.Kom, M.Ds', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/multimedia2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Sistem Informasi', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/si2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Rekayasa Lalu Lintas', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/reklalin3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Manajemen Proyek', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/manpro3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Logika Informatika', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/loginfo1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Pengantar Teknologi Informasi', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/pti1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Sistem Informasi', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/si2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Multimedia', 'dosen' => 'Maya Sari, S.Kom, M.Ds', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/multimedia2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Statistika', 'dosen' => 'Dian Purnama, S.S, M.Hum', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/stat3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Rekayasa Lalu Lintas', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/reklalin3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Pendidikan Pancasila', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/pancasila1a/400/300'],
            ['kelas' => '2A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Keamanan Jaringan', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/kamjar2a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Statistika', 'dosen' => 'Dian Purnama, S.S, M.Hum', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/stat3b/400/300'],

            ['kelas' => '1B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Pendidikan Pancasila', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/pancasila1b/400/300'],
            ['kelas' => '2B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Keamanan Jaringan', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/kamjar2b/400/300'],
        ];

        // Jadwal Rabu
        $rabu = [
            ['kelas' => '1A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Algoritma & Pemrograman', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/algopro1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Pengantar Teknologi Informasi', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/pti1b2/400/300'],
            ['kelas' => '2A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Pemrograman Mobile', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/mobile2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Basis Data', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/basdat2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Hidrologi', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/hidro3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Analisis Struktur', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/anstruk3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Pendidikan Kewarganegaraan', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/pkn1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Algoritma & Pemrograman', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/algopro1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Administrasi Jaringan', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/adminjar2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Pemrograman Mobile', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/mobile2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Analisis Struktur', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/anstruk3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Hidrologi', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/hidro3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Agama', 'dosen' => 'Dr. H. Abdullah Karim, M.Ag', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/agama1a/400/300'],
            ['kelas' => '2A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Rekayasa Perangkat Lunak', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/rpl2a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Perencanaan Jalan', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/perencjalan3b/400/300'],

            ['kelas' => '1B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Agama', 'dosen' => 'Dr. H. Abdullah Karim, M.Ag', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/agama1b/400/300'],
            ['kelas' => '2B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Rekayasa Perangkat Lunak', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/rpl2b/400/300'],
        ];

        // Jadwal Kamis
        $kamis = [
            ['kelas' => '1A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Kalkulus', 'dosen' => 'Dra. Siti Rahmawati, M.Pd', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/kalkulus1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Kalkulus', 'dosen' => 'Dra. Siti Rahmawati, M.Pd', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/kalkulus1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Desain Grafis', 'dosen' => 'Maya Sari, S.Kom, M.Ds', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/desgraf2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Jaringan Komputer', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/jarkom2b2/400/300'],
            ['kelas' => '3A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Etika Profesi', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/etikapro3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Perencanaan Jalan', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/perencjalan3b2/400/300'],

            ['kelas' => '1A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Dasar Sistem Komputer', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/dsk1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Dasar Sistem Komputer', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/dsk1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Jaringan Komputer', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/jarkom2a2/400/300'],
            ['kelas' => '2B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Desain Grafis', 'dosen' => 'Maya Sari, S.Kom, M.Ds', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/desgraf2b2/400/300'],
            ['kelas' => '3A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Perencanaan Jalan', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/perencjalan3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Etika Profesi', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/etikapro3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Fisika Dasar', 'dosen' => 'Drs. Supardi, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/fisika1a/400/300'],
            ['kelas' => '2A', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Sistem Cerdas', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/cerdas2a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '5-6', 'waktu' => '11:10 - 12:50', 'mata_kuliah' => 'Metode Penelitian', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/metopen3b/400/300'],

            ['kelas' => '1B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Fisika Dasar', 'dosen' => 'Drs. Supardi, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/fisika1b/400/300'],
            ['kelas' => '2B', 'jam_ke' => '7-8', 'waktu' => '13:30 - 15:10', 'mata_kuliah' => 'Sistem Cerdas', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/cerdas2b/400/300'],
        ];

        // Jadwal Jumat
        $jumat = [
            ['kelas' => '1A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Pemrograman', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/prakprog1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Pemrograman', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/prakprog1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Jaringan', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/prakjar2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Basis Data', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/prakbasdat2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Beton', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/prakbeton3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Beton', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/prakbeton3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Bahasa Indonesia', 'dosen' => 'Dian Purnama, S.S, M.Hum', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/bindo1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Bahasa Indonesia', 'dosen' => 'Dian Purnama, S.S, M.Hum', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/bindo1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Praktikum Basis Data', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/prakbasdat2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Praktikum Jaringan', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/prakjar2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Metode Penelitian', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/metopen3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Metode Penelitian', 'dosen' => 'Dr. Agus Wibowo, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/metopen3b2/400/300'],

            ['kelas' => '2A', 'jam_ke' => '5-6', 'waktu' => '10:00 - 11:40', 'mata_kuliah' => 'Kewirausahaan TI', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/ti2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '5-6', 'waktu' => '10:00 - 11:40', 'mata_kuliah' => 'Kewirausahaan TI', 'dosen' => 'Dr. Rina Marlina, M.Kom', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/ti2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '5-6', 'waktu' => '10:00 - 11:40', 'mata_kuliah' => 'Tugas Akhir', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/ta3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '5-6', 'waktu' => '10:00 - 11:40', 'mata_kuliah' => 'Tugas Akhir', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/ta3b/400/300'],
        ];

        // Jadwal Sabtu
        $sabtu = [
            ['kelas' => '1A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Fisika', 'dosen' => 'Drs. Supardi, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/prakfis1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Fisika', 'dosen' => 'Drs. Supardi, M.Si', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/prakfis1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Multimedia Lanjutan', 'dosen' => 'Maya Sari, S.Kom, M.Ds', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/multilanj2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Praktikum Jaringan Lanjutan', 'dosen' => 'Dr. Budi Santoso, M.T', 'ruang' => 'Labor Jaringan', 'foto' => 'https://picsum.photos/seed/prakjarlanj2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Teknik Pondasi', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/pondasi3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '1-2', 'waktu' => '07:30 - 09:10', 'mata_kuliah' => 'Teknik Pondasi', 'dosen' => 'Ir. Hadi Wijaya, M.T', 'ruang' => 'Ruang Sipil', 'foto' => 'https://picsum.photos/seed/pondasi3b/400/300'],

            ['kelas' => '1A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Praktikum Komputer', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/prakkom1a/400/300'],
            ['kelas' => '1B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Praktikum Komputer', 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'ruang' => 'Labor Perakitan', 'foto' => 'https://picsum.photos/seed/prakkom1b/400/300'],
            ['kelas' => '2A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Machine Learning', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/ml2a/400/300'],
            ['kelas' => '2B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Machine Learning', 'dosen' => 'Dr. Dewi Lestari, S.Kom, M.T', 'ruang' => 'Labor Multi Media', 'foto' => 'https://picsum.photos/seed/ml2b/400/300'],
            ['kelas' => '3A', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Seminar Proposal', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/sempro3a/400/300'],
            ['kelas' => '3B', 'jam_ke' => '3-4', 'waktu' => '09:20 - 11:00', 'mata_kuliah' => 'Seminar Proposal', 'dosen' => 'Ir. Bambang Setiawan, M.T', 'ruang' => 'Ruang Serbaguna', 'foto' => 'https://picsum.photos/seed/sempro3b/400/300'],
        ];

        // Combine all schedules with hari and semester info
        $allSchedules = [];
        $hariList = [
            'Senin' => $senin,
            'Selasa' => $selasa,
            'Rabu' => $rabu,
            'Kamis' => $kamis,
            'Jumat' => $jumat,
            'Sabtu' => $sabtu,
        ];

        foreach ($hariList as $hari => $schedules) {
            foreach ($schedules as $schedule) {
                $allSchedules[] = [
                    'kelas' => $schedule['kelas'],
                    'hari' => $hari,
                    'jam_ke' => $schedule['jam_ke'],
                    'waktu' => $schedule['waktu'],
                    'mata_kuliah' => $schedule['mata_kuliah'],
                    'dosen' => $schedule['dosen'],
                    'ruang' => $schedule['ruang'],
                    'foto' => $schedule['foto'],
                    'semester' => $semester,
                    'tahun_akademik' => $tahunAkademik,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('schedules')->insert($allSchedules);
    }
}
