<?php

namespace App\Services\Ai;

use App\Models\AiApiConfig;
use App\Services\Ai\Providers\AnthropicProvider;
use App\Services\Ai\Providers\GeminiProvider;
use App\Services\Ai\Providers\OpenAiProvider;
use Illuminate\Support\Facades\Log;

/**
 * Dispatcher untuk Import Jadwal AI.
 *
 * - Memilih provider aktif (Gemini / OpenAI / Anthropic) dari Pengaturan Sistem.
 * - Melacak limit penggunaan (daily / monthly / total) dan melempar
 *   AiUsageLimitExceededException ketika limit tercapai.
 */
class AiScheduleImportService
{
    public const PROVIDERS = [
        'gemini' => GeminiProvider::class,
        'openai' => OpenAiProvider::class,
        'anthropic' => AnthropicProvider::class,
    ];

    private const PERIOD_LABELS = [
        'daily' => 'hari ini',
        'monthly' => 'bulan ini',
        'total' => 'total',
    ];

    /**
     * Ekstrak jadwal dari file menggunakan provider AI yang aktif.
     * Menghitung pemakaian kuota setelah berhasil.
     */
    public function extractSchedules(string $realPath, string $extension): array
    {
        $usage = $this->getUsageInfo();

        if ($usage['limit'] > 0 && $usage['used'] >= $usage['limit']) {
            throw new AiUsageLimitExceededException(
                'Limit penggunaan AI telah tercapai (' . $usage['used'] . '/' . $usage['limit'] . ' untuk periode ' . $usage['period_label'] . '). '
                . 'Silakan hubungi superadmin atau tunggu periode berikutnya.'
            );
        }

        $items = $this->resolveProvider()->extractSchedules($realPath, $extension);

        $this->incrementUsage();

        return $items;
    }

    /**
     * Buat instance provider aktif sesuai tabel ai_api_configs.
     */
    public function resolveProvider(): AiProviderInterface
    {
        $providerKey = AiApiConfig::activeProviderKey();
        $class = self::PROVIDERS[$providerKey] ?? self::PROVIDERS['gemini'];

        return new $class();
    }

    /**
     * Deteksi OTOMATIS provider (tipe API) dari nama model.
     * Contoh: "gemini-3.6-flash" -> gemini, "gpt-4o" -> openai,
     * "claude-sonnet-4" -> anthropic.
     */
    public static function detectProviderForModel(string $model): ?string
    {
        $model = trim($model);

        if ($model === '') {
            return null;
        }

        foreach (self::PROVIDERS as $key => $class) {
            if ($class::handlesModel($model)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Katalog lengkap semua provider untuk UI Pengaturan Sistem:
     * label, ikon, daftar model (dengan flag GRATIS), status API key
     * (database/.env), serta model aktif per provider.
     *
     * @return array<string, array{key:string, label:string, icon:string, models:array, api_key:array, model:string}>
     */
    public static function providersCatalog(): array
    {
        $catalog = [];

        foreach (self::PROVIDERS as $key => $class) {
            // Model aktif: tabel ai_api_configs -> fallback default kode
            $model = '';
            try {
                $model = trim((string) (AiApiConfig::forProvider($key)->model ?? ''));
            } catch (\Throwable) {
                $model = '';
            }

            if ($model === '') {
                $model = trim((string) config('services.' . $key . '.model', ''));
            }

            $catalog[$key] = [
                'key' => $key,
                'label' => $class::providerLabel(),
                'icon' => match ($key) {
                    'gemini' => 'fa-gem',
                    'openai' => 'fa-robot',
                    default => 'fa-feather',
                },
                'models' => $class::availableModels(),
                'api_key' => $class::apiKeyInfo(),
                'model' => $model,
            ];
        }

        return $catalog;
    }

    /**
     * Info penggunaan AI saat ini (dipakai untuk banner & notifikasi limit).
     */
    public function getUsageInfo(): array
    {
        $row = AiApiConfig::active();

        $limit = (int) ($row->usage_limit ?? 0);
        $period = in_array($row->usage_period, ['daily', 'monthly', 'total'], true) ? $row->usage_period : 'monthly';
        $used = (int) ($row->usage_count ?? 0);
        $storedKey = trim((string) ($row->usage_period_key ?? ''));

        // Auto-reset jika periode berganti (mis. ganti hari/bulan)
        $currentKey = $this->currentPeriodKey($period);
        if ($period !== 'total' && $storedKey !== '' && $storedKey !== $currentKey) {
            $used = 0;
        }

        return [
            'used' => $used,
            'limit' => $limit,
            'period' => $period,
            'period_label' => self::PERIOD_LABELS[$period] ?? $period,
            'remaining' => $limit > 0 ? max(0, $limit - $used) : null,
            'limit_reached' => $limit > 0 && $used >= $limit,
        ];
    }

    /**
     * Naikkan counter pemakaian kuota (dengan auto-reset antar periode).
     */
    private function incrementUsage(): void
    {
        try {
            $row = AiApiConfig::active();
            $period = in_array($row->usage_period, ['daily', 'monthly', 'total'], true) ? $row->usage_period : 'monthly';
            $currentKey = $this->currentPeriodKey($period);
            $storedKey = trim((string) ($row->usage_period_key ?? ''));

            if ($period !== 'total' && $storedKey !== $currentKey) {
                // Periode baru -> reset counter lalu hitung 1
                $row->usage_count = 1;
                $row->usage_period_key = $currentKey;
            } else {
                $row->usage_count = (int) $row->usage_count + 1;
            }

            $row->last_used_at = now();
            $row->save();
        } catch (\Throwable $e) {
            // Pencatatan kuota tidak boleh menggagalkan hasil import yang sukses
            Log::warning('Gagal mencatat pemakaian AI: ' . $e->getMessage());
        }
    }

    private function currentPeriodKey(string $period): string
    {
        return match ($period) {
            'daily' => now()->format('Y-m-d'),
            'monthly' => now()->format('Y-m'),
            default => 'total',
        };
    }
}