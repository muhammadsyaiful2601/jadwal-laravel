<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Admin Panel</title>
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
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
        }

        /* Top Bar */
        .top-bar {
            background: var(--nb-white);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: var(--nb-border);
            position: sticky;
            top: 0;
            z-index: 500;
            box-shadow: var(--nb-shadow-sm);
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-bar-toggle {
            display: none;
            background: var(--nb-white);
            border: var(--nb-border);
            font-size: 1.2rem;
            color: var(--nb-black);
            cursor: pointer;
            padding: 8px 12px;
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
        }

        .top-bar-toggle:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .top-bar-toggle:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .top-bar-left h4 {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 0;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .top-bar-date {
            font-family: var(--font-display);
            font-size: 0.85rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .top-bar-right .dropdown-toggle {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 10px 16px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
        }

        .top-bar-right .dropdown-toggle:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .top-bar-right .dropdown-toggle::after {
            display: none;
        }

        .top-bar-right .dropdown-menu {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow);
            padding: 8px;
            min-width: 180px;
            background: var(--nb-white);
        }

        .top-bar-right .dropdown-item {
            border-radius: var(--nb-radius-sm);
            padding: 10px 14px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }

        .top-bar-right .dropdown-item:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
        }

        .top-bar-right .dropdown-item.text-danger {
            color: var(--nb-red);
        }

        .top-bar-right .dropdown-item.text-danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .top-bar-right .dropdown-divider {
            margin: 4px 0;
            border-color: var(--nb-gray);
        }

        .content-wrapper {
            padding: 28px 32px;
        }

        .page-title-section {
            margin-bottom: 28px;
        }

        .page-title-section h4 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 6px;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .page-title-section p {
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--nb-dark);
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Cards */
        .card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: var(--nb-border);
            background: var(--nb-purple);
        }

        .card-header h5 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-white);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-body {
            padding: 24px;
            background: var(--nb-white);
        }

        /* Profile Header */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
            padding: 20px;
            background: var(--nb-offwhite);
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: var(--nb-purple);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            flex-shrink: 0;
            box-shadow: var(--nb-shadow);
        }

        .profile-info h4 {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .profile-info p {
            color: var(--nb-dark);
            font-size: 0.95rem;
            margin: 0;
            font-weight: 600;
        }

        /* Alerts */
        .alert {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: var(--nb-green);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .alert-warning {
            background: var(--nb-orange);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .alert-danger {
            background: var(--nb-red);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
        }

        /* Forms */
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

        .form-control,
        .form-select {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 12px 16px;
            font-family: var(--font-body);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--nb-black);
            background: var(--nb-white);
            transition: all 0.2s ease;
            box-shadow: var(--nb-shadow-sm);
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .form-control-plaintext {
            padding: 12px 0;
            font-family: var(--font-body);
            font-size: 0.92rem;
            color: var(--nb-black);
            font-weight: 600;
        }

        .input-group {
            display: flex;
        }

        .input-group .form-control {
            border-radius: var(--nb-radius-sm) 0 0 var(--nb-radius-sm);
            border-right: none;
        }

        .input-group .btn {
            border-radius: 0 var(--nb-radius-sm) var(--nb-radius-sm) 0;
            padding: 12px 16px;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            border: var(--nb-border);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary-custom {
            background: var(--nb-purple);
            color: var(--nb-white);
        }

        .btn-primary-custom:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-secondary-custom {
            background: var(--nb-white);
            color: var(--nb-black);
        }

        .btn-secondary-custom:hover {
            background: var(--nb-gray);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-outline-primary {
            background: var(--nb-white);
            color: var(--nb-black);
            border: var(--nb-border);
        }

        .btn-outline-primary:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        hr {
            border-color: var(--nb-gray);
            opacity: 1;
        }

        /* Modal */
        .modal-content-custom {
            border-radius: var(--nb-radius);
            border: var(--nb-border-thick);
            box-shadow: var(--nb-shadow-lg);
        }

        .modal-header-custom {
            padding: 20px 24px;
            border-bottom: var(--nb-border);
            background: var(--nb-purple);
        }

        .modal-header-custom .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-white);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-header-custom .btn-close {
            filter: invert(1);
        }

        .modal-body-custom {
            padding: 24px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar-toggle {
                display: block;
            }

            .top-bar {
                padding: 14px 20px;
            }

            .content-wrapper {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 16px;
            }

            .top-bar {
                padding: 12px 16px;
            }

            .top-bar-date {
                display: none;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Profile</h4>
            </div>
            <div class="top-bar-right">
                <span class="top-bar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ session('username') }}
                        <i class="fas fa-chevron-down" style="font-size:0.7rem; opacity:0.6;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}"><i
                                    class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i>
                                Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100"
                                    style="display:flex; align-items:center; gap:10px;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <div class="page-title-section">
                <h4>Profile Saya</h4>
                <p>Kelola informasi akun dan keamanan Anda</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-user-circle"></i> Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            {{ strtoupper(substr(session('username'), 0, 1)) }}
                        </div>
                        <div class="profile-info">
                            <h4>{{ session('username') }}</h4>
                            <p>{{ ucfirst(session('role')) }}</p>
                        </div>
                    </div>

                    @if (session('role') == 'superadmin')
                        <div class="alert {{ $user->email_verified_at ? 'alert-success' : 'alert-warning' }} alert-dismissible fade show"
                            role="alert">
                            <i
                                class="fas {{ $user->email_verified_at ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                            <strong>Status Email:</strong>
                            @if ($user->email_verified_at)
                                Terverifikasi ({{ date('d F Y H:i', strtotime($user->email_verified_at)) }})
                            @else
                                Belum Terverifikasi
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/admin/profile/update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username', $user->username) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}">
                                    @if (session('role') == 'superadmin' && !$user->email_verified_at)
                                        <button type="button" class="btn btn-outline-primary"
                                            onclick="showVerificationModal()">
                                            <i class="fas fa-envelope"></i> Verifikasi
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; text-transform: uppercase;">
                            <i class="fas fa-lock me-2"></i>Ubah Password
                        </h5>
                        <p style="font-size: 0.875rem; color: var(--nb-dark); margin-bottom: 16px; font-weight: 500;">
                            Kosongkan jika tidak ingin mengubah password
                        </p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="new_password" class="form-control" minlength="6">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" class="form-control" minlength="6">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary-custom">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title">
                        <i class="fas fa-envelope me-2"></i>Verifikasi Email
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modal-body-custom">
                    <p style="color: var(--nb-dark); font-size: 0.95rem; margin-bottom: 20px; font-weight: 500;">
                        Pilih salah satu opsi di bawah ini:
                    </p>

                    @if (!empty($user->email))
                        <div class="d-grid gap-2 mb-3">
                            <form method="POST" action="{{ url('/admin/profile/send-verification') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary-custom w-100" style="padding: 12px;">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Link Verifikasi ke Email Saat Ini
                                </button>
                            </form>
                        </div>
                    @endif

                    <hr style="border-color: var(--nb-gray);">

                    <h6
                        style="font-weight: 700; color: var(--nb-black); margin-bottom: 12px; text-transform: uppercase;">
                        <i class="fas fa-plus-circle me-1"></i> Buat Email Baru
                    </h6>
                    <form method="POST" action="{{ url('/admin/profile/update-email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Baru</label>
                            <input type="email" name="new_email" class="form-control"
                                placeholder="Masukkan email baru" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span style="color: var(--nb-red);">*</span></label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password untuk konfirmasi" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100" style="padding: 12px;">
                            <i class="fas fa-save me-2"></i> Simpan Email Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showVerificationModal() {
            new bootstrap.Modal(document.getElementById('verificationModal')).show();
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const s = document.getElementById('sidebar');
                const o = document.getElementById('sidebarOverlay');
                if (s.classList.contains('show')) {
                    s.classList.remove('show');
                    o.classList.remove('show');
                }
            }
        });
    </script>
</body>

</html>
