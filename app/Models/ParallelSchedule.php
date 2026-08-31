<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParallelSchedule extends Model
{
    protected $table = 'parallel_schedules';

    protected $fillable = [
        'schedule_id',
        'kelas',
    ];

    /**
     * The base schedule (from the `schedules` table) this parallel entry is derived from.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    /**
     * Returns the list of additional classes as an array (from the comma-separated `kelas` field).
     */
    public function getKelasListAttribute(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->kelas))));
    }

    /**
     * Normalize and dedupe a raw class list into a clean uppercase array.
     */
    public static function normalizeKelasList($kelasRaw): array
    {
        $kelasRaw = str_replace(';', ',', (string) $kelasRaw);
        $parts = array_map('trim', explode(',', $kelasRaw));

        $result = [];
        foreach ($parts as $part) {
            $part = strtoupper($part);
            if ($part === '') continue;
            if (in_array($part, $result)) continue;
            $result[] = $part;
        }

        return $result;
    }
}