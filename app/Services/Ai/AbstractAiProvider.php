<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Base class untuk semua provider AI (Gemini, OpenAI, Anthropic).
 * Berisi logika bersama: prompt, persiapan dokumen, decode JSON,
 * normalisasi data, dan parser CSV/XLSX.
 */
abstract class AbstractAiProvider implements AiProviderInterface
{
    /**
     * System prompt wajib untuk ekstraksi jadwal (sesuai spesifikasi fitur).
     */
    public const SYSTEM_PROMPT =
        'Kamu adalah asisten ekstraksi data. Baca dokumen jadwal kuliah terlampir dan ekstrak datanya '
        . 'ke dalam array JSON yang terstruktur. Format JSON yang wajib digunakan: '
        . "[{'hari': 'Senin', 'jam_mulai': '08:00', 'jam_selesai': '10:30', 'matakuliah': 'Nama MK', 'ruangan': 'Nama Ruang', 'dosen': 'Nama Dosen'}]. "
        . 'Jangan tambahkan teks markdown atau penjelasan apapun selain output JSON murni.';

    /** Batas baris yang dikirim ke AI untuk file berbasis teks. */
    private const MAX_TEXT_ROWS = 500;

    /** Ekstensi yang didukung semua provider. */
    protected const SUPPORTED_EXTENSIONS = ['pdf', 'xlsx', 'csv', 'png', 'jpg', 'jpeg'];

