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

    // Import Jadwal AI (Google Gemini)
    // [PERMINTAAN #1 & #4] Model utama: Gemini 3.6 Flash (stabil) — penerus
    // gemini-1.5-flash yang sudah di-retire Google (penyebab error "not found").
    // Nama model ditulis TANPA prefix "models/".
    'gemini' => [
        'key' => env('GEMINI_API_KEY'),

        'model' => env('GEMINI_MODEL', 'gemini-3.6-flash'),

        // [PERMINTAAN #3 — FALLBACK MANUAL, un-comment salah satu baris jika model utama masih gagal]
        // 'model' => env('GEMINI_MODEL', 'gemini-1.5-pro'),           // model lama 1.5 Pro (sudah di-retire Google, kemungkinan 404)
        // 'model' => env('GEMINI_MODEL', 'gemini-1.5-flash-latest'),  // alias terakhir generasi 1.5 (juga sudah di-retire)
        // 'model' => env('GEMINI_MODEL', 'gemini-3.7-flash'),         // generasi terbaru & paling mampu
        // 'model' => env('GEMINI_MODEL', 'gemini-3.5-flash'),         // generasi 3.5 (stabil)

        // [FALLBACK OTOMATIS] Dicoba berurutan jika model utama "not found" (404).
        // gemini-flash-latest = alias yang selalu menunjuk Flash terbaru; gemini-3.7-flash = penerus 3.6.
        'fallback_models' => array_values(array_filter([
            env('GEMINI_FALLBACK_MODEL_1', 'gemini-flash-latest'),
            env('GEMINI_FALLBACK_MODEL_2', 'gemini-3.7-flash'),
        ])),
    ],

];
