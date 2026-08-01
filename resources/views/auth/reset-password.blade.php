<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reset Password - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        /* =============================================
               NEOBRUTALISM STYLES - Auth Pages
               ============================================= */
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
            --nb-shadow-hover: 10px 10px 0px #000;
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

        /* Split Screen Container */
        .split-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Panel - Brand / Welcome */
        .left-panel {
            width: 55%;
            background: var(--nb-green);
            border-right: var(--nb-border-thick);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 80px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--nb-shadow-lg);
        }

        /* Decorative geometric elements */
        .geo-dots {
            position: absolute;
            top: 60px;
            left: 60px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .geo-dots span {
            width: 8px;
            height: 8px;
            background: var(--nb-black);
            border-radius: 0;
            border: 2px solid var(--nb-black);
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
            width: 10px;
            height: 10px;
            background: var(--nb-yellow);
            border: 2px solid var(--nb-black);
            border-radius: 0;
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
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 18px;
            margin-bottom: 32px;
            box-shadow: var(--nb-shadow);
            display: inline-block;
        }

        .left-content h1 {
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .left-content .subtitle {
            color: var(--nb-black);
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 40px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .left-footer {
            position: absolute;
            bottom: 30px;
            color: var(--nb-black);
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        /* Right Panel - Form */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--nb-offwhite);
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
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 4px;
            background: var(--nb-white);
            box-shadow: var(--nb-shadow-sm);
        }

        .form-header h2 {
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .form-header p {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--nb-dark);
            margin-bottom: 0;
        }

        /* Alerts */
        .alert-modern {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-error {
            background: var(--nb-red);
            color: var(--nb-white);
            border-left: 4px solid var(--nb-black);
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--nb-black);
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.2s ease;
            background: var(--nb-yellow);
            padding: 8px;
            border: 2px solid var(--nb-black);
            border-radius: var(--nb-radius-sm);
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .input-wrapper .form-control {
            width: 100%;
            padding: 14px 16px 14px 60px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-size: 0.92rem;
            font-family: var(--font-body);
            color: var(--nb-black);
            background: var(--nb-white);
            transition: all 0.2s ease;
            outline: none;
            box-shadow: var(--nb-shadow-sm);
            font-weight: 600;
        }

        .input-wrapper .form-control::placeholder {
            color: var(--nb-dark);
            opacity: 0.5;
            font-weight: 500;
        }

        .input-wrapper .form-control:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .input-wrapper .form-control:focus~.input-icon {
            background: var(--nb-teal);
        }

        /* Toggle password visibility */
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--nb-white);
            border: 2px solid var(--nb-black);
            color: var(--nb-black);
            cursor: pointer;
            padding: 6px 10px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
        }

        .toggle-password:hover {
            background: var(--nb-yellow);
            transform: translateY(-50%) translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .toggle-password:active {
            transform: translateY(-50%) translate(2px, 2px);
            box-shadow: none;
        }

        /* Button */
        .btn-primary-custom {
            width: 100%;
            padding: 16px 24px;
            background: var(--nb-teal);
            color: var(--nb-black);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
            box-shadow: var(--nb-shadow);
            text-transform: uppercase;
        }

        .btn-primary-custom:hover {
            background: var(--nb-blue);
            color: var(--nb-black);
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow-hover);
        }

        .btn-primary-custom:active {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .btn-primary-custom i {
            font-size: 1rem;
        }

        /* Back Link */
        .back-link {
            text-align: center;
            padding-top: 4px;
        }

        .back-link small {
            font-size: 0.85rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .back-link a {
            color: var(--nb-purple);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .back-link a:hover {
            color: var(--nb-black);
            transform: translateY(-1px);
        }

        /* Responsive */
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
                font-size: 1.4rem;
            }

            .form-logo {
                width: 46px;
                height: 46px;
            }

            .form-logo-row {
                gap: 12px;
            }
        }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('jadwal-kampus/assets/images/si.png') }}">
</head>

<body>
    <div class="split-container">
        <!-- LEFT PANEL: Brand / Welcome -->
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
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100/95E1D3/ffffff?text=PNP'">

                <h1>Buat Password Baru</h1>
                <p class="subtitle">Masukkan password baru Anda<br>untuk melanjutkan</p>
            </div>

            <div class="left-footer">
                &copy; {{ date('Y') }} Politeknik Negeri Padang &mdash; PSDKU Tanah Datar
            </div>
        </div>

        <!-- RIGHT PANEL: Reset Password Form -->
        <div class="right-panel">
            <div class="form-card">
                <div class="form-header">
                    <div class="form-logo-row">
                        <img src="{{ asset('jadwal-kampus/assets/images/logo_kampus.png') }}" alt="Logo"
                            class="form-logo"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/95E1D3/ffffff?text=PNP'">
                    </div>
                    <h2>Reset Password</h2>
                    <p>Buat password baru Anda</p>
                </div>

                @if (session('error'))
                    <div class="alert-modern alert-error">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/reset-password') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Minimal 6 karakter" required minlength="6">
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="toggle-password"
                                onclick="togglePassword('password', 'toggleIcon1')" tabindex="-1">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Ulangi password baru" required minlength="6">
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="toggle-password"
                                onclick="togglePassword('password_confirmation', 'toggleIcon2')" tabindex="-1">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-save"></i>
                        Reset Password
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
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
