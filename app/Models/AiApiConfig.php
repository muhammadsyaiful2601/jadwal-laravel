<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Konfigurasi API AI per provider (gemini / openai / anthropic) untuk fitur
 * "Import Jadwal AI". Satu baris per provider; baris dengan is_active = true
 * adalah provider yang dipakai sistem saat ini.
 *
 * API key disimpan TERENKRIPSI (Crypt::encryptString) dan tidak pernah
 * dikirim balik ke browser — hanya 4 karakter terakhir (masked).
 */
class AiApiConfig extends Model
{
    protected $table = 'ai_api_configs';

    protected $fillable = [
        'provider',
        'api_key_encrypted',
        'model',
        'is_active',
        'usage_limit',
        'usage_period',
        'usage_count',
        'usage_period_key',
        'last_used_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'last_used_at' => 'datetime',
    ];

    public const PROVIDERS = ['gemini', 'openai', 'anthropic'];

    public const DEFAULT_MODELS = [
        'gemini' => 'gemini-3.6-flash',
        'openai' => 'gpt-4o',
        'anthropic' => 'claude-3-5-sonnet-latest',
    ];

    /**
     * Baris konfigurasi untuk satu provider (null bila belum ada / DB belum siap).
     */
    public static function forProvider(string $provider): ?self
    {
        try {
            return self::where('provider', $provider)->first();
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Kunci provider yang sedang AKTIF (fallback aman: 'gemini').
     */
    public static function activeProviderKey(): string
    {
        try {
            $active = self::where('is_active', true)->first();

            if ($active !== null && in_array($active->provider, self::PROVIDERS, true)) {
                return $active->provider;
            }
        } catch (\Throwable) {
            // DB belum siap (migrasi belum jalan) -> fallback default
        }

        return 'gemini';
    }

    /**
     * Baris konfigurasi provider aktif (dibuat otomatis bila belum ada).
     * Selalu mengembalikan instance (fallback: instance belum tersimpan dengan
     * nilai default) sehingga pemanggil tidak perlu menangani null.
     */
    public static function active(): self
    {
        try {
            $key = self::activeProviderKey();

            return self::firstOrCreate(
                ['provider' => $key],
                ['model' => self::DEFAULT_MODELS[$key] ?? null, 'is_active' => true]
            );
        } catch (\Throwable) {
            return new self([
                'provider' => 'gemini',
                'is_active' => true,
                'usage_limit' => 0,
                'usage_period' => 'monthly',
                'usage_count' => 0,
            ]);
        }
    }

    /**
     * Jadikan satu provider satu-satunya yang aktif (model yang sudah tersimpan
     * pada baris provider tidak ditimpa).
     */
    public static function setActiveProvider(string $provider): void
    {
        if (!in_array($provider, self::PROVIDERS, true)) {
            return;
        }

        self::query()->update(['is_active' => false]);

        $row = self::firstOrCreate(['provider' => $provider]);
        $row->is_active = true;
        $row->save();
    }
}