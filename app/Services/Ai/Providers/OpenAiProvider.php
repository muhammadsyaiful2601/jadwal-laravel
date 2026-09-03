<?php

namespace App\Services\Ai\Providers;

use App\Models\AiApiConfig;
use App\Services\Ai\AbstractAiProvider;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiProvider extends AbstractAiProvider
{
    /**
     * OpenAI (ChatGPT) tidak mendukung file PDF secara langsung via
     * chat completions -> beri pesan yang jelas.
     */
    protected function assertDocumentSupported(array $document): void
    {
        if ($document['kind'] === 'pdf') {
            throw new RuntimeException('Provider OpenAI belum mendukung file PDF. Gunakan gambar (PNG/JPG), CSV, atau XLSX — atau pilih provider Gemini/Anthropic.');
        }
    }

    /* =====================================================================
     |  IDENTITAS PROVIDER & KATALOG MODEL (dipakai Pengaturan Sistem)
     * ===================================================================== */

    public static function providerKey(): string
    {
        return 'openai';
    }

    public static function providerLabel(): string
    {
        return 'OpenAI (ChatGPT)';
    }

    /** Deteksi otomatis: gpt-*, o1/o3/o4-*, chatgpt, openai/..., ft:... */
    public static function handlesModel(string $model): bool
    {
        $model = strtolower(trim($model));

        return str_contains($model, 'gpt')
            || str_contains($model, 'chatgpt')
            || str_contains($model, 'openai')
            || str_contains($model, 'davinci')
            || preg_match('/^o\d/', $model) === 1;
    }

    /**
     * Katalog model OpenAI. OpenAI TIDAK punya tier gratis -> free = false.
     *
     * @return array<int, array{id:string, label:string, free:bool, note:string}>
     */
    public static function availableModels(): array
    {
        return [
            ['id' => 'gpt-4o', 'label' => 'GPT-4o — Multimodal', 'free' => false, 'note' => 'Direkomendasikan'],
            ['id' => 'gpt-4o-mini', 'label' => 'GPT-4o Mini', 'free' => false, 'note' => 'Cepat & murah'],
            ['id' => 'gpt-4.1', 'label' => 'GPT-4.1', 'free' => false, 'note' => 'Generasi terbaru'],
            ['id' => 'gpt-4.1-mini', 'label' => 'GPT-4.1 Mini', 'free' => false, 'note' => 'Seimbang'],
            ['id' => 'gpt-4.1-nano', 'label' => 'GPT-4.1 Nano', 'free' => false, 'note' => 'Paling murah'],
        ];
    }

    protected function sendRequest(array $document): string
    {
        // API key: satu-satunya sumber = Pengaturan Sistem (database, terenkripsi).
        $apiKey = $this->getApiKey();

        if ($apiKey === '') {
            throw new RuntimeException('API key OpenAI belum diisi. Buka menu Pengaturan Sistem > card "API Key AI" untuk memasukkannya.');
        }

        $model = $this->resolveModelName();

        $content = [];

        if ($document['kind'] === 'image') {
            $content[] = ['type' => 'text', 'text' => $this->buildInstruction()];
            $content[] = [
                'type' => 'image_url',
                'image_url' => [
                    'url' => 'data:' . $document['mime_type'] . ';base64,' . $document['data'],
                ],
            ];
        } else {
            $content[] = ['type' => 'text', 'text' => $document['data'] . "\n\n" . $this->buildInstruction()];
        }

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => self::SYSTEM_PROMPT],
                ['role' => 'user', 'content' => $content],
            ],
            // JSON mode OpenAI: hasil dijamin objek JSON
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.1,
            'max_tokens' => (int) config('services.openai.max_tokens', 16000),
        ];

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(180)
            ->connectTimeout(15)
            ->post('https://api.openai.com/v1/chat/completions', $payload);

        if ($response->failed()) {
            $message = (string) ($response->json('error.message') ?? ('HTTP ' . $response->status()));

            throw new RuntimeException("OpenAI API error (model {$model}): {$message}");
        }

        $text = $response->json('choices.0.message.content');

        if (!is_string($text) || trim($text) === '') {
            throw new RuntimeException('OpenAI tidak mengembalikan hasil. Silakan coba lagi.');
        }

        return $text;
    }

    /**
     * Ambil nama model dari tabel ai_api_configs (Pengaturan Sistem) atau config.
     */
    private function resolveModelName(): string
    {
        try {
            $dbModel = AiApiConfig::forProvider('openai')?->model;

            if (is_string($dbModel) && trim($dbModel) !== '') {
                return trim($dbModel);
            }
        } catch (\Throwable) {
            // Abaikan -> lanjut ke config default
        }

        return trim((string) config('services.openai.model', 'gpt-4o'));
    }
}