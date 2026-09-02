<?php

namespace App\Services;

use RuntimeException;

/**
 * Dilempar saat model Gemini tidak ditemukan / tidak didukung (HTTP 404),
 * misalnya model sudah di-retire Google (contoh kasus: gemini-1.5-flash).
 * GeminiScheduleImportService akan menangkap exception ini untuk mencoba
 * model fallback berikutnya secara otomatis.
 */
class GeminiModelNotFoundException extends RuntimeException
{
}
