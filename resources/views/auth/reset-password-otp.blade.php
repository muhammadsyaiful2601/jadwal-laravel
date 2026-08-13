<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password dengan OTP - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --nb-black: #000000;
            --nb-white: #FFFFFF;
            --nb-offwhite: #F8F7F4;
            --nb-yellow: #FFE66D;
            --nb-red: #FF6B6B;
            --nb-teal: #4ECDC4;
            --nb-pink: #F38181;
            --nb-green: #95E1D3;
            --nb-purple: #A66CFF;
            --nb-orange: #FFB347;
            --nb-blue: #6BB5FF;
            --nb-gray: #E8E8E8;
            --nb-dark: #1A1A2E;
            --nb-border: 3px solid #000;
            --nb-border-thick: 4px solid #000;
            --nb-shadow: 6px 6px 0px #000;
            --nb-shadow-sm: 4px 4px 0px #000;
            --nb-shadow-lg: 8px 8px 0px #000;
            --nb-radius: 12px;
            --nb-radius-sm: 8px;
            --font-display: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--nb-offwhite);
            color: var(--nb-black);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .auth-wrapper {
            max-width: 480px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .auth-card {
            background: var(--nb-white);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow-lg);
            overflow: hidden;
        }

        .auth-header {
            background: var(--nb-red);
            padding: 28px 30px;
            text-align: center;
            border-bottom: var(--nb-border-thick);
            color: var(--nb-white);
        }

        .auth-header h1 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .auth-header p {
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0.9;
            margin: 6px 0 0;
        }

        .auth-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--nb-black);
            margin-bottom: 6px;
        }

        .form-control {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 12px 14px;
            font-size: 0.95rem;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: var(--nb-black);
            box-shadow: 4px 4px 0 var(--nb-yellow);
        }

        .btn-primary-custom {
            width: 100%;
            padding: 14px;
            background: var(--nb-black);
            color: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-weight: 700;
            font-size: 1rem;
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
        }

        .btn-primary-custom:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
            background: var(--nb-teal);
            color: var(--nb-black);
        }

        .alert-modern {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 14px 16px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 18px;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-success {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .alert-error {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .back-link {
            text-align: center;
            margin-top: 18px;
        }

        .back-link a {
            color: var(--nb-dark);
            font-weight: 600;
            text-decoration: none;
        }

        .back-link a:hover {
            color: var(--nb-red);
        }

        .hint-text {
            font-size: 0.8rem;
            color: var(--nb-dark);
            font-weight: 600;
            margin-top: 10px;
            text-align: center;
        }

        @media (max-width: 576px) {
            .auth-wrapper {
                padding: 30px 14px;
            }
            .auth-body {
                padding: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-key me-2"></i>Reset Password</h1>
                <p>Gunakan kode OTP dari email Anda</p>
            </div>
            <div class="auth-body">
                @if (session('success'))
                    <div class="alert-modern alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-modern alert-error">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-modern alert-error">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <p style="font-size:0.9rem;color:var(--nb-dark);font-weight:500;margin-bottom:20px;">
                    Masukkan email, kode OTP yang dikirim ke email Anda, lalu buat password baru.
                </p>

                <form method="POST" action="{{ url('/reset-password/otp') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required>
                    </div>

                    <div class="mb-3">
                        <label for="otp" class="form-label">Kode OTP</label>
                        <input type="text" class="form-control" id="otp" name="otp"
                            value="{{ old('otp') }}" placeholder="6 digit kode dari email" maxlength="6"
                            inputmode="numeric" autocomplete="one-time-code" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Minimal 6 karakter" required minlength="6">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Ulangi password baru" required minlength="6">
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-save me-1"></i> Reset Password dengan OTP
                    </button>
                </form>

                <p class="hint-text">
                    <i class="fas fa-info-circle me-1"></i> Kode OTP berlaku selama 15 menit. Tidak menerima kode?
                    <a href="{{ url('/forgot-password') }}" style="color:var(--nb-red);font-weight:700;">Kirim ulang</a>
                </p>

                <div class="back-link">
                    <small>
                        <a href="{{ url('/login') }}">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                        </a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
