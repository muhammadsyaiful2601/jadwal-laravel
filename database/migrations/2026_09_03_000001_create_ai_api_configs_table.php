<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel konfigurasi API AI untuk fitur "Import Jadwal AI".
     * Satu baris per provider (gemini / openai / anthropic):
     *
     * - api_key_encrypted : API key TERENKRIPSI (Crypt::encryptString). Sebelumnya
     *                       tersimpan di tabel settings (kunci ai_api_key_*) dan
     *                       dimigrasi otomatis ke sini oleh migrasi ini.
     * - model             : nama model aktif per provider (sebelumnya ai_model_*).
     * - is_active         : provider yang dipakai sistem (sebelumnya setting ai_provider).
     * - usage_*           : limit & counter pemakaian per provider (sebelumnya
     *                       ai_usage_limit / ai_usage_period / ai_usage_count /
     *                       ai_usage_period_key yang bersifat global).
     */
    public function up(): void
    {
        Schema::create('ai_api_configs', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 32)->unique();
            $table->text('api_key_encrypted')->nullable();
            $table->string('model', 100)->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('usage_limit')->default(0);      // 0 = tanpa batas
            $table->string('usage_period', 16)->default('monthly');  // daily|monthly|total
            $table->unsignedInteger('usage_count')->default(0);
            $table->string('usage_period_key', 16)->nullable();      // Y-m-d / Y-m / total
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });

        // ---- Migrasi data dari tabel settings (bila sudah ada) ----
        if (!Schema::hasTable('settings')) {
            return;
        }

        $setting = function (string $key): ?string {
            $value = DB::table('settings')->where('setting_key', $key)->value('setting_value');

            return $value === null ? null : (string) $value;
        };

        $defaults = [
            'gemini' => 'gemini-3.6-flash',
            'openai' => 'gpt-4o',
            'anthropic' => 'claude-3-5-sonnet-latest',
        ];

        $activeProvider = $setting('ai_provider');
        $activeProvider = in_array($activeProvider, array_keys($defaults), true) ? $activeProvider : 'gemini';

        foreach ($defaults as $provider => $defaultModel) {
            DB::table('ai_api_configs')->updateOrInsert(
                ['provider' => $provider],
                [
                    // Payload terenkripsi disalin apa adanya (APP_KEY sama -> tetap bisa didekripsi)
                    'api_key_encrypted' => $setting("ai_api_key_{$provider}"),
                    'model' => ($setting("ai_model_{$provider}") !== null && $setting("ai_model_{$provider}") !== '')
                        ? $setting("ai_model_{$provider}")
                        : $defaultModel,
                    'is_active' => $provider === $activeProvider,
                    'usage_limit' => (int) ($setting('ai_usage_limit') ?? 0),
                    'usage_period' => ($setting('ai_usage_period') !== null && $setting('ai_usage_period') !== '')
                        ? $setting('ai_usage_period')
                        : 'monthly',
                    'usage_count' => (int) ($setting('ai_usage_count') ?? 0),
                    'usage_period_key' => $setting('ai_usage_period_key'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_api_configs');
    }
};