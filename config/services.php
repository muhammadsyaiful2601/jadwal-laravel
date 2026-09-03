<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // =====================================================================
    // Import Jadwal AI — konfigurasi AKTIF dari SISTEM, bukan lagi dari .env
    // - API key  : Pengaturan Sistem > card "API Key AI" (tabel settings,
    //              kunci ai_api_key_* — TERENKRIPSI via Crypt::encryptString)
    // - Model    : Pengaturan Sistem > card "Model AI" (tabel settings,
    //              kunci ai_model_*) — provider dideteksi otomatis dari nama model
    // Nilai di bawah hanyalah DEFAULT KODE (fallback terakhir); tidak dibaca
    // dari file .env.
    // =====================================================================
    'gemini' => [
        // Default model bila Pengaturan Sistem belum diisi (Gemini 3.6 Flash — stabil).
        'model' => 'gemini-3.6-flash',

        // [FALLBACK OTOMATIS] Dicoba berurutan jika model utama "not found" (404).
        // gemini-flash-latest = alias yang selalu menunjuk Flash terbaru; gemini-3.7-flash = penerus 3.6.
        'fallback_models' => ['gemini-flash-latest', 'gemini-3.7-flash'],

        // Budget token output. Thinking model 3.x ikut mengonsumsi token ini;
        // bila terlalu kecil, JSON bisa terpotong (finishReason MAX_TOKENS).
        'max_output_tokens' => 65535,
    ],

    // Import Jadwal AI (OpenAI)
    'openai' => [
        'model' => 'gpt-4o',
        'max_tokens' => 16000,
    ],

    // Import Jadwal AI (Anthropic Claude)
    'anthropic' => [
        'model' => 'claude-3-5-sonnet-latest',
        'max_tokens' => 16000,
    ],

];
