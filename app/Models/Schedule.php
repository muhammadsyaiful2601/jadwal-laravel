<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
        'kelas',
        'hari',
        'jam_ke',
        'waktu',
        'mata_kuliah',
        'dosen',
        'ruang',
        'semester',
        'tahun_akademik',
    ];

    protected $casts = [
        'jam_ke' => 'integer',
    ];

    public const DAYS = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

    public const DAY_MAP = [
        1 => 'SENIN',
        2 => 'SELASA',
        3 => 'RABU',
        4 => 'KAMIS',
        5 => 'JUMAT',
    ];

    public function scopeActiveSemester($query, $tahunAkademik, $semester)
    {
        return $query->where('tahun_akademik', $tahunAkademik)
            ->where('semester', $semester);
    }

    public function scopeByHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }

    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    /**
     * Get the start time from the waktu range (e.g., "08:00 - 09:40")
     */
    public function getWaktuMulaiAttribute()
    {
        $parts = explode(' - ', $this->waktu);
        return $parts[0] ?? '';
    }

    /**
     * Get the end time from the waktu range
     */
    public function getWaktuSelesaiAttribute()
    {
        $parts = explode(' - ', $this->waktu);
        return $parts[1] ?? '';
    }

    /**
     * Check if this schedule is currently ongoing
     */
    public function isOngoing(): bool
    {
        $now = now()->format('H:i');
        return $now >= $this->waktu_mulai && $now <= $this->waktu_selesai;
    }
}
