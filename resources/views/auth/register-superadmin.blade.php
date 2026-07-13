<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar Super Admin - Jadwal Kuliah</title>
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
            background: var(--nb-yellow);
            color: var(--nb-black);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
        }

        .register-wrapper {
            max-width: 520px;
            margin: 0 auto;
            width: 100%;
        }

        .register-card {
            background: var(--nb-white);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            overflow: hidden;
            box-shadow: var(--nb-shadow-lg);
        }

        .register-header {
            background: var(--nb-purple);
            color: var(--nb-white);
            padding: 32px;
            text-align: center;
            border-bottom: var(--nb-border-thick);
            position: relative;
            overflow: hidden;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: 0;
            transform: rotate(15deg);
        }

        .register-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 120px;
            height: 120px;
            background: var(--nb-teal);
            border: var(--nb-border);
            border-radius: 0;
            transform: rotate(-20deg);
        }

        .register-header h2 {
            font-family: var(--font-display);
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.75rem;
            position: relative;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .register-header p {
            font-size: 0.95rem;
            font-weight: 600;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        .register-body {
            padding: 36px;
        }

        .alert {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-warning-custom {
            background: var(--nb-orange);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .alert-danger {
            background: var(--nb-red);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
        }

        .alert-success {
            background: var(--nb-green);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

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

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: var(--nb-yellow);
            border: var(--nb-border);
            color: var(--nb-black);
            border-radius: var(--nb-radius-sm) 0 0 var(--nb-radius-sm);
            padding: 14px 18px;
            font-weight: 700;
            border-right: none;
        }

        .form-control {
            border: var(--nb-border);
            border-radius: 0 var(--nb-radius-sm) var(--nb-radius-sm) 0;
            padding: 14px 18px;
            border-left: none;
            font-size: 0.92rem;
            font-family: var(--font-body);
            color: var(--nb-black);
            background: var(--nb-white);
            transition: all 0.2s ease;
            outline: none;
            box-shadow: var(--nb-shadow-sm);
            font-weight: 600;
        }

        .form-control:focus {
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
            border-color: var(--nb-black);
        }

        .form-control::placeholder {
            color: var(--nb-dark);
            opacity: 0.5;
            font-weight: 500;
        }

        .btn-register {
            background: var(--nb-teal);
            color: var(--nb-black);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius-sm);
            padding: 16px;
            font-family: var(--font-display);
            font-weight: 700;
            transition: all 0.2s ease;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            box-shadow: var(--nb-shadow);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-register:hover {
            background: var(--nb-green);
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow-hover);
            color: var(--nb-black);
        }

        .btn-register:active {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .text-center {
            text-align: center;
        }

        .back-link {
            margin-top: 16px;
        }

        .back-link a {
            color: var(--nb-purple);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link a:hover {
            color: var(--nb-black);
            transform: translateY(-2px);
        }

        .form-text {
            display: block;
            margin-top: 6px;
            font-size: 0.8rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .register-header {
                padding: 24px;
            }

            .register-body {
                padding: 24px;
            }

            .register-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="register-card">
            <!-- Register Header -->
            <div class="register-header">
                <h2><i class="fas fa-user-shield me-2"></i> Pendaftaran Super Admin</h2>
                <p class="mb-0">Hanya sekali akses!</p>
            </div>

            <!-- Register Body -->
            <div class="register-body">
                <!-- Error Messages -->
                @if (!empty($error))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Success Message -->
                @if (!empty($success))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ $success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/login') }}" class="btn btn-register">
                            <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
                        </a>
                    </div>
                @else
                    <!-- Warning Alert -->
                    <div class="alert alert-warning-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Halaman ini hanya bisa diakses sekali untuk mendaftarkan Super Admin
                        pertama.
                    </div>

                    <!-- Register Form -->
                    <form method="POST" action="{{ url('/register-superadmin') }}" id="registerForm">
                        @csrf
                        <div class="form-group">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-1"></i> Username
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="Masukkan email (opsional)">
                            </div>
                            <small class="form-text">Email hanya digunakan untuk recovery account</small>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required
                                    placeholder="Minimal 6 karakter">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i> Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required placeholder="Ulangi password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register">
                            <i class="fas fa-user-plus me-2"></i> Daftarkan Super Admin
                        </button>

                        <div class="text-center back-link">
                            <a href="{{ url('/login') }}">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prevent form resubmission on refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Password match validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password tidak cocok!');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>

</html>
