<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --navy-primary: #0f172a;
            --corporate-blue: #1d4ed8;
            --corporate-blue-hover: #1e3a8a;
            --zinc-800: #27272a;
            --zinc-600: #52525b;
            --zinc-400: #a1a1aa;
            --zinc-200: #e4e4e7;
            --zinc-100: #f4f4f5;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            height: 100vh;
            overflow: hidden;
            background: var(--white);
        }

        .split-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left-panel {
            width: 55%;
            background: var(--navy-primary);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 80px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .geo-dots {
            position: absolute;
            top: 60px;
            left: 60px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .geo-dots span {
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
        }

        .geo-dots-2 {
            position: absolute;
            bottom: 80px;
            right: 80px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .geo-dots-2 span {
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 460px;
        }

        .left-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 18px;
            margin-bottom: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: inline-block;
        }

        .left-content h1 {
            color: var(--white);
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .left-content .subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.05rem;
            font-weight: 400;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .feature-list {
            text-align: left;
            display: inline-block;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.92rem;
            font-weight: 400;
            margin-bottom: 16px;
        }

        .feature-item .icon-box {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .feature-item .icon-box i {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .left-footer {
            position: absolute;
            bottom: 30px;
            color: rgba(255, 255, 255, 0.25);
            font-size: 0.78rem;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--white);
        }

        .form-card {
            width: 100%;
            max-width: 420px;
            padding: 20px 0;
        }

        .form-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .form-logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-logo {
            width: 56px;
            height: 56px;
            object-fit: contain;
        }

        .form-header h2 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .form-header p {
            font-size: 0.95rem;
            font-weight: 400;
            color: var(--zinc-600);
            margin-bottom: 0;
        }

        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 0.88rem;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border-left: 4px solid #22c55e;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--zinc-800);
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--zinc-400);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-wrapper .form-control {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 12px;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            color: var(--zinc-800);
            background: var(--white);
            transition: all 0.2s ease;
            outline: none;
            box-shadow: none;
        }

        .input-wrapper .form-control::placeholder {
            color: var(--zinc-400);
            font-weight: 400;
        }

        .input-wrapper .form-control:focus {
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .input-wrapper .form-control:focus~.input-icon {
            color: var(--corporate-blue);
        }

        .btn-primary-custom {
            width: 100%;
            padding: 14px 24px;
            background: var(--corporate-blue);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.3px;
            margin-bottom: 24px;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            background: var(--corporate-blue-hover);
            transform: translateY(-1px);
            color: white;
        }

        .back-link {
            text-align: center;
            padding-top: 4px;
        }

        .back-link small {
            font-size: 0.85rem;
            color: var(--zinc-600);
        }

        .back-link a {
            color: var(--corporate-blue);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link a:hover {
            color: var(--corporate-blue-hover);
        }

        @media (max-width: 992px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
                padding: 30px 24px;
            }

            .form-card {
                max-width: 400px;
            }
        }

        @media (max-width: 576px) {
            .right-panel {
                padding: 20px 16px;
            }

            .form-header h2 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="split-container">
        <div class="left-panel">
            <div class="geo-dots">
                <span></span><span></span><span></span>
                <span></span><span></span><span></span>
                <span></span><span></span><span></span>
            </div>
            <div class="geo-dots-2">
                <span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span>
            </div>

            <div class="left-content">
                <img src="{{ asset('jadwal-kampus/assets/images/logo_kampus.png') }}"
                    alt="Logo Politeknik Negeri Padang" class="left-logo"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100/1e293b/ffffff?text=PNP'">

                <h1>Lupa Password?</h1>
                <p class="subtitle">Jangan khawatir! Masukkan email Anda<br>untuk mereset password</p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="icon-box">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span>Keamanan Akun Terjamin</span>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span>Reset via Email Terdaftar</span>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>Proses Cepat & Mudah</span>
                    </div>
                </div>
            </div>

            <div class="left-footer">
                &copy; {{ date('Y') }} Politeknik Negeri Padang &mdash; PSDKU Tanah Datar
            </div>
        </div>

        <div class="right-panel">
            <div class="form-card">
                <div class="form-header">
                    <div class="form-logo-row">
                        <img src="{{ asset('jadwal-kampus/assets/images/logo_kampus.png') }}" alt="Logo"
                            class="form-logo"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/0f172a/ffffff?text=PNP'">
                    </div>
                    <h2>Reset Password</h2>
                    <p>Masukkan email akun Anda</p>
                </div>

                @if (session('error'))
                    <div class="alert-modern alert-error">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-modern alert-success"
                        style="background: #f0fdf4; border-left: 4px solid #22c55e; padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div
                                style="width: 50px; height: 50px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-envelope-open-text" style="font-size: 1.4rem; color: #16a34a;"></i>
                            </div>
                            <div>
                                <strong style="font-size: 1rem; color: #15803d; display: block; margin-bottom: 4px;">
                                    ✅ Email Terkirim!
                                </strong>
                                <span style="font-size: 0.9rem; color: #166534;">
                                    {{ session('success') }}
                                </span>
                                <div
                                    style="margin-top: 10px; padding: 10px 14px; background: #dcfce7; border-radius: 8px; display: inline-block;">
                                    <small style="color: #15803d;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Cek folder <strong>Spam</strong> atau <strong>Promosi</strong> jika tidak
                                        menemukan email di Inbox
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ url('/forgot-password') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required autofocus>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Link Reset
                    </button>

                    <div class="back-link">
                        <small>
                            <a href="{{ url('/login') }}">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                            </a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
