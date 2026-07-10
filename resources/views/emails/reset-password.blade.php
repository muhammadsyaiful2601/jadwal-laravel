<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
            font-weight: 700;
        }

        .header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-top: 8px;
        }

        .body {
            padding: 40px 30px;
        }

        .body h2 {
            color: #18181b;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .body p {
            color: #52525b;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            margin: 20px 0;
        }

        .btn:hover {
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        }

        .footer {
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e4e4e7;
        }

        .footer p {
            color: #a1a1aa;
            font-size: 12px;
            margin: 0;
        }

        .info-box {
            background: #f4f4f5;
            border-radius: 10px;
            padding: 16px 20px;
            margin: 20px 0;
            font-size: 13px;
            color: #71717a;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reset Password</h1>
            <p>Sistem Informasi Jadwal Kuliah</p>
        </div>
        <div class="body">
            <h2>Halo, {{ $username }}!</h2>
            <p>
                Kami menerima permintaan reset password untuk akun Anda.
                Silakan klik tombol di bawah ini untuk membuat password baru:
            </p>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="btn">
                    Reset Password
                </a>
            </div>

            <p style="font-size: 14px; color: #71717a;">
                Atau salin link berikut ke browser Anda:<br>
                <span style="color: #1d4ed8; word-break: break-all;">{{ $resetUrl }}</span>
            </p>

            <div class="info-box">
                <strong>⚠️ Perhatian:</strong> Link reset password ini berlaku selama 1 jam. Jika Anda tidak meminta
                reset password, abaikan email ini.
            </div>

            <p style="font-size: 14px; color: #71717a; margin-top: 24px;">
                Salam,<br>
                <strong>Tim Sistem Informasi Jadwal Kuliah</strong>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Politeknik Negeri Padang &mdash; PSDKU Tanah Datar</p>
            <p style="margin-top: 4px;">Email ini dikirim secara otomatis, jangan membalas email ini.</p>
        </div>
    </div>
</body>

</html>
