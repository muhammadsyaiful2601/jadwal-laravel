<?php

namespace App\Services\Ai\Providers;

use App\Models\AiApiConfig;
use App\Services\Ai\AbstractAiProvider;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AnthropicProvider extends AbstractAiProvider
{
    /* =====================================================================
     |  IDENTITAS PROVIDER & KATALOG MODEL (dipakai Pengaturan Sistem)
     * ===================================================================== */

    public static function providerKey(): string
    {
        return 'anthropic';
    }

    public static function providerLabel(): string
    {
        return 'Anthropic Claude';
    }

    /** Deteksi otomatis: claude-*, anthropic/... */
    public static function handlesModel(string $model): bool
    {
        $model = strtolower(trim($model));

        return str_contains($model, 'claude') || str_contains($model, 'anthropic');
    }

    /**
     * Katalog model Anthropic. Anthropic TIDAK punya tier gratis -> free = false.
     *
     * @return array<int, array{id:string, label:string, free:bool, note:string}>
     */
    public static function availableModels(): array
    {
        return [
            ['id' => 'claude-sonnet-4', 'label' => 'Claude Sonnet 4', 'free' => false, 'note' => 'Paling mampu'],
            ['id' => 'claude-3-7-sonnet-latest', 'label' => 'Claude 3.7 Sonnet', 'free' => false, 'note' => 'Terbaru'],
            ['id' => 'claude-3-5-sonnet-latest', 'label' => 'Claude 3.5 Sonnet', 'free' => false, 'note' => 'Seimbang — Direkomendasikan'],
            ['id' => 'claude-3-5-haiku-latest', 'label' => 'Claude 3.5 Haiku', 'free' => false, 'note' => 'Cepat & murah'],
        ];
    }

    protected function sendRequest(array $document): string
    {
        // API key: satu-satunya sumber = Pengaturan Sistem (database, terenkripsi).
        $apiKey = $this->getApiKey();

        if ($apiKey === '') {
            throw new RuntimeException('API key Anthropic belum diisi. Buka menu Pengaturan Sistem > card "API Key AI" untuk memasukkannya.');
        }

        $model = $this->resolveModelName();

        $content = [];

        if ($document['kind'] === 'image') {
            $content[] = [
                'type' => 'image',
                'source' => [
                    'type' => 'base64',
                    'media_type' => $document['mime_type'],
                    'data' => $document['data'],
                ],
            ];
        } elseif ($document['kind'] === 'pdf') {
            $content[] = [
                'type' => 'document',
                'source' => [
                    'type' => 'base64',
                    'media_type' => 'application/pdf',
                    'data' => $document['data'],
                ],
            ];
        } else {
            $content[] = ['type' => 'text', 'text' => $document['data']];
        }

        $content[] = ['type' => 'text', 'text' => $this->buildInstruction()];

        $payload = [
            'model' => $model,
            'max_tokens' => (int) config('services.anthropic.max_tokens', 16000),
            'temperature' => 0.1,
            'system' => self::SYSTEM_PROMPT,
            'messages' => [
                ['role' => 'user', 'content' => $content],
            ],
        ];

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
        ])
            ->acceptJson()
            ->timeout(180)
            ->connectTimeout(15)
            ->post('https://api.anthropic.com/v1/messages', $payload);

        if ($response->failed()) {
            $message = (string) ($response->json('error.message') ?? ('HTTP ' . $response->status()));

            throw new RuntimeException("Anthropic API error (model {$model}): {$message}");
        }

        // Gabungkan teks dari semua content block (lewati block non-teks)
        $text = '';
        foreach ((array) $response->json('content') as $block) {
            if (isset($block['type']) && $block['type'] === 'text' && isset($block['text'])) {
                $text .= $block['text'];
            }
        }

        if (trim($text) === '') {
            $stopReason = $response->json('stop_reason') ?? 'respons kosong';

            throw new RuntimeException("Anthropic tidak mengembalikan hasil ({$stopReason}). Silakan coba lagi.");
        }

        return $text;
    }

    /**
     * Ambil nama model dari tabel ai_api_configs (Pengaturan Sistem) atau config.
     */
    private function resolveModelName(): string
    {
        try {
            $dbModel = AiApiConfig::forProvider('anthropic')?->model;

            if (is_string($dbModel) && trim($dbModel) !== '') {
                return trim($dbModel);
            }
        } catch (\Throwable) {
            // Abaikan -> lanjut ke config default
        }

        return trim((string) config('services.anthropic.model', 'claude-3-5-sonnet-latest'));
    }
}