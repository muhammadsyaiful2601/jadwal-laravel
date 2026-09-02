<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiScheduleImportService
{
    /**
     * System prompt wajib untuk ekstraksi jadwal (sesuai spesifikasi fitur).
     */
    public const SYSTEM_PROMPT =
        'Kamu adalah asisten ekstraksi data. Baca dokumen jadwal kuliah terlampir dan ekstrak datanya '
        . 'ke dalam array JSON yang terstruktur. Format JSON yang wajib digunakan: '
        . "[{'hari': 'Senin', 'jam_mulai': '08:00', 'jam_selesai': '10:30', 'matakuliah': 'Nama MK', 'ruangan': 'Nama Ruang', 'dosen': 'Nama Dosen'}]. "
        . 'Jangan tambahkan teks markdown atau penjelasan apapun selain output JSON murni.';

    /**
     * File yang didukung Gemini sebagai inline data (multimodal).
     * Selain format ini (csv, xlsx) diparse manual menjadi teks.
     */
    private const INLINE_MIMES = [
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
    ];

    /** Batas baris yang dikirim ke AI untuk file berbasis teks. */
    private const MAX_TEXT_ROWS = 500;

    /**
     * Ekstrak daftar jadwal dari file dokumen menggunakan Gemini 1.5 Flash.
     *
     * @param  string  $realPath   Path absolut file yang diupload
     * @param  string  $extension  Ekstensi file (pdf, xlsx, csv, png, jpg, jpeg)
     * @return array<int, array{hari:string, jam_mulai:string, jam_selesai:string, matakuliah:string, ruangan:string, dosen:string, kelas:string}>
     */
    public function extractSchedules(string $realPath, string $extension): array
    {
        $extension = strtolower(trim($extension, ". \t\n\r"));

        if (isset(self::INLINE_MIMES[$extension])) {
            // PDF / PNG / JPG -> dikirim langsung ke Gemini (multimodal inline data)
            $content = file_get_contents($realPath);
            if ($content === false) {
                throw new RuntimeException('File tidak dapat dibaca.');
            }

            $parts = [
                [
                    'inlineData' => [
                        'mimeType' => self::INLINE_MIMES[$extension],
                        'data' => base64_encode($content),
                    ],
                ],
            ];
        } elseif ($extension === 'csv') {
            // Gemini tidak membaca CSV secara native -> parse menjadi teks
            $parts = [['text' => $this->buildDocumentText('CSV', $this->parseCsv($realPath))]];
        } elseif ($extension === 'xlsx') {
            // Gemini tidak membaca XLSX secara native -> parse menjadi teks
            $parts = [['text' => $this->buildDocumentText('XLSX', $this->parseXlsx($realPath))]];
        } else {
            throw new RuntimeException("Format file .{$extension} tidak didukung.");
        }

        // Instruksi tambahan pada pesan user (system prompt tetap sesuai spesifikasi).
        // Field "kelas" dibutuhkan karena tabel schedules mewajibkannya.
        $parts[] = [
            'text' => 'Ekstrak SEMUA baris jadwal kuliah dari dokumen di atas ke dalam array JSON sesuai format. '
                . 'Jika dokumen memuat informasi kelas, sertakan juga field "kelas" berisi nama kelasnya. '
                . 'Jika tidak ditemukan, isi field "kelas" dengan string kosong "". '
                . 'Jawab HANYA array JSON murni tanpa teks lain.',
        ];

        $raw = $this->callGemini($parts);
        $items = $this->decodeJsonArray($raw);

        $normalized = [];
        foreach ($items as $item) {
            $row = $this->normalizeItem($item);
            if ($row !== null) {
                $normalized[] = $row;
            }
        }

        return $normalized;
    }

    /**
     * Panggil endpoint generateContent Gemini.
     *
     * [PERMINTAAN #1] Nama model TANPA prefix "models/" — dibersihkan otomatis
     * oleh sanitizeModelName() sehingga pengisian GEMINI_MODEL=models/gemini-3.6-flash
     * di .env pun tetap aman.
     *
     * [PERMINTAAN #4] Model utama: gemini-3.6-flash.
     * [FALLBACK OTOMATIS] Jika model utama "not found" (mis. sudah di-retire Google
     * seperti gemini-1.5-flash), kandidat model berikutnya dicoba berurutan.
     */
    public function callGemini(array $parts): string
    {
        $apiKey = trim((string) config('services.gemini.key'));
        if ($apiKey === '') {
            throw new RuntimeException('GEMINI_API_KEY belum diisi di file .env');
        }

        // [PERMINTAAN #3 — FALLBACK MANUAL]
        // Jika ingin mengganti model secara permanen, ubah GEMINI_MODEL di .env,
        // atau un-comment baris 'model' alternatif di config/services.php, contoh:
        //   'model' => env('GEMINI_MODEL', 'gemini-1.5-pro'),   // model lama (sudah di-retire Google)
        //   'model' => env('GEMINI_MODEL', 'gemini-3.7-flash'), // model terbaru

        // Susun kandidat model: model utama + fallback otomatis dari config
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
                // Model tidak ditemukan / tidak didukung -> coba kandidat berikutnya
                $notFoundErrors[] = $e->getMessage();
            }
        }

        // Semua kandidat gagal "not found" -> tampilkan model yang BENAR-BENAR tersedia
        // (sesuai saran error API: "Call ModelService.ListModels to see the list of
        // available models and their supported methods")
        $available = implode(', ', $this->listAvailableModels($apiKey));

        throw new RuntimeException(
            'Semua model Gemini tidak tersedia (' . implode('; ', $notFoundErrors) . '). '
            . 'Model yang tersedia untuk generateContent: ' . ($available ?: 'tidak dapat diambil (periksa GEMINI_API_KEY/koneksi)')
            . '. Atur GEMINI_MODEL di file .env ke salah satu model tersebut.'
        );
    }

    /**
     * Ambil nama model utama dari config, sudah dibersihkan dari prefix "models/".
     */
    private function resolveModelName(): string
    {
        return $this->sanitizeModelName((string) config('services.gemini.model', 'gemini-3.6-flash'));
    }

    /**
     * [PERMINTAAN #1] Bersihkan nama model:
     * - hapus prefix "models/" (jika user mengisi nama resource lengkap di .env)
     * - hapus akhiran ":generateContent" (jika ada)
     * - rapikan whitespace / slash berlebih
     */
    private function sanitizeModelName(string $model): string
    {
        $model = trim($model);
        $model = preg_replace('#^models/#i', '', $model) ?? $model;
        $model = preg_replace('#:generateContent$#i', '', $model) ?? $model;

        return trim($model, "/ \t\n\r");
    }

    /**
     * Eksekusi request generateContent ke satu model Gemini.
     *
     * @throws GeminiModelNotFoundException jika model tidak ditemukan / tidak didukung (404)
     * @throws RuntimeException             untuk error API lainnya
     */
    private function requestGenerateContent(string $apiKey, string $model, array $parts): string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $payload = [
            'systemInstruction' => [
                'parts' => [['text' => self::SYSTEM_PROMPT]],
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => $parts,
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.1,
                'maxOutputTokens' => 8192,
                // Memaksa model mengembalikan JSON murni (tanpa markdown)
                'responseMimeType' => 'application/json',
            ],
        ];

        $response = Http::withHeaders(['x-goog-api-key' => $apiKey])
            ->acceptJson()
            ->timeout(180)
            ->connectTimeout(15)
            ->post($url, $payload);

        if ($response->failed()) {
            $message = (string) ($response->json('error.message') ?? ('HTTP ' . $response->status()));
            $status = $response->status();
            $lowerMessage = strtolower($message);

            // Model tidak ditemukan / tidak didukung untuk generateContent
            // (contoh: "models/gemini-1.5-flash is not found for API version v1beta,
            //  or is not supported for generateContent")
            if ($status === 404 || str_contains($lowerMessage, 'not found') || str_contains($lowerMessage, 'not supported')) {
                throw new GeminiModelNotFoundException("Model '{$model}' tidak tersedia ({$message})");
            }

            throw new RuntimeException("Gemini API error (model {$model}): {$message}");
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (!is_string($text) || trim($text) === '') {
            $reason = $response->json('candidates.0.finishReason') ?? 'respons kosong';
            throw new RuntimeException("Gemini tidak mengembalikan hasil ({$reason}). Coba gunakan dokumen yang lebih jelas.");
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

    /**
     * Decode output AI menjadi array PHP. Tahan banting terhadap
     * markdown fence maupun wrapper objek seperti {"data": [...]}.
     */
    protected function decodeJsonArray(string $raw): array
    {
        $text = trim($raw);
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);
        $text = trim($text);

        $decoded = json_decode($text, true);

        if (is_array($decoded)) {
            // Bentuk objek wrapper {"data": [...]} / {"schedules": [...]} / {"jadwal": [...]}
            foreach (['data', 'schedules', 'jadwal'] as $key) {
                if (isset($decoded[$key]) && is_array($decoded[$key])) {
                    $decoded = $decoded[$key];
                    break;
                }
            }

            if (array_is_list($decoded)) {
                return array_values(array_filter($decoded, 'is_array'));
            }
        }

        // Fallback: ambil substring dari '[' pertama hingga ']' terakhir
        $start = strpos($text, '[');
        $end = strrpos($text, ']');

        if ($start !== false && $end !== false && $end > $start) {
            $decoded = json_decode(substr($text, $start, $end - $start + 1), true);

            if (is_array($decoded)) {
                return array_values(array_filter($decoded, 'is_array'));
            }
        }

        throw new RuntimeException('AI mengembalikan format JSON yang tidak valid. Silakan coba lagi.');
    }

    /**
     * Normalisasi satu baris hasil ekstraksi AI.
     */
    protected function normalizeItem($item): ?array
    {
        if (!is_array($item)) {
            return null;
        }

        $matakuliah = trim((string) ($item['matakuliah'] ?? $item['mata_kuliah'] ?? ''));
        $ruangan = trim((string) ($item['ruangan'] ?? $item['ruang'] ?? ''));
        $dosen = trim((string) ($item['dosen'] ?? ''));
        $hari = self::normalizeHari($item['hari'] ?? '');
        $jamMulai = self::normalizeJam($item['jam_mulai'] ?? '');
        $jamSelesai = self::normalizeJam($item['jam_selesai'] ?? '');

        // Abaikan baris yang benar-benar kosong
        if ($matakuliah === '' && $ruangan === '' && $dosen === '' && $hari === '') {
            return null;
        }

        return [
            'hari' => $hari,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'matakuliah' => $matakuliah,
            'ruangan' => $ruangan,
            'dosen' => $dosen,
            'kelas' => trim((string) ($item['kelas'] ?? '')),
        ];
    }

    /**
     * Normalisasi nama hari ke format huruf kapital yang dipakai database
     * (SENIN, SELASA, RABU, KAMIS, JUMAT, ...).
     */
    public static function normalizeHari($value): string
    {
        $hari = strtoupper(trim((string) $value));
        $hari = preg_replace('/[^A-Z]/', '', $hari) ?? '';

        $map = [
            'SENIN' => 'SENIN', 'SENI' => 'SENIN', 'MONDAY' => 'SENIN', 'MON' => 'SENIN',
            'SELASA' => 'SELASA', 'TUESDAY' => 'SELASA', 'TUE' => 'SELASA',
            'RABU' => 'RABU', 'WEDNESDAY' => 'RABU', 'WED' => 'RABU',
            'KAMIS' => 'KAMIS', 'THURSDAY' => 'KAMIS', 'THU' => 'KAMIS',
            'JUMAT' => 'JUMAT', 'JUMATAN' => 'JUMAT', 'FRIDAY' => 'JUMAT', 'FRI' => 'JUMAT',
            'SABTU' => 'SABTU', 'SATURDAY' => 'SABTU', 'SAT' => 'SABTU',
            'MINGGU' => 'MINGGU', 'SUNDAY' => 'MINGGU', 'SUN' => 'MINGGU',
        ];

        return $map[$hari] ?? $hari;
    }

    /**
     * Normalisasi format jam menjadi "HH:MM"
     * (mendukung "8:00", "08.00", "0800", "8", "08:00:00", dst).
     */
    public static function normalizeJam($value): string
    {
        $jam = trim((string) $value);
        if ($jam === '') {
            return '';
        }

        $jam = str_replace('.', ':', $jam);
        $jam = preg_replace('/\s+/', '', $jam) ?? '';

        if (preg_match('/^(\d{1,2}):(\d{2})(?::\d{2})?$/', $jam, $m)) {
            return sprintf('%02d:%02d', (int) $m[1], (int) $m[2]);
        }

        if (preg_match('/^(\d{1,2}):(\d)$/', $jam, $m)) {
            return sprintf('%02d:%d0', (int) $m[1], (int) $m[2]);
        }

        if (preg_match('/^(\d{4})$/', $jam, $m)) {
            return sprintf('%02d:%02d', (int) substr($m[1], 0, 2), (int) substr($m[1], 2, 2));
        }

        if (preg_match('/^(\d{1,2})$/', $jam, $m)) {
            return sprintf('%02d:00', (int) $m[1]);
        }

        // Fallback: coba parse via strtotime
        $ts = strtotime($jam);
        if ($ts !== false) {
            return date('H:i', $ts);
        }

        return $jam;
    }

    protected function buildDocumentText(string $type, string $content): string
    {
        return "Berikut isi dokumen {$type} berupa jadwal kuliah (dipisah per baris, kolom dipisah \" | \"):\n\n{$content}\n";
    }

    /**
     * Parse file CSV menjadi teks terstruktur (mendukung delimiter koma/titik koma).
     */
    protected function parseCsv(string $path): string
    {
        $handle = fopen($path, 'r');
        if ($handle === false) {
            throw new RuntimeException('File CSV tidak dapat dibaca.');
        }

        $firstLine = (string) fgets($handle);
        rewind($handle);

        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

        $lines = [];
        $rowNumber = 0;

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rowNumber++;
            $data = array_map(fn ($v) => trim((string) $v), $data);

            if (implode('', $data) === '') {
                continue;
            }

            $lines[] = 'Baris ' . $rowNumber . ': ' . implode(' | ', $data);

            if ($rowNumber >= self::MAX_TEXT_ROWS) {
                break;
            }
        }

        fclose($handle);

        if (empty($lines)) {
            throw new RuntimeException('File CSV kosong / tidak berisi data yang bisa dibaca.');
        }

        return implode("\n", $lines);
    }

    /**
     * Parse file XLSX menjadi teks terstruktur tanpa library eksternal
     * (menggunakan ZipArchive + SimpleXML bawaan PHP).
     */
    protected function parseXlsx(string $path): string
    {
        if (!class_exists(\ZipArchive::class)) {
            throw new RuntimeException('Ekstensi PHP "zip" tidak tersedia untuk membaca file XLSX. Gunakan CSV/PDF sebagai alternatif.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new RuntimeException('File XLSX tidak dapat dibuka.');
        }

        // 1) Baca sharedStrings (kumpulan teks sel bertipe "s")
        $sharedStrings = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml !== false) {
            $xml = simplexml_load_string($sharedXml);
            if ($xml !== false) {
                foreach ($xml->si as $si) {
                    $text = '';
                    foreach ($si->t as $t) {
                        $text .= (string) $t;
                    }
                    if ($text === '' && isset($si->r)) {
                        foreach ($si->r as $run) {
                            $text .= (string) $run->t;
                        }
                    }
                    $sharedStrings[] = $text;
                }
            }
        }

        // 2) Cari worksheet pertama
        $sheetPath = 'xl/worksheets/sheet1.xml';
        if ($zip->locateName($sheetPath) === false) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = (string) $zip->getNameIndex($i);
                if (preg_match('#^xl/worksheets/sheet\d+\.xml$#', $name)) {
                    $sheetPath = $name;
                    break;
                }
            }
        }

        $sheetXml = $zip->getFromName($sheetPath);
        $zip->close();

        if ($sheetXml === false) {
            throw new RuntimeException('Worksheet pertama tidak ditemukan dalam file XLSX.');
        }

        $xml = simplexml_load_string($sheetXml);
        if ($xml === false) {
            throw new RuntimeException('File XLSX tidak valid (XML rusak).');
        }

        // 3) Iterasi baris & sel
        $lines = [];
        $rowIndex = 0;

        foreach ($xml->sheetData->row as $row) {
            $rowIndex++;

            $cells = [];
            foreach ($row->c as $cell) {
                $colRef = preg_replace('/\d+/', '', (string) $cell['r']) ?? '';
                $type = (string) $cell['t'];
                $value = '';

                if ($type === 's') {
                    $value = $sharedStrings[(int) $cell->v] ?? '';
                } elseif ($type === 'inlineStr') {
                    foreach ($cell->is->t as $t) {
                        $value .= (string) $t;
                    }
                } elseif (isset($cell->v)) {
                    $value = (string) $cell->v;
                }

                $value = trim($value);
                if ($value !== '') {
                    $cells[] = $colRef . ': ' . $value;
                }
            }

            if (empty($cells)) {
                continue;
            }

            $lines[] = 'Baris ' . $rowIndex . ': ' . implode(' | ', $cells);

            if ($rowIndex >= self::MAX_TEXT_ROWS) {
                break;
            }
        }

        if (empty($lines)) {
            throw new RuntimeException('File XLSX tidak berisi data yang bisa dibaca.');
        }

        return implode("\n", $lines);
    }
}
