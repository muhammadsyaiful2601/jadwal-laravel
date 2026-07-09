<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterSetting extends Model
{
    protected $table = 'semester_settings';

    protected $fillable = [
        'tahun_akademik',
        'semester',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active semester
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Get active semester as array
     */
    public static function getActiveSemester()
    {
        $semester = self::where('is_active', true)->first();
        if (!$semester) {
            return [
                'tahun_akademik' => date('Y'),
                'semester' => 'GANJIL'
            ];
        }
        return [
            'tahun_akademik' => $semester->tahun_akademik,
            'semester' => $semester->semester
        ];
    }

    /**
     * Get all tahun akademik
     */
    public static function getAllTahunAkademik()
    {
        return self::distinct()->pluck('tahun_akademik')->toArray();
    }
}
