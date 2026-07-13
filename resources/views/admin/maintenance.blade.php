<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Admin Panel</title>
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

        .maintenance-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--nb-red);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        /* Info Box */
        .info-box {
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            padding: 18px 22px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            box-shadow: var(--nb-shadow);
        }

        .info-box i {
            color: var(--nb-black);
            font-size: 1.2rem;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .info-box strong {
            font-family: var(--font-display);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--nb-black);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-box p {
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-black);
            margin-bottom: 0;
            font-weight: 600;
            margin-top: 4px;
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

        .btn-primary-custom:disabled {
            opacity: 0.4;
            cursor: not-allowed;
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

        .btn-secondary-custom:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-danger-custom {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .btn-danger-custom:hover {
            background: var(--nb-red);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
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

        .form-control {
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

        .form-control:focus {
            outline: none;
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 48px;
            height: 24px;
            background: var(--nb-gray);
            border-radius: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: var(--nb-border);
            flex-shrink: 0;
        }

        .toggle-switch.active {
            background: var(--nb-green);
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--nb-white);
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            box-shadow: var(--nb-shadow-sm);
            border: 2px solid var(--nb-black);
        }

        .toggle-switch.active::after {
            left: 26px;
            background: var(--nb-white);
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        .status-online {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .status-offline {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        hr {
            border-color: var(--nb-gray);
            opacity: 1;
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
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    @include('components.admin.sidebar')

    <div class="main-content">
        @if (session('success') || session('error') || session('info'))
            <div id="notification-container"
                style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
                @if (session('success'))
                    <div class="alert-flash success" style="margin-bottom: 10px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert-flash error" style="margin-bottom: 10px;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif
                @if (session('info'))
                    <div class="alert-flash info" style="margin-bottom: 10px;">
                        <i class="fas fa-info-circle"></i> {{ session('info') }}
                    </div>
                @endif
            </div>
        @endif

        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Maintenance</h4>
                @if ($isMaintenance)
                    <span class="maintenance-badge-top"><i class="fas fa-tools"></i> Maintenance Mode</span>
                @endif
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
                <h4>Maintenance Mode</h4>
                <p>Kelola mode maintenance aplikasi</p>
            </div>

            <div class="info-box">
                <div class="d-flex align-items-start gap-2">
                    <i class="fas fa-info-circle mt-1"></i>
                    <div>
                        <strong>Informasi:</strong>
                        <p class="mb-0" style="font-size: 0.875rem;">Saat mode maintenance aktif, aplikasi akan
                            menampilkan halaman maintenance kepada semua pengguna kecuali admin. Fitur meliputi
                            penjadwalan backup database, pembersihan cache/log, dan pengaturan timeout sesi.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-database"></i> Backup Database</h5>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--nb-dark); margin-bottom: 16px; font-weight: 500;">
                        Backup database untuk menyimpan data penting.</p>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ url('/admin/manage-settings/backup-database') }}" class="btn btn-primary-custom">
                            <i class="fas fa-download me-1"></i> Backup Sekarang
                        </a>
                        <a href="{{ url('/admin/backup-history') }}" class="btn btn-secondary-custom">
                            <i class="fas fa-history me-1"></i> Lihat Riwayat Backup
                        </a>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; text-transform: uppercase;">
                        <i class="fas fa-broom me-2"></i>Pembersihan Data
                    </h5>
                    <p style="font-size: 0.875rem; color: var(--nb-dark); margin-bottom: 16px; font-weight: 500;">
                        Hapus cache, log, dan data sementara untuk mengoptimalkan kinerja aplikasi.</p>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ url('/admin/manage-settings/clear-cache') }}" class="btn btn-primary-custom"
                            onclick="return confirm('Yakin hapus semua cache sistem?')">
                            <i class="fas fa-broom me-1"></i> Clear Cache
                        </a>
                        <a href="{{ url('/admin/manage-settings/clear-logs') }}" class="btn btn-primary-custom"
                            onclick="return confirm('Yakin hapus semua log aktivitas?')">
                            <i class="fas fa-file-alt me-1"></i> Clear Logs
                        </a>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; text-transform: uppercase;">
                        <i class="fas fa-clock me-2"></i>Pengaturan Sesi
                    </h5>
                    <p style="font-size: 0.875rem; color: var(--nb-dark); margin-bottom: 16px; font-weight: 500;">
                        Atur batas waktu sesi login untuk keamanan.</p>

                    <form method="POST" action="{{ url('/admin/maintenance/session') }}" class="d-inline">
                        @csrf
                        <div class="d-flex gap-2 flex-wrap align-items-end">
                            <div style="flex: 1; min-width: 200px;">
                                <label class="form-label">Timeout Sesi (menit)</label>
                                <input type="number" name="session_timeout" class="form-control"
                                    value="{{ $settings['session_timeout'] ?? 60 }}" min="5" max="480">
                            </div>
                            @if ($superadminVerified)
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            @else
                                <button type="button" class="btn btn-primary-custom" disabled>
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            @endif
                        </div>
                    </form>

                    <hr class="my-4">

                    <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; text-transform: uppercase;">
                        <i class="fas fa-cog me-2"></i>Mode Maintenance
                    </h5>
                    <p style="font-size: 0.875rem; color: var(--nb-dark); margin-bottom: 16px; font-weight: 500;">
                        Aktifkan atau nonaktifkan mode maintenance.</p>

                    <form method="POST" action="{{ url('/admin/maintenance/toggle') }}" id="maintenanceForm">
                        @csrf
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div class="toggle-switch {{ $isMaintenance ? 'active' : '' }}" id="maintenanceToggle"
                                style="cursor: pointer;" tabindex="0" role="switch"
                                aria-checked="{{ $isMaintenance ? 'true' : 'false' }}"></div>
                            <span class="status-indicator {{ $isMaintenance ? 'status-offline' : 'status-online' }}"
                                id="maintenanceStatus">
                                <i class="fas {{ $isMaintenance ? 'fa-exclamation-circle' : 'fa-check-circle' }}"></i>
                                {{ $isMaintenance ? 'Maintenance Aktif' : 'Aplikasi Online' }}
                            </span>
                        </div>

                        <div class="mt-3">
                            @if ($superadminVerified)
                                <button type="submit" class="btn btn-primary-custom" id="applyMaintenance">
                                    <i class="fas fa-save me-1"></i> Terapkan Perubahan
                                </button>
                            @else
                                <button type="button" class="btn btn-primary-custom" disabled id="applyMaintenance">
                                    <i class="fas fa-save me-1"></i> Terapkan Perubahan
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            function updateStatusUI(isActive) {
                $('#maintenanceStatus')
                    .removeClass('status-online status-offline')
                    .addClass(isActive ? 'status-offline' : 'status-online')
                    .html('<i class="fas ' + (isActive ? 'fa-exclamation-circle' : 'fa-check-circle') + '"></i> ' +
                        (isActive ? 'Maintenance Aktif' : 'Aplikasi Online'));
                $('#maintenanceToggle').attr('aria-checked', isActive ? 'true' : 'false');
            }

            $('#maintenanceToggle').on('click', function() {
                $(this).toggleClass('active');
                updateStatusUI($(this).hasClass('active'));
            });

            $('#maintenanceToggle').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });

            $('#maintenanceForm').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#applyMaintenance');
                var originalText = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

                $.post($(this).attr('action'), $(this).serialize(), function(resp) {
                    alert('Pengaturan maintenance berhasil disimpan');
                    location.reload();
                }).fail(function() {
                    alert('Gagal menyimpan pengaturan');
                }).always(function() {
                    btn.prop('disabled', false).html(originalText);
                });
            });
        });
    </script>
</body>

</html>
