<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Total Pengunjung — Reset Mingguan
|--------------------------------------------------------------------------
| Setiap hari Minggu 00:00 (WIB) tabel "visitors" dikosongkan sehingga
| total pengunjung kembali 0 dan tabel tidak terus membesar (hemat server).
|
| Catatan deployment: penjadwal ini butuh scheduler aktif di server —
| cron `php artisan schedule:run` tiap menit, atau `php artisan schedule:work`
| saat development. Tanpa scheduler pun reset tetap terjadi otomatis
| (lazy safety-net di App\Models\Visitor::ensureWeeklyReset()) pada
| kunjungan/pembukaan dashboard pertama setelah Minggu.
*/
Schedule::command('visitors:reset-weekly')
    ->sundays()
    ->at('00:00')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();
