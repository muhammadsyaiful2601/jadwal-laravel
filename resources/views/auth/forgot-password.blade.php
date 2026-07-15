<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lupa Password - Jadwal Kuliah</title>
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
            background: var(--nb-teal);
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

        .alert-success {
            background: var(--nb-green);
            color: var(--nb-black);
            border-left: 4px solid var(--nb-black);
        }

        .success-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .success-icon-wrapper {
            width: 50px;
            height: 50px;
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: var(--nb-shadow-sm);
        }

        .success-icon-wrapper i {
            font-size: 1.4rem;
            color: var(--nb-green);
        }

        .success-text {
            flex: 1;
        }

        .success-title {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 4px;
        }

        .success-message {
            font-size: 0.9rem;
            color: var(--nb-dark);
        }

        .info-box {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 12px 14px;
            display: inline-block;
            margin-top: 10px;
            box-shadow: var(--nb-shadow-sm);
        }

        .info-box small {
            font-size: 0.8rem;
            color: var(--nb-dark);
            font-weight: 600;
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
            background: var(--nb-purple);
        }

        /* Button */
        .btn-primary-custom {
            width: 100%;
            padding: 16px 24px;
            background: var(--nb-purple);
            color: var(--nb-white);
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
            background: var(--nb-pink);
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
</head>

<body>
    <div class="split-container">
        <!-- LEFT PANEL: Brand & Welcome -->
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
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100/4ECDC4/ffffff?text=PNP'">

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

        <!-- RIGHT PANEL: Forgot Password Form -->
        <div class="right-panel">
            <div class="form-card">
                <div class="form-header">
                    <div class="form-logo-row">
                        <img src="{{ asset('jadwal-kampus/assets/images/logo_kampus.png') }}" alt="Logo"
                            class="form-logo"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/4ECDC4/ffffff?text=PNP'">
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
                    <div class="alert-modern alert-success">
                        <div class="success-content">
                            <div class="success-icon-wrapper">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div class="success-text">
                                <div class="success-title">
                                    ✅ Email Terkirim!
                                </div>
                                <span class="success-message">
                                    {{ session('success') }}
                                </span>
                                <div class="info-box">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        Cek folder <strong>Spam</strong> atau <strong>Promosi</strong> jika tidak
                                        menemukan email di Inbox
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ url('/forgot-password') }}" id="resetForm">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required autofocus>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" id="sendResetBtn" class="btn-primary-custom">
                        <i class="fas fa-paper-plane"></i>
                        <span id="btnText">Kirim Link Reset</span>
                    </button>

                    <div class="back-link">
                        <small>
                            <a href="{{ url('/login') }}">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                            </a>
                        </small>
                    </div>
                </form>

                <!-- Hidden notification area (shown after AJAX send) -->
                <div id="emailNotification" class="alert-modern alert-success" style="display:none;">
                    <div class="success-content">
                        <div class="success-icon-wrapper">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="success-text">
                            <div class="success-title">
                                ✅ Link Terkirim!
                            </div>
                            <span class="success-message" id="notificationMessage">
                                Link reset password telah dikirim ke email Anda. Silakan cek inbox.
                            </span>
                            <div class="info-box" style="margin-top:10px;">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Cek folder <strong>Spam</strong> atau <strong>Promosi</strong> jika tidak
                                    menemukan email di Inbox
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // === PERSISTENT COUNTDOWN TIMER ===
        // Uses localStorage to survive page reloads
        // Cooldown multiplies by 2 on each click (2x, 4x, 8x, 16x, ...)

        const BASE_COOLDOWN = 30; // seconds
        const STORAGE_KEY = 'reset_cooldown';
        let countdownInterval = null;

        // Load persisted state from localStorage
        function loadCooldownState() {
            try {
                const raw = localStorage.getItem(STORAGE_KEY);
                if (!raw) return null;
                const state = JSON.parse(raw);
                // Calculate how much time has passed
                const elapsed = (Date.now() - state.timestamp) / 1000;
                const remaining = state.total_seconds - elapsed;
                if (remaining <= 0) {
                    localStorage.removeItem(STORAGE_KEY);
                    return null;
                }
                return {
                    remaining: Math.ceil(remaining),
                    multiplier: state.multiplier,
                    total_seconds: state.total_seconds,
                    email: state.email
                };
            } catch (e) {
                localStorage.removeItem(STORAGE_KEY);
                return null;
            }
        }

        function saveCooldownState(totalSeconds, multiplier, email) {
            const state = {
                total_seconds: totalSeconds,
                multiplier: multiplier,
                email: email,
                timestamp: Date.now()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        }

        function clearCooldownState() {
            localStorage.removeItem(STORAGE_KEY);
        }

        const btn = document.getElementById('sendResetBtn');
        const btnText = document.getElementById('btnText');
        const form = document.getElementById('resetForm');
        const emailInput = document.getElementById('email');
        const notification = document.getElementById('emailNotification');
        const notificationMessage = document.getElementById('notificationMessage');

        // === On DOM load: restore cooldown only if email matches ===
        document.addEventListener('DOMContentLoaded', function() {
            const saved = loadCooldownState();
            const currentEmail = emailInput.value.trim();
            if (saved && saved.email === currentEmail) {
                startCooldown(saved.remaining, saved.multiplier, false);
            } else if (saved && saved.email !== currentEmail) {
                // Different email - clear the cooldown
                clearCooldownState();
            }
        });

        // === On email change: reset cooldown if email differs ===
        emailInput.addEventListener('input', function() {
            const saved = loadCooldownState();
            const currentEmail = this.value.trim();
            if (saved && saved.email !== currentEmail) {
                // Email changed - clear cooldown and reset button
                clearCooldownState();
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btnText.textContent = 'Kirim Link Reset';
                const btnIcon = btn.querySelector('i');
                if (btnIcon) {
                    btnIcon.className = 'fas fa-paper-plane';
                }
            }
        });

        // === On button click: AJAX submit ===
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            // Validate email
            const email = emailInput.value.trim();
            if (!email) {
                emailInput.focus();
                return;
            }

            // Check if there's an active cooldown in localStorage
            const saved = loadCooldownState();
            if (saved) {
                // If saved email matches current email, double the cooldown
                if (saved.email === email) {
                    const newMultiplier = saved.multiplier * 2;
                    const newTotal = BASE_COOLDOWN * newMultiplier;
                    startCooldown(newTotal, newMultiplier, true, email);
                } else {
                    // Email changed since cooldown started - reset
                    clearCooldownState();
                    const multiplier = 1;
                    const totalSeconds = BASE_COOLDOWN * multiplier;
                    startCooldown(totalSeconds, multiplier, true, email);
                }
                return;
            }

            // No cooldown - submit via AJAX
            const multiplier = 1;
            const totalSeconds = BASE_COOLDOWN * multiplier;
            startCooldown(totalSeconds, multiplier, true, email);

            // Show loading state
            btnText.textContent = 'Mengirim...';
            btn.disabled = true;

            // AJAX submit
            $.ajax({
                url: form.action,
                method: 'POST',
                data: $(form).serialize(),
                dataType: 'json',
                success: function(response) {
                    // Show notification
                    notificationMessage.textContent = response.message ||
                        'Link reset password telah dikirim ke email ' + email + '. Silakan cek inbox.';
                    notification.style.display = 'block';
                    notification.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                },
                error: function(xhr) {
                    let msg = 'Gagal mengirim email. Silakan coba lagi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        msg = xhr.responseJSON.error;
                    } else if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors && errors.email) {
                            msg = errors.email[0];
                        }
                    }
                    // Show error notification
                    notification.className = 'alert-modern alert-error';
                    notificationMessage.textContent = msg;
                    notification.style.display = 'block';
                    notification.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });

        function startCooldown(totalSeconds, multiplier, saveToStorage, email) {
            // Clear any existing interval
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }

            const remaining = Math.ceil(totalSeconds);

            // Save to localStorage if requested
            if (saveToStorage) {
                saveCooldownState(totalSeconds, multiplier, email || emailInput.value.trim());
            }

            // Update button state immediately
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btn.style.cursor = 'not-allowed';
            btnText.textContent = `Tunggu ${formatTime(remaining)}`;

            // If cooldown >= 60s, also update the button icon
            const btnIcon = btn.querySelector('i');
            if (btnIcon) {
                btnIcon.className = 'fas fa-clock';
            }

            let countdown = remaining;

            countdownInterval = setInterval(function() {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    clearCooldownState();

                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.style.cursor = 'pointer';
                    btnText.textContent = 'Kirim Link Reset';
                    if (btnIcon) {
                        btnIcon.className = 'fas fa-paper-plane';
                    }
                } else {
                    btnText.textContent = `Tunggu ${formatTime(countdown)}`;
                }
            }, 1000);
        }

        function formatTime(seconds) {
            const s = Math.max(0, Math.ceil(seconds));
            if (s >= 60) {
                const mins = Math.floor(s / 60);
                const secs = s % 60;
                return `${mins}m ${secs}s`;
            }
            return `${s}s`;
        }
    </script>
</body>

</html>
