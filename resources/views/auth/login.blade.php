<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --navy-primary: #0f172a;
            --navy-secondary: #1e293b;
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

        /* Split Screen Container */
        .split-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Left Panel - Brand / Welcome */
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

        /* Decorative geometric elements */
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

        .geo-line {
            position: absolute;
            top: 50%;
            left: -60px;
            width: 200px;
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            transform: rotate(30deg);
        }

        .geo-line-2 {
            position: absolute;
            bottom: 40%;
            right: -40px;
            width: 150px;
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
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

        /* Right Panel - Login Form */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--white);
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

        /* Alerts */
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 0.88rem;
        }

        .alert-session {
            background: #fefce8;
            color: #a16207;
            border-left: 4px solid #eab308;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .alert-lockout {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            text-align: center;
        }

        .alert-lockout i {
            font-size: 1.8rem;
            color: #dc2626;
            display: block;
            margin-bottom: 8px;
        }

        .alert-lockout h5 {
            font-weight: 600;
            color: #7f1d1d;
            font-size: 1rem;
        }

        .alert-lockout p {
            color: #991b1b;
            font-size: 0.88rem;
        }

        .lockout-level {
            display: inline-block;
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 6px;
        }

        .countdown-display {
            font-weight: 700;
            font-size: 1.1rem;
            color: #dc2626;
            margin: 8px 0;
        }

        /* Attempts Progress */
        .attempts-box {
            background: var(--zinc-100);
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 24px;
        }

        .attempts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .attempts-header small {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--zinc-600);
        }

        .progress-track {
            height: 8px;
            background: #e4e4e7;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .progress-fill.safe {
            background: #22c55e;
        }

        .progress-fill.caution {
            background: #eab308;
        }

        .progress-fill.warning {
            background: #f97316;
        }

        .progress-fill.danger {
            background: #ef4444;
        }

        .progress-fill.locked {
            background: #71717a;
        }

        .attempts-footer {
            margin-top: 8px;
            font-size: 0.8rem;
            color: var(--zinc-400);
        }

        .refresh-notice {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        /* Form Inputs - Modern Inline Icon Style */
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

        .input-wrapper .form-control.input-locked {
            background: #fefce8;
            border-color: #eab308;
        }

        /* Toggle password visibility */
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--zinc-400);
            cursor: pointer;
            padding: 4px;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: var(--zinc-600);
        }

        /* Login Button - Solid Corporate Blue */
        .btn-login {
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
        }

        .btn-login:hover:not(:disabled) {
            background: var(--corporate-blue-hover);
            transform: translateY(-1px);
        }

        .btn-login:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-login:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login i {
            font-size: 0.9rem;
        }

        /* Register Link */
        .register-section {
            text-align: center;
            padding-top: 4px;
        }

        .register-section small {
            font-size: 0.85rem;
            color: var(--zinc-600);
        }

        .register-link {
            color: var(--corporate-blue);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
            position: relative;
        }

        .register-link:hover {
            color: var(--corporate-blue-hover);
        }

        .register-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--corporate-blue);
            transition: width 0.25s ease;
        }

        .register-link:hover::after {
            width: 100%;
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
                font-size: 1.2rem;
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
                <img src="{{ asset('jadwal-kampus/assets/images/SI.png') }}" alt="Logo Sistem Informasi"
                    class="left-logo"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100/1e293b/ffffff?text=SI'">

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
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/0f172a/ffffff?text=PNP'">
                    </div>
                    <h2>{{ $institusiNama ?? 'Politeknik Negeri Padang' }}</h2>
                    <p>{{ $institusiLokasi ?? 'PSDKU Tanah Datar' }}</p>
                </div>

                <!-- Session Expired Alert -->
                @if ($sessionExpired)
                    <div class="alert-modern alert-session">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Sesi Berakhir!</strong><br>
                        <small>Sesi Anda telah berakhir. Silakan login kembali untuk melanjutkan.</small>
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
                                <i class="fas fa-exclamation-triangle text-danger me-1"></i>
                                <strong class="text-danger">Hampir terkunci!</strong>
                            @elseif($attempts_info['percentage'] >= 60)
                                <i class="fas fa-exclamation-circle text-warning me-1"></i>
                                <span class="text-warning">Peringatan!</span>
                            @else
                                <i class="fas fa-info-circle text-info me-1"></i>
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
                                '<i class="fas fa-exclamation-triangle text-danger me-1"></i><strong class="text-danger">Hampir terkunci!</strong>' :
                              attemptsInfo.percentage >= 60 ?
                                '<i class="fas fa-exclamation-circle text-warning me-1"></i><span class="text-warning">Peringatan!</span>' :
                                '<i class="fas fa-info-circle text-info me-1"></i><span>Percobaan tersisa</span>'}
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

                countdownDisplay.text(formatTime(lockoutSeconds));
                lockoutSeconds--;
                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();
        }

        // Prevent form resubmission on refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Auto focus on username field if session expired
        @if ($sessionExpired)
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('username').focus();
            });
        @endif

        // Clear session data when leaving page
        window.addEventListener('beforeunload', function() {
            if (typeof navigator.sendBeacon === 'function') {
                navigator.sendBeacon('{{ url('/clear-login-session') }}');
            }
        });
    </script>
</body>

</html>
