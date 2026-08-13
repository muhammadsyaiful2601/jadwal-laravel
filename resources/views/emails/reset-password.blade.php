<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Space Grotesk', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F7F4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            border: 3px solid #000;
            box-shadow: 8px 8px 0px #000;
        }

        .header {
            background: #FF6B6B;
            padding: 40px 30px;
            text-align: center;
            border-bottom: 3px solid #000;
        }

        .header h1 {
            color: #FFFFFF;
            font-size: 24px;
            margin: 0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            margin-top: 8px;
            font-weight: 600;
        }

        .body {
            padding: 40px 30px;
        }

        .body h2 {
            color: #000000;
            font-size: 20px;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .body p {
            color: #1A1A2E;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: #FFE66D;
            color: #000000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 15px;
            margin: 20px 0;
            border: 3px solid #000;
            box-shadow: 4px 4px 0px #000;
            transition: all 0.15s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px #000;
            background: #F38181;
        }

        .footer {
            padding: 20px 30px;
            text-align: center;
            border-top: 3px solid #000;
            background: #F8F7F4;
        }

        .footer p {
            color: #1A1A2E;
            font-size: 12px;
            margin: 0;
            font-weight: 600;
        }

        .info-box {
            background: #FFE66D;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            font-size: 13px;
            color: #000000;
            border: 2px solid #000;
            box-shadow: 4px 4px 0px #000;
            font-weight: 600;
        }

        .link-text {
            color: #FF6B6B;
            font-weight: 700;
            word-break: break-all;
        }

        .gray-text {
            color: #1A1A2E;
            font-weight: 600;
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

            <p style="font-size: 14px; color: #1A1A2E; font-weight: 600;">
                Atau salin link berikut ke browser Anda:<br>
                <span class="link-text">{{ $resetUrl }}</span>
            </p>

            <div style="text-align: center; margin: 28px 0; padding: 20px; border: 3px solid #000; border-radius: 12px; background: #F8F7F4;">
                <p style="font-size: 13px; color: #1A1A2E; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                    Gunakan Kode OTP (Alternatif)
                </p>
                <div style="display: inline-block; padding: 16px 28px; background: #FF6B6B; color: #FFFFFF; border: 3px solid #000; border-radius: 10px; font-size: 34px; font-weight: 900; letter-spacing: 10px;">
                    {{ $otp }}
                </div>
                <p style="font-size: 13px; color: #1A1A2E; font-weight: 600; margin-top: 14px;">
                    Buka halaman <a href="{{ url('/reset-password/otp') }}" style="color:#FF6B6B; font-weight:700;">Reset Password dengan OTP</a>
                    lalu masukkan kode di atas.<br>
                    Kode OTP ini berlaku selama <strong>15 menit</strong>.
                </p>
            </div>

            <div class="info-box">
                <strong>⚠️ Perhatian:</strong> Link reset password ini berlaku selama 1 jam dan kode OTP ini berlaku selama 15 menit. Jika Anda tidak meminta
                reset password, abaikan email ini.
            </div>

            <p style="font-size: 14px; color: #1A1A2E; margin-top: 24px; font-weight: 600;">
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