    public function extractSchedules(string $realPath, string $extension): array
    {
        $extension = strtolower(trim($extension, ". \t\n\r"));

        if (!in_array($extension, self::SUPPORTED_EXTENSIONS, true)) {
            throw new RuntimeException("Format file .{$extension} tidak didukung.");
        }

        $document = $this->prepareDocument($realPath, $extension);
        $this->assertDocumentSupported($document);

        $raw = $this->sendRequest($document);
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
     * Kirim dokumen ke API provider dan kembalikan teks JSON mentah.
     */
    abstract protected function sendRequest(array $document): string;

    /**
     * Cek apakah provider mendukung delimiter koma/titik koma).
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

    /* =====================================================================
     |  PERSIAPAN DOKUMEN (multimodal & berbasis teks)
     * ===================================================================== */

    /**
     * Ubah file upload menjadi struktur dokumen yang siap dikirim ke API:
     * - pdf/png/jpg -> base64 (multimodal)
     * - csv/xlsx    -> teks terstruktur hasil parser lokal
     *
     * @return array{kind:string, mime_type:string, data:string}
     */
    protected function prepareDocument(string $realPath, string $extension): array
    {
        $mimeMap = [
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
        ];

        if (isset($mimeMap[$extension])) {
            $raw = @file_get_contents($realPath);

            if ($raw === false || $raw === '') {
                throw new RuntimeException('File tidak dapat dibaca. Silakan coba lagi.');
            }

            return [
                'kind' => $extension === 'pdf' ? 'pdf' : 'image',
                'mime_type' => $mimeMap[$extension],
                'data' => base64_encode($raw),
            ];
        }

        if ($extension === 'csv') {
            return ['kind' => 'text', 'mime_type' => 'text/plain', 'data' => $this->parseCsv($realPath)];
        }

        if ($extension === 'xlsx') {
            return ['kind' => 'text', 'mime_type' => 'text/plain', 'data' => $this->parseXlsx($realPath)];
        }

        throw new RuntimeException("Format file .{$extension} tidak didukung.");
    }

    /**
     * Validasi dasar dokumen (dapat di-override per provider, mis. OpenAI
     * yang belum mendukung PDF).
     */
    protected function assertDocumentSupported(array $document): void
    {
        if (!isset($document['kind'], $document['data']) || trim((string) $document['data']) === '') {
            throw new RuntimeException('Dokumen kosong / tidak dapat dibaca. Silakan coba lagi.');
        }
    }

    /**
     * Instruksi tambahan setelah system prompt (aturan format output).
     */
    protected function buildInstruction(): string
    {
        return self::SYSTEM_PROMPT . "\n\n"
            . "Aturan tambahan:\n"
            . "1. Output HANYA array JSON murni, tanpa markdown, tanpa penjelasan.\n"
            . "2. 'hari' harus salah satu dari: SENIN, SELASA, RABU, KAMIS, JUMAT, SABTU, MINGGU.\n"
            . "3. 'jam_mulai' dan 'jam_selesai' format 24 jam HH:MM (contoh: 08:00, 13:40).\n"
            . "4. Sertakan 'kelas' bila terbaca di dokumen; jika tidak ada isi string kosong.\n"
            . "5. Abaikan baris yang bukan jadwal kuliah.";
    }

    /**
     * Bersihkan nama model: buang prefix "models/", akhiran ":generateContent",
     * dan karakter lebih.
     */
    protected function sanitizeModelName(string $name): string
    {
        $name = trim($name);
        $name = preg_replace('#^models/#i', '', $name) ?? $name;
        $name = preg_replace('#:generateContent$#i', '', $name) ?? $name;

        return trim($name, "/ \t\n\r");
    }

    /* =====================================================================
     |  DECODER JSON ANTI-GAGAL
     |  Menangani: markdown fence, wrapper {data:[...]}, teks liar di sekitar
     |  JSON, hasil terpotong (MAX_TOKENS), koma menggantung, objek rusak.
     * ===================================================================== */

    protected function decodeJsonArray(string $raw): array
    {
        $raw = trim($raw);

        // 0) Lepas markdown fence ```json ... ```
        $candidate = $raw;
        if (preg_match('/```(?:json)?\s*(.*?)```/is', $raw, $fenced) && trim($fenced[1]) !== '') {
            $candidate = trim($fenced[1]);
        }

        // 1) Decode langsung (candidate lalu raw)
        foreach ([$candidate, $raw] as $attempt) {
            $list = $this->tryDecodeList($attempt);
            if ($list !== null) {
                return $list;
            }
        }

        // 2) Ekstrak substring array lengkap [ ... ]
        if (preg_match('/\[.*\]/s', $candidate, $m)) {
            $list = $this->tryDecodeList($m[0]);
            if ($list !== null) {
                return $list;
            }
        }

        // 3) Hasil terpotong: mulai dari "[" pertama lalu perbaiki ujungnya
        $start = strpos($candidate, '[');
        if ($start !== false) {
            $list = $this->tryDecodeList($this->repairTruncatedArray(substr($candidate, $start)));
            if ($list !== null) {
                return $list;
            }
        }

        // 4) Objek tunggal tanpa array, atau wrapper {data:[...]}/{items:[...]}
        if (preg_match('/\{.*\}/s', $candidate, $obj)) {
            $decoded = json_decode($obj[0], true);
            if (is_array($decoded)) {
                if (isset($decoded[0]) || array_is_list($decoded)) {
                    $list = array_values(array_filter($decoded, 'is_array'));
                    if ($list !== []) {
                        return $list;
                    }
                }
                foreach (['data', 'items', 'schedules', 'result'] as $wrapKey) {
                    if (isset($decoded[$wrapKey]) && is_array($decoded[$wrapKey])) {
                        $list = array_values(array_filter($decoded[$wrapKey], 'is_array'));
                        if ($list !== []) {
                            return $list;
                        }
                    }
                }
                if (isset($decoded['hari'])) {
                    return [$decoded];
                }
            }
        }

        Log::error('Import Jadwal AI: AI mengembalikan output yang tidak bisa diparse sebagai JSON.', [
            'raw_head' => substr($raw, 0, 500),
            'raw_tail' => substr($raw, -300),
        ]);

        throw new RuntimeException('AI mengembalikan format JSON yang tidak valid. Silakan coba lagi.');
    }

    /**
     * Coba decode string sebagai daftar item jadwal. Return null bila bukan.
     */
    private function tryDecodeList(string $json): ?array
    {
        $json = trim($json);
        if ($json === '') {
            return null;
        }

        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            return null;
        }

        if (array_is_list($decoded)) {
            $list = array_values(array_filter($decoded, 'is_array'));

            return $list === [] ? null : $list;
        }

        foreach (['data', 'items', 'schedules', 'result'] as $wrapKey) {
            if (isset($decoded[$wrapKey]) && is_array($decoded[$wrapKey])) {
                $list = array_values(array_filter($decoded[$wrapKey], 'is_array'));

                return $list === [] ? null : $list;
            }
        }

        if (isset($decoded['hari'])) {
            return [$decoded];
        }

        return null;
    }

