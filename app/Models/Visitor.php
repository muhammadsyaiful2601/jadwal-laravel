<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = ['ip_address', 'user_agent', 'visited_at'];

    /**
     * Catat kunjungan. Satu IP hanya dihitung satu kali dalam rentang 1 jam
     * untuk mencegah spam / inflasi jumlah pengunjung.
     */
    public static function recordVisit(?string $ip, ?string $userAgent = null): bool
    {
        if (empty($ip) || $ip === 'UNKNOWN') {
            return false;
        }

        // Lewati jika IP yang sama sudah berkunjung dalam 1 jam terakhir.
        $recent = self::where('ip_address', $ip)
            ->where('visited_at', '>=', now()->subHour())
            ->exists();

        if ($recent) {
            return false;
        }

        try {
            self::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'visited_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Total seluruh kunjungan yang tersimpan (unique per IP per jam).
     */
    public static function totalVisitors(): int
    {
        return self::count();
    }

    /**
     * Jumlah pengunjung pada hari ini.
     */
    public static function todayVisitors(): int
    {
        return self::whereDate('visited_at', today())->count();
    }
}
