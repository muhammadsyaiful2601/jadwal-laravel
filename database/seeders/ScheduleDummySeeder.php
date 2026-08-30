<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAkademik = '2026/2027';
        $semester = 'GANJIL';

        Schedule::query()
            ->where('tahun_akademik', $tahunAkademik)
            ->where('semester', $semester)
            ->delete();

        $hariMap = [
            1 => 'SENIN',
            2 => 'SELASA',
            3 => 'RABU',
            4 => 'KAMIS',
            5 => 'JUMAT',
            6 => 'SENIN',
            7 => 'SENIN',
        ];

        $hariSekarang = $hariMap[Carbon::now()->dayOfWeekIso] ?? 'SENIN';
        $hariBesok = $hariMap[(Carbon::now()->dayOfWeekIso % 5) + 1] ?? 'SELASA';

        $now = Carbon::now();
        $ongoingStart = $now->copy()->subMinutes(25);
        $ongoingEnd = $now->copy()->addMinutes(55);

        $nextStart = $now->copy()->addMinutes(80);
        $nextEnd = $now->copy()->addMinutes(155);

        $jadwal = [
            [
                'kelas' => 'A1',
                'hari' => $hariSekarang,
                'jam_ke' => 2,
                'waktu' => $ongoingStart->format('H:i') . ' - ' . $ongoingEnd->format('H:i'),
                'mata_kuliah' => 'Pemrograman Web',
                'dosen' => 'Dr. Fadli',
                'ruang' => 'Lab 1',
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
            ],
            [
                'kelas' => 'A1',
                'hari' => $hariSekarang,
                'jam_ke' => 3,
                'waktu' => $nextStart->format('H:i') . ' - ' . $nextEnd->format('H:i'),
                'mata_kuliah' => 'Basis Data',
                'dosen' => 'Siti Rahma',
                'ruang' => 'R. 204',
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
            ],
            [
                'kelas' => 'A2',
                'hari' => $hariSekarang,
                'jam_ke' => 1,
                'waktu' => $now->copy()->subMinutes(90)->format('H:i') . ' - ' . $now->copy()->subMinutes(10)->format('H:i'),
                'mata_kuliah' => 'Sistem Informasi',
                'dosen' => 'Yuliani',
                'ruang' => 'R. 101',
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
            ],
            [
                'kelas' => 'A2',
                'hari' => $hariSekarang,
                'jam_ke' => 4,
                'waktu' => $now->copy()->addMinutes(150)->format('H:i') . ' - ' . $now->copy()->addMinutes(220)->format('H:i'),
                'mata_kuliah' => 'Jaringan Komputer',
                'dosen' => 'M. Yusuf',
                'ruang' => 'Lab Networking',
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
            ],
            [
                'kelas' => 'A3',
                'hari' => $hariBesok,
                'jam_ke' => 1,
                'waktu' => '08:00 - 09:40',
                'mata_kuliah' => 'Desain UI/UX',
                'dosen' => 'Rina Amelia',
                'ruang' => 'R. 305',
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
            ],
            [
                'kelas' => 'A3',
                'hari' => $hariBesok,
                'jam_ke' => 2,
                'waktu' => '10:00 - 11:40',
                'mata_kuliah' => 'Algoritma',
                'dosen' => 'Budi Santoso',
                'ruang' => 'R. 202',
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
            ],
        ];

        foreach ($jadwal as $item) {
            Schedule::create($item);
        }
    }
}
