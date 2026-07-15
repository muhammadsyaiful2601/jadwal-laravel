<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SemesterSetting;

class SemesterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SemesterSetting::create([
            'tahun_akademik' => '2026/2027',
            'semester' => 'GANJIL',
            'is_active' => true,
        ]);

        SemesterSetting::create([
            'tahun_akademik' => '2026/2027',
            'semester' => 'GENAP',
            'is_active' => false,
        ]);
    }
}
