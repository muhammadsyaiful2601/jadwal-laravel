<?php

namespace App\Services;

use App\Services\Ai\Providers\GeminiProvider;

/**
 * @deprecated Gunakan App\Services\Ai\AiScheduleImportService (dispatcher
 * multi-provider). Class ini dipertahankan sebagai alias agar kode lama
 * yang memanggil GeminiScheduleImportService tetap berfungsi.
 */
class GeminiScheduleImportService extends GeminiProvider
{
}