    /**
     * Perbaiki JSON array yang terpotong (mis. karena MAX_TOKENS):
     * buang sisa setelah objek lengkap terakhir, lalu tutup bracket terbuka.
     */
    private function repairTruncatedArray(string $json): string
    {
        $json = rtrim($json);

        // Buang sisa string/properti menggantung setelah objek lengkap terakhir
        $lastClose = strrpos($json, '}');
        if ($lastClose === false) {
            return '';
        }

        $json = substr($json, 0, $lastClose + 1);

        if (str_ends_with($json, ',')) {
            $json = substr($json, 0, -1);
        }

        $openBrackets = substr_count($json, '[') - substr_count($json, ']');
        if ($openBrackets > 0) {
            $json .= str_repeat(']', $openBrackets);
        }

        return $json;
    }

    /* =====================================================================
     |  NORMALISASI BARIS JADWAL
     * ===================================================================== */

    /**
     * Samakan bentuk baris hasil AI ke skema tetap aplikasi.
     * Baris yang tidak bisa diselamatkan dikembalikan null (dibuang).
     *
     * @return array{hari:string, jam_mulai:string, jam_selesai:string, matakuliah:string, ruangan:string, dosen:string, kelas:string}|null
     */
    protected function normalizeItem($item): ?array
    {
        if (!is_array($item)) {
            return null;
        }

        $pick = function (array $keys) use ($item): string {
            foreach ($keys as $key) {
                foreach ([$key, strtolower($key), ucfirst($key)] as $variant) {
                    if (isset($item[$variant]) && is_scalar($item[$variant]) && trim((string) $item[$variant]) !== '') {
                        return trim((string) $item[$variant]);
                    }
                }
            }

            return '';
        };

        $hari = self::normalizeHari($pick(['hari', 'day']));
        $jamMulai = self::normalizeJam($pick(['jam_mulai', 'jam', 'start', 'mulai']));
        $jamSelesai = self::normalizeJam($pick(['jam_selesai', 'selesai', 'end']));
        $matakuliah = $pick(['matakuliah', 'mata_kuliah', 'matkul', 'subject', 'course', 'nama_mk']);
        $ruangan = $pick(['ruangan', 'ruang', 'room']);
        $dosen = $pick(['dosen', 'pengajar', 'lecturer', 'teacher']);
        $kelas = $pick(['kelas', 'class', 'grup', 'kelompok']);

        if ($hari === null || $jamMulai === null || $matakuliah === '') {
            return null;
        }

        return [
            'hari' => $hari,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai ?? $jamMulai,
            'matakuliah' => $matakuliah,
            'ruangan' => $ruangan,
            'dosen' => $dosen,
            'kelas' => $kelas,
        ];
    }

    /**
     * Normalisasi nama hari ke HURUF BESAR (SENIN..MINGGU).
     * Menerima Inggris/Indonesia dengan kapitalisasi bebas.
     * Public static: dipakai juga oleh ScheduleController untuk baris hasil
     * edit manual (inline edit) dari frontend.
     */
    public static function normalizeHari(string $value): ?string
    {
        $map = [
            'senin' => 'SENIN', 'monday' => 'SENIN', 'mon' => 'SENIN',
            'selasa' => 'SELASA', 'tuesday' => 'SELASA', 'tue' => 'SELASA',
            'rabu' => 'RABU', 'wednesday' => 'RABU', 'wed' => 'RABU',
            'kamis' => 'KAMIS', 'thursday' => 'KAMIS', 'thu' => 'KAMIS',
            'jumat' => 'JUMAT', 'jum' => 'JUMAT', 'friday' => 'JUMAT', 'fri' => 'JUMAT',
            'sabtu' => 'SABTU', 'saturday' => 'SABTU', 'sat' => 'SABTU',
            'minggu' => 'MINGGU', 'ahad' => 'MINGGU', 'sunday' => 'MINGGU', 'sun' => 'MINGGU',
        ];

        $key = strtolower(trim($value));

        return $map[$key] ?? null;
    }

