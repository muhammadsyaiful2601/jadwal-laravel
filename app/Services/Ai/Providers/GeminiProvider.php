<?php

namespace App\Services\Ai\Providers;

use App\Models\AiApiConfig;
use App\Services\Ai\AbstractAiProvider;
use App\Services\GeminiModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class GeminiProvider extends AbstractAiProvider
{
    /**
     * Structured output (responseSchema): memaksa Gemini mengembalikan ARRAY of
     * OBJECT dengan field tetap. Kunci utama mencegah error
     * "AI mengembalikan format JSON yang tidak valid".
     */
    private const RESPONSE_SCHEMA = [
        'type' => 'ARRAY',
        'items' => [
            'type' => 'OBJECT',
            'properties' => [
                'hari' => ['type' => 'STRING'],
                'jam_mulai' => ['type' => 'STRING'],
                'jam_selesai' => ['type' => 'STRING'],
                'matakuliah' => ['type' => 'STRING'],
                'ruangan' => ['type' => 'STRING'],
                'dosen' => ['type' => 'STRING'],
                'kelas' => ['type' => 'STRING'],
            ],
            'required' => ['hari', 'jam_mulai', 'jam_selesai', 'matakuliah', 'ruangan', 'dosen', 'kelas'],
        ],
    ];

    /* =====================================================================
     |  IDENTITAS PROVIDER & KATALOG MODEL (dipakai Pengaturan Sistem)
     * ===================================================================== */

    public static function providerKey(): string
    {
        return 'gemini';
    }

    public static function providerLabel(): string
    {
        return 'Google Gemini';
    }

    /** Deteksi otomatis: apakah nama model ini milik Gemini? */
    public static function handlesModel(string $model): bool
    {
        return stripos($model, 'gemini') !== false;
    }

    /**
     * Katalog model Gemini. "free" = punya tier GRATIS di Google AI Studio
     * (kuota harian terbatas) sehingga layak ditandai "GRATIS" di UI.
     *
     * @return array<int, array{id:string, label:string, free:bool, note:string}>
     */
    public static function availableModels(): array
    {
        return [
            ['id' => 'gemini-3.6-flash', 'label' => 'Gemini 3.6 Flash — Stabil', 'free' => true, 'note' => 'Direkomendasikan'],
            ['id' => 'gemini-3.7-flash', 'label' => 'Gemini 3.7 Flash — Terbaru', 'free' => true, 'note' => 'Paling mampu'],
            ['id' => 'gemini-3.5-flash', 'label' => 'Gemini 3.5 Flash', 'free' => true, 'note' => 'Generasi lama'],
            ['id' => 'gemini-3.5-flash-lite', 'label' => 'Gemini 3.5 Flash-Lite', 'free' => true, 'note' => 'Paling cepat & hemat kuota'],
            ['id' => 'gemini-flash-latest', 'label' => 'Gemini Flash Latest', 'free' => true, 'note' => 'Alias otomatis ke Flash terbaru'],
            ['id' => 'gemini-1.5-flash', 'label' => 'Gemini 1.5 Flash', 'free' => false, 'note' => 'Lama — sudah di-retire Google'],
            ['id' => 'gemini-1.5-pro', 'label' => 'Gemini 1.5 Pro', 'free' => false, 'note' => 'Lama — sudah di-retire Google'],
        ];
    }

    protected function sendRequest(array $document): string
    {
        // API key: satu-satunya sumber = Pengaturan Sistem (database, terenkripsi).
        $apiKey = $this->getApiKey();

        if ($apiKey === '') {
            throw new RuntimeException('API key Gemini belum diisi. Buka menu Pengaturan Sistem > card "API Key AI" untuk memasukkannya.');
        }

        $parts = $this->buildParts($document);
        $parts[] = ['text' => $this->buildInstruction()];

        // Susun kandidat model: model utama (dari Pengaturan Sistem) + fallback
        $candidates = [$this->resolveModelName()];

        foreach ((array) config('services.gemini.fallback_models', []) as $fallback) {
            $fallback = $this->sanitizeModelName((string) $fallback);
            if ($fallback !== '' && !in_array($fallback, $candidates, true)) {
                $candidates[] = $fallback;
            }
        }

        $notFoundErrors = [];

        foreach ($candidates as $model) {
            try {
                return $this->requestGenerateContent($apiKey, $model, $parts);
            } catch (GeminiModelNotFoundException $e) {
                $notFoundErrors[] = $e->getMessage();
            }
        }

        $available = implode(', ', $this->listAvailableModels($apiKey));

        throw new RuntimeException(
            'Semua model Gemini tidak tersedia (' . implode('; ', $notFoundErrors) . '). '
            . 'Model yang tersedia untuk generateContent: ' . ($available ?: 'tidak dapat diambil (periksa GEMINI_API_KEY/koneksi)')
            . '. Atur model di menu Pengaturan Sistem.'
        );
    }

    /**
     * Bangun parts Gemini dari dokumen (inlineData untuk image/pdf, text untuk teks).
     */
    private function buildParts(array $document): array
    {
        if ($document['kind'] === 'image' || $document['kind'] === 'pdf') {
            return [[
                'inlineData' => [
                    'mimeType' => $document['mime_type'],
                    'data' => $document['data'],
                ],
            ]];
        }

        return [['text' => $document['data']]];
    }

    /**
     * Ambil nama model utama dari tabel ai_api_configs (Pengaturan Sistem) atau config.
     */
    private function resolveModelName(): string
    {
        try {
            $dbModel = AiApiConfig::forProvider('gemini')?->model;

            if (is_string($dbModel) && trim($dbModel) !== '') {
                return $this->sanitizeModelName($dbModel);
            }
        } catch (\Throwable) {
            // Abaikan (DB belum siap) -> lanjut ke config default
        }

        return $this->sanitizeModelName((string) config('services.gemini.model', 'gemini-3.6-flash'));
    }

    /**
     * Eksekusi request generateContent ke satu model Gemini (dengan auto-retry:
     * responseSchema tidak didukung -> ulang tanpa schema; maxOutputTokens
     * melebihi batas model -> ulang dengan 8192).
     *
     * @throws GeminiModelNotFoundException jika model tidak ditemukan / tidak didukung (404)
     * @throws RuntimeException             untuk error API lainnya
     */
    private function requestGenerateContent(string $apiKey, string $model, array $parts): string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
        $maxTokens = (int) config('services.gemini.max_output_tokens', 65535);
        $withSchema = true;

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $response = Http::withHeaders(['x-goog-api-key' => $apiKey])
                ->acceptJson()
                ->timeout(180)
                ->connectTimeout(15)
                ->post($url, $this->buildPayload($parts, $withSchema, $maxTokens));

            if (!$response->failed()) {
                $data = $response->json();

                return $this->extractResponseText(is_array($data) ? $data : []);
            }

            $status = $response->status();
            $message = (string) ($response->json('error.message') ?? ('HTTP ' . $status));
            $lower = strtolower($message);

            // responseSchema tidak didukung model -> ulang tanpa schema
            if ($status === 400 && $withSchema && str_contains($lower, 'schema')) {
                $withSchema = false;
                continue;
            }

            // maxOutputTokens melebihi batas model -> ulang dengan 8192
            if ($status === 400 && $maxTokens > 8192
                && (str_contains($lower, 'maxoutputtokens') || str_contains($lower, 'max_output_tokens'))) {
                $maxTokens = 8192;
                continue;
            }

            // Model tidak ditemukan / tidak didukung untuk generateContent (mis. sudah di-retire)
            if ($status === 404 || str_contains($lower, 'not found')
                || str_contains($lower, 'not supported for generatecontent')) {
                throw new GeminiModelNotFoundException("Model '{$model}' tidak tersedia ({$message})");
            }

            throw new RuntimeException("Gemini API error (model {$model}): {$message}");
        }

        throw new RuntimeException("Gemini API error (model {$model}): permintaan gagal setelah beberapa percobaan.");
    }

    /**
     * Susun payload generateContent.
     */
    private function buildPayload(array $parts, bool $withSchema, int $maxOutputTokens): array
    {
        $generationConfig = [
            'temperature' => 0.1,
            // Budget besar mencegah JSON terpotong (thinking model 3.x ikut
            // mengonsumsi token output). Bisa diatur via GEMINI_MAX_OUTPUT_TOKENS.
            'maxOutputTokens' => $maxOutputTokens,
            // JSON mode: hasil dijamin JSON murni tanpa markdown
            'responseMimeType' => 'application/json',
        ];

        if ($withSchema) {
            $generationConfig['responseSchema'] = self::RESPONSE_SCHEMA;
        }

        return [
            'systemInstruction' => ['parts' => [['text' => self::SYSTEM_PROMPT]]],
            'contents' => [['role' => 'user', 'parts' => $parts]],
            'generationConfig' => $generationConfig,
        ];
    }

    /**
     * Ambil teks jawaban dari respons Gemini.
     *
     * PENTING (penyebab utama error "format JSON tidak valid"): model Gemini
     * 2.5/3.x mengembalikan part "thinking" ("thought": true) SEBELUM jawaban
     * akhir. Mengambil hanya parts[0] membuat decoder menerima teks pikiran
     * (prosa), bukan JSON. Karena itu teks digabung dari SEMUA part non-thought.
     */
    private function extractResponseText(array $data): string
    {
        // Permintaan diblokir filter keamanan
        $blockReason = $data['promptFeedback']['blockReason'] ?? null;
        if ($blockReason) {
            throw new RuntimeException("Permintaan diblokir filter keamanan Gemini ({$blockReason}). Coba dokumen lain.");
        }

        $candidate = $data['candidates'][0] ?? null;

        if (!is_array($candidate)) {
            throw new RuntimeException('Gemini tidak mengembalikan kandidat hasil. Silakan coba lagi.');
        }

        $finishReason = $candidate['finishReason'] ?? null;

        // Gabungkan teks dari semua part, lewati part thinking
        $text = '';
        foreach ((array) ($candidate['content']['parts'] ?? []) as $part) {
            if (!empty($part['thought'])) {
                continue;
            }
            if (isset($part['text']) && is_string($part['text'])) {
                $text .= $part['text'];
            }
        }

        if (trim($text) === '') {
            if ($finishReason === 'MAX_TOKENS') {
                throw new RuntimeException('Hasil AI terpotong karena melebihi batas token output (thinking model memakan budget). Coba dokumen dengan baris jadwal lebih sedikit, atau naikkan GEMINI_MAX_OUTPUT_TOKENS.');
            }

            throw new RuntimeException('Gemini tidak mengembalikan teks (' . ($finishReason ?? 'respons kosong') . '). Silakan coba lagi.');
        }

        if ($finishReason === 'MAX_TOKENS') {
            Log::warning('Import Jadwal AI: respons Gemini terpotong (MAX_TOKENS), decoder akan mencoba menolong hasil.');
        }

        return $text;
    }

    /**
     * Panggil ModelService.ListModels untuk mendapatkan daftar model yang
     * mendukung generateContent (dipakai untuk pesan error yang informatif).
     *
     * @return array<int, string> daftar nama model (tanpa prefix "models/")
     */
    private function listAvailableModels(string $apiKey): array
    {
        try {
            $response = Http::withHeaders(['x-goog-api-key' => $apiKey])
                ->acceptJson()
                ->timeout(30)
                ->connectTimeout(15)
                ->get('https://generativelanguage.googleapis.com/v1beta/models', ['pageSize' => 1000]);

            if ($response->failed()) {
                return [];
            }

            $models = [];

            foreach ((array) $response->json('models') as $model) {
                $methods = (array) ($model['supportedGenerationMethods'] ?? []);

                if (!in_array('generateContent', $methods, true)) {
                    continue;
                }

                $name = $this->sanitizeModelName((string) ($model['name'] ?? ''));

                if ($name !== '') {
                    $models[] = $name;
                }
            }

            return $models;
        } catch (\Throwable) {
            return [];
        }
    }
}