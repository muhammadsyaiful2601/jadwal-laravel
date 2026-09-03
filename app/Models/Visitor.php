<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = ['ip_address', 'user_agent', 'visited_at'];

    /**
     * Kunci setting penyimpan waktu reset terakhir (tabel settings).
     */
    public const WEEKLY_RESET_SETTING = 'visitors_last_reset_at';

    /**
     * Catat kunjungan. Satu IP hanya dihitung satu kali dalam rentang 1 jam
     * untuk mencegah spam / inflasi jumlah pengunjung.
     */
    public static function recordVisit(?string $ip, ?string $userAgent = null): bool
    {
        if (empty($ip) || $ip === 'UNKNOWN') {
            return false;
        }

        self::ensureWeeklyReset();

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
     * Total kunjungan pada periode minggu berjalan (sejak Minggu 00:00 terakhir).
     * Tabel otomatis dikosongkan setiap hari Minggu agar tidak membebani server.
     */
    public static function totalVisitors(): int
    {
        self::ensureWeeklyReset();

        return self::count();
    }

    /**
     * Jumlah pengunjung pada hari ini.
     */
    public static function todayVisitors(): int
    {
        return self::whereDate('visited_at', today())->count();
    }

    /* =====================================================================
     |  RESET MINGGUAN — total pengunjung menjadi 0 setiap hari Minggu
     * ===================================================================== */

    /**
     * Awal periode minggu berjalan = hari Minggu 00:00 terakhir
     * (hari ini sendiri bila sekarang hari Minggu), dalam timezone aplikasi.
     */
    public static function currentPeriodStart(): Carbon
    {
        return now()->startOfWeek(Carbon::SUNDAY);
    }

    /**
     * Kosongkan tabel visitors (total pengunjung kembali 0) dan tandai
     * waktu reset. Dipakai oleh command "visitors:reset-weekly".
     */
    public static function performWeeklyReset(): int
    {
        $deleted = self::query()->delete();

        DB::table('settings')->updateOrInsert(
            ['setting_key' => self::WEEKLY_RESET_SETTING],
            ['setting_value' => now()->toDateTimeString(), 'updated_at' => now()]
        );

        return $deleted;
    }

    /**
     * Lazy safety-net: pastikan reset mingguan sudah terjadi untuk periode
     * berjalan, TANPA bergantung pada cron/scheduler. Dipanggil saat kunjungan
     * dicatat dan saat total pengunjung dibaca — cukup murah (1 query setting).
     */
    public static function ensureWeeklyReset(): void
    {
        try {
            $last = Setting::getValue(self::WEEKLY_RESET_SETTING);
            $periodStart = self::currentPeriodStart();

            // Penanda sudah ada dan masih dalam periode berjalan -> aman.
            if ($last !== null && strtotime((string) $last) >= $periodStart->getTimestamp()) {
                return;
            }

            if ($last === null) {
                // Deploy pertama (penanda belum pernah dibuat): JANGAN hapus data
                // yang sudah terkumpul — hanya mulai pemantauan dari sekarang.
                DB::table('settings')->updateOrInsert(
                    ['setting_key' => self::WEEKLY_RESET_SETTING],
                    ['setting_value' => now()->toDateTimeString(), 'updated_at' => now()]
                );

                return;
            }

            self::performWeeklyReset();

            Log::info('Total pengunjung direset otomatis (periode mingguan baru dimulai pada ' . $periodStart->format('Y-m-d H:i') . ').');
        } catch (\Throwable $e) {
            // Reset gagal tidak boleh mengganggu pencatatan kunjungan / dashboard
            Log::warning('Gagal menjalankan reset mingguan pengunjung: ' . $e->getMessage());
        }
    }
}