    /**
     * Normalisasi jam ke HH:MM (24 jam).
     * Menangani: 8.30, 08:00:00, 7, 0800, 8:05 PM.
     * Public static: dipakai juga oleh ScheduleController untuk baris hasil
     * edit manual (inline edit) dari frontend.
     */
    public static function normalizeJam(string $value): ?string
    {
        $value = strtoupper(trim($value));

        // AM/PM -> konversi ke 24 jam
        $meridiem = null;
        if (preg_match('/\s*(AM|PM)$/', $value, $m)) {
            $meridiem = $m[1];
            $value = trim(substr($value, 0, -strlen($m[1])));
        }

        // Pola rapat 4 digit: 0800
        if (preg_match('/^(\d{4})$/', $value, $d)) {
            $hour = (int) substr($d[1], 0, 2);
            $minute = (int) substr($d[1], 2, 2);

            if ($hour <= 23 && $minute <= 59) {
                return sprintf('%02d:%02d', $hour, $minute);
            }

            return null;
        }

        // Pola utama: HH, HH:MM, HH.MM, HHhMM
        if (preg_match('/^(\d{1,2})(?:[:.h](\d{1,2}))?$/', $value, $t)) {
            $hour = (int) $t[1];
            $minute = isset($t[2]) ? (int) $t[2] : 0;

            if ($meridiem === 'PM' && $hour < 12) {
                $hour += 12;
            }
            if ($meridiem === 'AM' && $hour === 12) {
                $hour = 0;
            }

            if ($hour > 23 || $minute > 59) {
                return null;
            }

            return sprintf('%02d:%02d', $hour, $minute);
        }

        return null;
    }

    /* =====================================================================
     |  API KEY: SATU-SATUNYA SUMBER = DATABASE (Pengaturan Sistem)
     |  Key disimpan TERENKRIPSI (Crypt) di tabel ai_api_configs (kolom
     |  api_key_encrypted, satu baris per provider). Isi key tidak pernah
     |  dikirim balik ke browser — hanya 4 karakter terakhir (masked).
     |  File .env tidak lagi dipakai untuk API key AI.
     * ===================================================================== */

    /**
     * API key aktif: dari tabel ai_api_configs (Pengaturan Sistem).
     * .env tidak dipakai lagi.
     */
    public function getApiKey(): string
    {
        return static::getDbApiKey();
    }

    /**
     * Ambil & dekripsi API key provider ini dari tabel ai_api_configs.
     * Kosong bila belum diisi / payload rusak.
     */
    public static function getDbApiKey(): string
    {
        try {
            $row = \App\Models\AiApiConfig::forProvider(static::providerKey());
            $encrypted = trim((string) ($row->api_key_encrypted ?? ''));

            if ($encrypted === '') {
                return '';
            }

            return trim(\Illuminate\Support\Facades\Crypt::decryptString($encrypted));
        } catch (\Throwable) {
            return '';
        }
    }

    /**
     * Simpan API key provider ini ke tabel ai_api_configs (dienkripsi otomatis).
     */
    public static function storeDbApiKey(string $plainKey): void
    {
        \App\Models\AiApiConfig::updateOrCreate(
            ['provider' => static::providerKey()],
            ['api_key_encrypted' => \Illuminate\Support\Facades\Crypt::encryptString(trim($plainKey))]
        );
    }

    /**
     * Hapus API key provider ini dari tabel ai_api_configs (kolom dikosongkan;
     * baris dipertahankan karena memuat model & data pemakaian).
     */
    public static function deleteDbApiKey(): void
    {
        \App\Models\AiApiConfig::where('provider', static::providerKey())
            ->update(['api_key_encrypted' => null]);
    }

    /**
     * Info status API key untuk UI (tanpa membocorkan isi key).
     *
     * @return array{has_db:bool, masked:?string, has_env:bool, source:string, configured:bool}
     */
    public static function apiKeyInfo(): array
    {
        $dbKey = static::getDbApiKey();
        $envKey = trim((string) config('services.' . static::providerKey() . '.key'));

        return [
            'has_db' => $dbKey !== '',
            'masked' => $dbKey !== '' ? '••••' . substr($dbKey, -4) : null,
            'has_env' => $envKey !== '',
            'source' => $dbKey !== '' ? 'database' : ($envKey !== '' ? 'env' : 'none'),
            'configured' => ($dbKey !== '' || $envKey !== ''),
        ];
    }
}