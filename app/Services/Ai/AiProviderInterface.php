<?php

namespace App\Services\Ai;

interface AiProviderInterface
{
    /**
     * Ekstrak daftar jadwal dari file dokumen menggunakan AI provider.
     *
     * @param  string  $realPath   Path absolut file yang diupload
     * @param  string  $extension  Ekstensi file (pdf, xlsx, csv, png, jpg, jpeg)
     * @return array<int, array{hari:string, jam_mulai:string, jam_selesai:string, matakuliah:string, ruangan:string, dosen:string, kelas:string}>
     */
    public function extractSchedules(string $realPath, string $extension): array;

    /* ===== Identitas provider & katalog model (dipakai Pengaturan Sistem) ===== */

    /** Kunci unik provider (gemini | openai | anthropic) — juga nama config services.{key}.key */
    public static function providerKey(): string;

    /** Label yang tampil di UI */
    public static function providerLabel(): string;

    /** Deteksi otomatis: apakah nama model ini milik provider ini? */
    public static function handlesModel(string $model): bool;

    /**
     * Katalog model yang tersedia untuk UI.
     *
     * @return array<int, array{id:string, label:string, free:bool, note:string}>
     *         free = true berarti model punya tier GRATIS (ditandai "GRATIS" di UI)
     */
    public static function availableModels(): array;
}