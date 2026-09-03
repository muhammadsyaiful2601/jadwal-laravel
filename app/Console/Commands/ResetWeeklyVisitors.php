<?php

namespace App\Console\Commands;

use App\Models\Visitor;
use Illuminate\Console\Command;
use Throwable;

class ResetWeeklyVisitors extends Command
{
    /**
     * Signature command. Dijadwalkan setiap hari Minggu 00:00 (WIB)
     * lewat routes/console.php.
     */
    protected $signature = 'visitors:reset-weekly';

    protected $description = 'Reset total pengunjung menjadi 0 (mengosongkan tabel visitors) setiap minggu';

    public function handle(): int
    {
        try {
            $deleted = Visitor::performWeeklyReset();

            $this->info("Total pengunjung direset menjadi 0 ({$deleted} baris kunjungan dihapus).");

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Gagal mereset pengunjung: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}