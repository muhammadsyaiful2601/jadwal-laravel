<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Admin - Jadwal Kuliah</title>
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
            background: var(--nb-purple);
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

        .geo-line {
            position: absolute;
            top: 50%;
            left: -60px;
            width: 200px;
            height: 3px;
            background: var(--nb-black);
            transform: rotate(30deg);
        }

        .geo-line-2 {
            position: absolute;
            bottom: 40%;
            right: -40px;
            width: 150px;
            height: 3px;
            background: var(--nb-white);
            transform: rotate(-25deg);
        }

        /* Left panel content */
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

        .feature-list {
            text-align: left;
            display: inline-block;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--nb-black);
            font-size: 0.92rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .feature-item .icon-box {
            width: 40px;
            height: 40px;
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: var(--nb-shadow-sm);
        }

        .feature-item .icon-box i {
            font-size: 0.9rem;
            color: var(--nb-black);
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

        /* Right Panel - Login Form */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--nb-offwhite);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 20px 0;
        }

        /* Logo & Header */
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

        .alert-session {
            background: var(--nb-yellow);
            color: var(--nb-black);
            border-left: 4px solid var(--nb-black);
        }

        .alert-error {
            background: var(--nb-red);
            color: var(--nb-white);
            border-left: 4px solid var(--nb-black);
        }

        .alert-lockout {
            background: var(--nb-red);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 24px;
            margin-bottom: 24px;
            text-align: center;
            box-shadow: var(--nb-shadow);
        }

        .alert-lockout i {
            font-size: 2rem;
            color: var(--nb-white);
            display: block;
            margin-bottom: 12px;
        }

        .alert-lockout h5 {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-white);
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .alert-lockout p {
            color: var(--nb-white);
            font-size: 0.88rem;
            font-weight: 500;
        }

        .lockout-level {
            display: inline-block;
            background: var(--nb-black);
            color: var(--nb-white);
            padding: 3px 14px;
            border-radius: var(--nb-radius-sm);
            font-size: 0.8rem;
            font-weight: 700;
            margin-top: 8px;
            border: 2px solid var(--nb-black);
        }

        .countdown-display {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--nb-yellow);
            margin: 12px 0;
            text-shadow: 3px 3px 0 var(--nb-black);
        }

        /* Attempts Progress */
        .attempts-box {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 18px;
            margin-bottom: 24px;
            box-shadow: var(--nb-shadow-sm);
        }

        .attempts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .attempts-header small {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--nb-black);
        }

        .progress-track {
            height: 10px;
            background: var(--nb-gray);
            border: 2px solid var(--nb-black);
            border-radius: var(--nb-radius-sm);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 6px;
            transition: width 0.4s ease;
            font-weight: 700;
        }

        .progress-fill.safe {
            background: var(--nb-green);
        }

        .progress-fill.caution {
            background: var(--nb-orange);
        }

        .progress-fill.warning {
            background: var(--nb-yellow);
        }

        .progress-fill.danger {
            background: var(--nb-red);
        }

        .progress-fill.locked {
            background: var(--nb-black);
        }

        .attempts-footer {
            margin-top: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--nb-dark);
        }

        .refresh-notice {
            background: var(--nb-blue);
            border: var(--nb-border);
            color: var(--nb-black);
            border-radius: var(--nb-radius-sm);
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        /* Form Inputs - Neobrutalism Style */
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
            color: var(--zinc-400);
            font-weight: 400;
        }

        .input-wrapper .form-control:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .input-wrapper .form-control:focus~.input-icon {
            background: var(--nb-teal);
        }

        .input-wrapper .form-control.input-locked {
            background: var(--nb-yellow);
            border-color: var(--nb-black);
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

        /* Login Button - Neobrutalism Style */
        .btn-login {
            width: 100%;
            padding: 16px 24px;
            background: var(--nb-yellow);
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

        .btn-login:hover:not(:disabled) {
            background: var(--nb-teal);
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow-hover);
        }

        .btn-login:active:not(:disabled) {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .btn-login:disabled {
            background: var(--nb-gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-login i {
            font-size: 1rem;
        }

        /* Register Link */
        .register-section {
            text-align: center;
            padding-top: 4px;
        }

        .register-section small {
            font-size: 0.85rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .register-link {
            color: var(--nb-purple);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }

        .register-link:hover {
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

            .login-card {
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
        <!-- LEFT PANEL: Brand & Welcome -->
        <div class="left-panel">
            <!-- Decorative elements -->
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
            <div class="geo-line"></div>
            <div class="geo-line-2"></div>

            <div class="left-content">
                <img src="{{ asset('jadwal-kampus/assets/images/si.png') }}" alt="Logo Sistem Informasi"
                    class="left-logo"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100/A66CFF/ffffff?text=SI'">

                <h1>Selamat Datang</h1>
                <p class="subtitle">Sistem Informasi Jadwal Kuliah<br>Politeknik Negeri Padang<br> PSDKU Tanah Datar</p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="icon-box">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <span>Manajemen Jadwal Perkuliahan</span>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <span>Manajemen Ruang Kelas</span>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <span>Kelola Data Pengguna</span>
                    </div>
                </div>
            </div>

            <div class="left-footer">
                &copy; {{ date('Y') }} Politeknik Negeri Padang &mdash; PSDKU Tanah Datar
            </div>
        </div>

        <!-- RIGHT PANEL: Login Form -->
        <div class="right-panel">
            <div class="login-card">
                <!-- Form Header: Logo + Institution Name -->
                <div class="form-header">
                    <div class="form-logo-row">
                        <img src="{{ asset('jadwal-kampus/assets/images/logo_kampus.png') }}" alt="Logo"
                            class="form-logo"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/A66CFF/ffffff?text=PNP'">
                    </div>
                    <h2>{{ $institusiNama ?? 'Politeknik Negeri Padang' }}</h2>
                    <p>{{ $institusiLokasi ?? 'PSDKU Tanah Datar' }}</p>
                </div>

                <!-- Session Expired Alert -->
                @if ($sessionExpired)
                    <div class="alert-modern alert-session">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Sesi Berakhir!</strong><br>
                        <small>Sesi Anda telah berakhir karena tidak ada aktivitas selama
                            {{ $sessionTimeoutMinutes ?? 30 }} menit. Silakan login kembali untuk melanjutkan.</small>
                    </div>
                @endif

                <!-- Error Messages -->
                @if (!empty($error))
                    <div class="alert-modern alert-error">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {!! $error !!}
                    </div>
                @endif

                <!-- Lockout Specific Message -->
                @if (isset($lockout_username) && $lockout_username && isset($lockout_time) && $lockout_time > 0)
                    <div class="alert-lockout" id="lockoutPopup">
                        <i class="fas fa-lock"></i>
                        <h5>Akun Terkunci</h5>
                        <p class="mb-2">Akun <strong>{{ $lockout_username }}</strong> sedang terkunci.</p>
                        <div class="countdown-display" id="countdownDisplay">
                            {{ formatLockoutTime($lockout_time) }}
                        </div>
                        @if ($multiplier > 1)
                            <span class="lockout-level">Level {{ $multiplier }}</span>
                        @endif
                    </div>
                @endif

                <!-- Progress Bar for Failed Attempts -->
                @if (!empty($showProgress) && isset($attempts_info))
                    <div class="attempts-box">
                        <div class="attempts-header">
                            <small>Status Percobaan Login</small>
                            <small>{{ $attempts_info['attempts_left'] }} / {{ $attempts_info['max_attempts'] }}</small>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill {{ getProgressBarClass($attempts_info['percentage']) }}"
                                style="width: {{ $attempts_info['percentage'] }}%"></div>
                        </div>
                        <div class="attempts-footer">
                            @if ($attempts_info['percentage'] >= 80)
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <strong>Hampir terkunci!</strong>
                            @elseif($attempts_info['percentage'] >= 60)
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <span>Peringatan!</span>
                            @else
                                <i class="fas fa-info-circle me-1"></i>
                                <span>Percobaan tersisa</span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ url('/login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <input type="text"
                                class="form-control {{ isset($lockout_username) && $lockout_username == old('username') ? 'input-locked' : '' }}"
                                id="username" name="username" value="{{ old('username') }}"
                                placeholder="Masukkan username" required autocomplete="username"
                                oninput="clearLockoutStatus()">
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password"
                                class="form-control {{ isset($lockout_username) && $lockout_username == old('username') ? 'input-locked' : '' }}"
                                id="password" name="password" placeholder="Masukkan password" required
                                autocomplete="current-password">
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="loginButton"
                        {{ isset($lockout_username) && $lockout_time > 0 ? 'disabled' : '' }}>
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="buttonText">Login ke Dashboard</span>
                    </button>

                    <!-- Error Alert for AJAX -->
                    <div id="loginError" style="display:none; margin-bottom:20px;" class="alert-modern alert-error">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="loginErrorText"></span>
                    </div>

                    @if ($superadminExists)
                        <div class="register-section mb-2">
                            <small>
                                <a href="{{ url('/forgot-password') }}" class="register-link">
                                    <i class="fas fa-key me-1"></i> Lupa Password?
                                </a>
                            </small>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Clear lockout status when user changes username
        function clearLockoutStatus() {
            const usernameInput = document.getElementById('username');
            const currentUsername = usernameInput.value;
            const lockedUsername = '{{ $lockout_username ?? '' }}';

            if (currentUsername !== lockedUsername) {
                const loginButton = document.getElementById('loginButton');
                const passwordInput = document.getElementById('password');

                if (loginButton.disabled) {
                    loginButton.disabled = false;
                    usernameInput.classList.remove('input-locked');
                    passwordInput.classList.remove('input-locked');

                    const lockoutMessage = document.querySelector('.alert-lockout');
                    if (lockoutMessage) {
                        lockoutMessage.style.display = 'none';
                    }
                }
            }
        }

        // Countdown for lockout
        @if (isset($lockout_username) && $lockout_username && $lockout_time > 0)
            let lockoutSeconds = {{ $lockout_time }};
            const countdownDisplay = document.getElementById('countdownDisplay');
            const loginButton = document.getElementById('loginButton');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            function formatTime(seconds) {
                if (seconds < 60) {
                    return seconds + ' detik';
                } else if (seconds < 3600) {
                    const minutes = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return minutes + ' menit ' + (secs > 0 ? secs + ' detik' : '');
                } else {
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    return hours + ' jam ' + (minutes > 0 ? minutes + ' menit' : '');
                }
            }

            function updateCountdown() {
                if (lockoutSeconds <= 0) {
                    countdownDisplay.textContent = 'Akun terbuka!';
                    loginButton.disabled = false;
                    usernameInput.classList.remove('input-locked');
                    passwordInput.classList.remove('input-locked');

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                    return;
                }

                countdownDisplay.textContent = formatTime(lockoutSeconds);
                lockoutSeconds--;

                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();

            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const currentUsername = document.getElementById('username').value;
                const lockedUsername = '{{ $lockout_username }}';

                if (currentUsername === lockedUsername && lockoutSeconds > 0) {
                    e.preventDefault();
                    alert('Akun ' + lockedUsername + ' masih terkunci. Silakan tunggu atau gunakan akun lain.');
                    return false;
                }
            });
        @endif

        // AJAX Login
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const loginButton = $('#loginButton');
                const buttonText = $('#buttonText');
                const errorDiv = $('#loginError');
                const errorText = $('#loginErrorText');

                // Disable button and show loading
                loginButton.prop('disabled', true);
                buttonText.html('<i class="fas fa-spinner fa-spin"></i> Sedang login...');
                errorDiv.hide();

                $.ajax({
                    url: '{{ url('/login') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Redirect to dashboard
                            window.location.href = response.redirect;
                        } else {
                            // Show error
                            errorText.text(response.message);
                            errorDiv.show();

                            // Handle lockout
                            if (response.locked) {
                                const lockoutPopup = $('.alert-lockout');
                                if (lockoutPopup.length) {
                                    lockoutPopup.show();
                                }

                                // Update lockout UI
                                if (response.lockout_time) {
                                    startLockoutCountdown(response.lockout_time, response
                                        .multiplier, response.attempts_info);
                                }
                            }

                            // Handle attempts progress
                            if (response.show_progress && response.attempts_info) {
                                updateAttemptsProgress(response.attempts_info);
                            }

                            // Re-enable button
                            loginButton.prop('disabled', false);
                            buttonText.html(
                                '<i class="fas fa-sign-in-alt"></i> Login ke Dashboard');
                        }
                    },
                    error: function(xhr) {
                        errorText.text('Terjadi kesalahan. Silakan coba lagi.');
                        errorDiv.show();
                        loginButton.prop('disabled', false);
                        buttonText.html(
                            '<i class="fas fa-sign-in-alt"></i> Login ke Dashboard');
                    }
                });
            });

            // Hide error when typing
            $('#username, #password').on('input', function() {
                $('#loginError').hide();
            });
        });

        function updateAttemptsProgress(attemptsInfo) {
            const attemptsBox = $('.attempts-box');
            if (attemptsBox.length === 0 && attemptsInfo) {
                // Create attempts box if it doesn't exist
                const progressHtml = `
                    <div class="attempts-box" style="margin-bottom:24px;">
                        <div class="attempts-header">
                            <small>Status Percobaan Login</small>
                            <small>${attemptsInfo.attempts_left} / ${attemptsInfo.max_attempts}</small>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill ${getProgressBarClass(attemptsInfo.percentage)}"
                                style="width: ${attemptsInfo.percentage}%"></div>
                        </div>
                        <div class="attempts-footer">
                            ${attemptsInfo.percentage >= 80 ?
                                '<i class="fas fa-exclamation-triangle text-danger me-1"></i><strong>Hampir terkunci!</strong>' :
                              attemptsInfo.percentage >= 60 ?
                                '<i class="fas fa-exclamation-circle me-1"></i><span>Peringatan!</span>' :
                                '<i class="fas fa-info-circle me-1"></i><span>Percobaan tersisa</span>'}
                        </div>
                    </div>
                `;
                $('.alert-error, .alert-session').after(progressHtml);
            }
        }

        function getProgressBarClass(percentage) {
            if (percentage >= 80) return 'locked';
            if (percentage >= 60) return 'danger';
            if (percentage >= 40) return 'warning';
            if (percentage >= 20) return 'caution';
            return 'safe';
        }

        function startLockoutCountdown(seconds, multiplier, attemptsInfo) {
            let lockoutSeconds = seconds;
            const countdownDisplay = $('#countdownDisplay');
            const loginButton = $('#loginButton');
            const usernameInput = $('#username');
            const passwordInput = $('#password');

            function formatTime(secs) {
                if (secs < 60) {
                    return secs + ' detik';
                } else if (secs < 3600) {
                    const minutes = Math.floor(secs / 60);
                    const s = secs % 60;
                    return minutes + ' menit ' + (s > 0 ? s + ' detik' : '');
                } else {
                    const hours = Math.floor(secs / 3600);
                    const minutes = Math.floor((secs % 3600) / 60);
                    return hours + ' jam ' + (minutes > 0 ? minutes + ' menit' : '');
                }
            }

            function updateCountdown() {
                if (lockoutSeconds <= 0) {
                    countdownDisplay.textContent = 'Akun terbuka!';
                    loginButton.prop('disabled', false);
                    usernameInput.removeClass('input-locked');
                    passwordInput.removeClass('input-locked');

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                    return;
                }

                countdownDisplay.textContent = formatTime(lockoutSeconds);
                lockoutSeconds--;

                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();
        }
    </script>
</body>

</html>
