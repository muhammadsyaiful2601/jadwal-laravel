<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Admin Panel</title>
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

        /* Settings Cards */
        .settings-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        .settings-card-title {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 20px;
            margin-bottom: 24px;
            border-bottom: var(--nb-border);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .settings-card-title i {
            color: var(--nb-purple);
            font-size: 1rem;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group-custom {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group-custom.full {
            grid-column: 1 / -1;
        }

        .form-group-custom label {
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--nb-black);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control-modern {
            padding: 10px 14px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            background: var(--nb-white);
            outline: none;
            transition: all 0.15s ease;
            width: 100%;
            box-shadow: var(--nb-shadow-sm);
        }

        .form-control-modern:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .form-control-modern::placeholder {
            color: var(--nb-gray);
        }

        .form-control-modern:read-only {
            background: var(--nb-gray);
            color: var(--nb-dark);
            cursor: not-allowed;
        }

        select.form-control-modern {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23000' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 14px;
            cursor: pointer;
            padding-right: 36px;
        }

        textarea.form-control-modern {
            resize: vertical;
        }

        .form-hint {
            font-family: var(--font-body);
            font-size: 0.75rem;
            color: var(--nb-dark);
            margin-top: 2px;
            font-weight: 500;
        }

        /* Toggle Switch */
        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 28px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--nb-gray);
            border-radius: 28px;
            transition: all 0.3s ease;
            border: var(--nb-border);
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background: var(--nb-white);
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: var(--nb-shadow-sm);
            border: 2px solid var(--nb-black);
        }

        .toggle-switch input:checked+.toggle-slider {
            background: var(--nb-green);
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(20px);
        }

        .toggle-label-text {
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--nb-black);
        }

        /* Color Picker Row */
        .color-picker-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .color-input-wrap input[type="color"] {
            width: 56px;
            height: 48px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            cursor: pointer;
            padding: 3px;
            background: var(--nb-white);
            flex-shrink: 0;
            box-shadow: var(--nb-shadow-sm);
        }

        .color-input-wrap input[type="color"]:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .color-input-wrap .color-label {
            font-family: var(--font-display);
            font-size: 0.82rem;
            color: var(--nb-black);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 48px;
            background: var(--nb-offwhite);
            padding: 8px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            width: 100%;
        }

        .color-input-wrap .color-label small {
            color: var(--nb-dark);
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .color-input-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-value-text {
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--nb-black);
            background: var(--nb-white);
            padding: 4px 10px;
            border-radius: 4px;
            border: 2px solid var(--nb-black);
        }

        /* Preview Box */
        .preview-box {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 20px;
            background: var(--nb-offwhite);
            margin-top: 8px;
            box-shadow: var(--nb-shadow-sm);
        }

        .preview-box-title {
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--nb-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #runningTextPreview {
            min-height: 60px;
            display: flex;
            align-items: center;
            border-radius: var(--nb-radius-sm);
            padding: 12px 16px;
            overflow: hidden;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        #runningTextPreview marquee {
            width: 100%;
            font-weight: 600;
            font-family: var(--font-body);
        }

        /* Security Row */
        .security-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Danger Zone */
        .danger-zone {
            background: var(--nb-red);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 28px 32px;
            margin-bottom: 24px;
            box-shadow: var(--nb-shadow);
        }

        .danger-zone-title {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-white);
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: var(--nb-border);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .danger-zone-title i {
            color: var(--nb-yellow);
        }

        .danger-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .btn-destructive-outline {
            padding: 12px 18px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-red);
            width: 100%;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-destructive-outline:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        /* Primary Button */
        .btn-primary-solid {
            padding: 10px 28px;
            background: var(--nb-purple);
            color: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary-solid:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        /* Alert flash */
        .alert-flash {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-body);
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-flash.success {
            background: var(--nb-green);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .alert-flash.error {
            background: var(--nb-red);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
        }

        .alert-flash.info {
            background: var(--nb-blue);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
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
                max-width: 100%;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
            }

            .color-picker-row {
                grid-template-columns: 1fr;
            }

            .security-row {
                grid-template-columns: 1fr;
            }

            .danger-grid {
                grid-template-columns: 1fr;
            }

            .settings-card {
                padding: 20px;
            }

            .danger-zone {
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
                <h4>Pengaturan Sistem</h4>
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
                                    style="display:flex;align-items:center;gap:10px;">
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
                <h4>Pengaturan Sistem</h4>
                <p>Kelola pengaturan aplikasi jadwal kuliah</p>
            </div>

            <form method="POST" action="{{ url('/admin/manage-settings/update') }}">
                @csrf

                <!-- Card 1: Informasi Sistem -->
                <div class="settings-card">
                    <div class="settings-card-title">
                        <i class="fas fa-cog"></i> Informasi Sistem
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group-custom">
                            <label>Tahun Akademik Default</label>
                            <input type="text" name="tahun_akademik" class="form-control-modern"
                                value="{{ $settings['tahun_akademik'] ?? '' }}" required>
                            <span class="form-hint">Contoh: 2023/2024 (Digunakan sebagai default untuk semester
                                baru)</span>
                        </div>
                        <div class="form-group-custom">
                            <label>Nama Institusi</label>
                            <input type="text" name="institusi_nama" class="form-control-modern"
                                value="{{ $settings['institusi_nama'] ?? '' }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label>Lokasi Institusi</label>
                            <input type="text" name="institusi_lokasi" class="form-control-modern"
                                value="{{ $settings['institusi_lokasi'] ?? '' }}">
                        </div>
                        <div class="form-group-custom">
                            <label>Program Studi</label>
                            <input type="text" name="program_studi" class="form-control-modern"
                                value="{{ $settings['program_studi'] ?? '' }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control-modern"
                                value="{{ $settings['jurusan'] ?? '' }}">
                        </div>
                        <div class="form-group-custom">
                            <label>Email Admin</label>
                            <input type="email" name="admin_email" class="form-control-modern"
                                value="{{ $settings['admin_email'] ?? '' }}">
                        </div>
                    </div>
                </div>

                <!-- Card 2: Header Configuration -->
                <div class="settings-card">
                    <div class="settings-card-title">
                        <i class="fas fa-header"></i> Header Halaman Utama
                    </div>
                    <div class="form-group-custom full" style="margin-bottom:20px;">
                        <label>Tipe Logo Header</label>
                        <select class="form-control-modern" name="header_logo_type">
                            <option value="kampus"
                                {{ ($settings['header_logo_type'] ?? 'kampus') == 'kampus' ? 'selected' : '' }}>
                                Logo Kampus
                            </option>
                            <option value="jurusan"
                                {{ ($settings['header_logo_type'] ?? '') == 'jurusan' ? 'selected' : '' }}>
                                Logo Jurusan
                            </option>
                            <option value="none"
                                {{ ($settings['header_logo_type'] ?? '') == 'none' ? 'selected' : '' }}>
                                Tanpa Logo
                            </option>
                        </select>
                        <span class="form-hint">Pilih logo yang akan ditampilkan di header halaman utama</span>
                    </div>

                    <div class="form-group-custom full" style="margin-bottom:20px;">
                        <label>Judul Header (Baris 1)</label>
                        <input type="text" name="header_title_1" class="form-control-modern"
                            value="{{ $settings['header_title_1'] ?? ($settings['institusi_nama'] ?? '') }}"
                            placeholder="Contoh: Politeknik Negeri Padang">
                        <span class="form-hint">Judul utama di header (default: Nama Institusi)</span>
                    </div>

                    <div class="form-group-custom full">
                        <label>Sub-Judul Header (Baris 2)</label>
                        <input type="text" name="header_title_2" class="form-control-modern"
                            value="{{ $settings['header_title_2'] ?? ($settings['institusi_lokasi'] ?? '') }}"
                            placeholder="Contoh: PSDKU Tanah Datar">
                        <span class="form-hint">Sub-judul di header (default: Lokasi Institusi)</span>
                    </div>
                </div>

                <!-- Card 3: Running Text -->
                <div class="settings-card">
                    <div class="settings-card-title">
                        <i class="fas fa-scroll"></i> Running Text / Marquee
                    </div>

                    <div class="form-group-custom full" style="margin-bottom:20px;">
                        <div class="toggle-wrap">
                            <label class="toggle-switch">
                                <input type="hidden" name="running_text_enabled" value="0">
                                <input type="checkbox" name="running_text_enabled" id="runningTextEnabled"
                                    value="1"
                                    {{ ($settings['running_text_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <div class="toggle-label-text">Aktifkan Running Text di Halaman Utama</div>
                                <small style="color:var(--nb-dark);font-size:0.75rem;">
                                    Jika diaktifkan, running text akan muncul di bawah filter dan di atas jadwal
                                    berlangsung
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-custom full" style="margin-bottom:20px;">
                        <label>Konten Running Text</label>
                        <textarea class="form-control-modern" id="runningTextContent" name="running_text_content" rows="3"
                            placeholder="Masukkan teks yang ingin ditampilkan sebagai running text...">{{ $settings['running_text_content'] ?? '' }}</textarea>
                        <span class="form-hint">Maksimal 500 karakter. Gunakan HTML untuk formatting sederhana</span>
                    </div>

                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div class="form-group-custom">
                            <label>Kecepatan Running Text</label>
                            <select class="form-control-modern" id="runningTextSpeed" name="running_text_speed">
                                <option value="slow"
                                    {{ ($settings['running_text_speed'] ?? 'normal') == 'slow' ? 'selected' : '' }}>
                                    Lambat</option>
                                <option value="normal"
                                    {{ ($settings['running_text_speed'] ?? 'normal') == 'normal' ? 'selected' : '' }}>
                                    Normal</option>
                                <option value="fast"
                                    {{ ($settings['running_text_speed'] ?? 'normal') == 'fast' ? 'selected' : '' }}>
                                    Cepat</option>
                            </select>
                            <span class="form-hint">Atur kecepatan animasi running text</span>
                        </div>
                        <div class="form-group-custom">
                            <label>&nbsp;</label>
                            <div
                                style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--nb-offwhite);border-radius:var(--nb-radius-sm);border:var(--nb-border);height:44px;box-shadow:var(--nb-shadow-sm);">
                                <i class="fas fa-tachometer-alt" style="color:var(--nb-purple);font-size:1rem;"></i>
                                <small style="font-weight:600;color:var(--nb-dark);font-size:0.8rem;">
                                    <strong>Tips:</strong> Gunakan kecepatan <strong>Normal</strong> untuk tampilan
                                    standar
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="color-picker-row" style="margin-bottom:20px;">
                        <div class="form-group-custom">
                            <label>Warna Teks</label>
                            <div class="color-input-wrap">
                                <input type="color" id="runningTextColor" name="running_text_color"
                                    value="{{ $settings['running_text_color'] ?? '#ffffff' }}">
                                <div class="color-label">
                                    {{ $settings['running_text_color'] ?? '#ffffff' }}
                                    <small>Warna teks running text</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label>Warna Latar</label>
                            <div class="color-input-wrap">
                                <input type="color" id="runningTextBgColor" name="running_text_bg_color"
                                    value="{{ $settings['running_text_bg_color'] ?? '#4361ee' }}">
                                <div class="color-label">
                                    {{ $settings['running_text_bg_color'] ?? '#4361ee' }}
                                    <small>Warna latar belakang running text</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="preview-box">
                        <div class="preview-box-title"><i class="fas fa-eye"></i> Preview Running Text</div>
                        <div id="runningTextPreview"
                            style="background-color: {{ $settings['running_text_bg_color'] ?? '#4361ee' }};color: {{ $settings['running_text_color'] ?? '#ffffff' }};">
                            <marquee behavior="scroll" direction="left" class="fw-semibold">
                                {{ $settings['running_text_content'] ?? 'Selamat datang di Sistem Informasi Jadwal Kuliah' }}
                            </marquee>
                        </div>
                        <small style="color:var(--nb-dark);font-size:0.75rem;margin-top:8px;display:block;">
                            Tampilan akan disesuaikan dengan preferensi di atas
                        </small>
                    </div>
                </div>

                <!-- Card 3: Pengaturan Keamanan -->
                <div class="settings-card">
                    <div class="settings-card-title">
                        <i class="fas fa-shield-alt"></i> Pengaturan Keamanan
                    </div>
                    <div class="security-row">
                        <div class="form-group-custom">
                            <label>Superadmin Registered</label>
                            <input type="text" name="superadmin_registered" class="form-control-modern"
                                value="{{ $settings['superadmin_registered'] ?? '0' }}" readonly
                                style="background:var(--nb-gray);color:var(--nb-dark);cursor:not-allowed;">
                            <span class="form-hint">Status registrasi superadmin (0 = belum, 1 = sudah)</span>
                        </div>
                        <div class="form-group-custom">
                            <label>Max Login Attempts</label>
                            <input type="number" name="max_login_attempts" class="form-control-modern"
                                value="{{ $settings['max_login_attempts'] ?? '5' }}" min="1" max="10">
                            <span class="form-hint">Jumlah maksimal percobaan login yang gagal</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Session Timeout Settings -->
                <div class="settings-card">
                    <div class="settings-card-title">
                        <i class="fas fa-clock"></i> Pengaturan Session & Timeout
                    </div>
                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div class="form-group-custom">
                            <label>Auto Logout Session</label>
                            <div class="toggle-wrap">
                                <label class="toggle-switch">
                                    <input type="hidden" name="session_auto_logout_enabled" value="0">
                                    <input type="checkbox" name="session_auto_logout_enabled"
                                        id="sessionAutoLogoutEnabled" value="1"
                                        {{ ($sessionAutoLogoutEnabled ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                                <div>
                                    <div class="toggle-label-text">Aktifkan Auto Logout</div>
                                    <small style="color:var(--nb-dark);font-size:0.75rem;">
                                        Logout otomatis jika tidak ada aktivitas
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label>Session Timeout (Menit)</label>
                            <input type="number" name="session_timeout_minutes" class="form-control-modern"
                                value="{{ $sessionTimeoutMinutes ?? 30 }}" min="5" max="120">
                            <span class="form-hint">Durasi tidak aktif sebelum auto logout (5-120 menit)</span>
                        </div>
                    </div>
                    <div class="form-group-custom full"
                        style="background:var(--nb-offwhite);padding:16px;border-radius:var(--nb-radius-sm);border:var(--nb-border);">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                            <i class="fas fa-info-circle" style="color:var(--nb-purple);"></i>
                            <small style="color:var(--nb-black);font-weight:600;">Cara Kerja Session Timeout:</small>
                        </div>
                        <ul style="font-size:0.8rem;color:var(--nb-dark);margin:0;padding-left:20px;line-height:1.6;">
                            <li>Setiap kali Anda bergerak atau klik di halaman, timer akan direset</li>
                            <li>Jika tidak ada aktivitas selama batas waktu, sistem akan logout otomatis</li>
                            <li>User akan diarahkan ke halaman login dengan pesan "Session Expired"</li>
                            <li>Log aktivitas otomatis akan tercatat di database</li>
                        </ul>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;margin-bottom:24px;">
                    <button type="submit" name="update_settings" class="btn-primary-solid">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>

            <!-- Card 5: Provider & Model AI - Import Jadwal AI (Hanya Superadmin) -->
            @if ($isSuperAdmin)
                <form method="POST" action="{{ url('/admin/manage-settings/ai-model') }}" class="settings-card">
                    @csrf
                    <div class="settings-card-title">
                        <i class="fas fa-wand-magic-sparkles"></i> Provider &amp; Model AI — Import Jadwal AI
                        <span
                            style="margin-left:auto;background:var(--nb-purple);color:var(--nb-white);border:2px solid var(--nb-black);border-radius:999px;padding:3px 10px;font-size:0.65rem;letter-spacing:0.5px;box-shadow:2px 2px 0 #000;">
                            SUPERADMIN ONLY
                        </span>
                    </div>

                    {{-- ==== MODEL: input bebas + deteksi otomatis tipe API ==== --}}
                    <div class="form-group-custom" style="margin-bottom:12px;">
                        <label>Model AI yang Dipakai</label>
                        <input type="text" name="ai_model" id="aiModelInput" class="form-control-modern"
                            list="aiModelDatalist" autocomplete="off" oninput="updateAiModelDetect()"
                            value="{{ $aiCatalog[$aiProvider]['model'] }}"
                            placeholder="ketik atau pilih, contoh: gemini-3.6-flash / gpt-4o / claude-sonnet-4">
                        <datalist id="aiModelDatalist">
                            @foreach ($aiCatalog as $catKey => $cat)
                                @foreach ($cat['models'] as $catModel)
                                    <option value="{{ $catModel['id'] }}">
                                        {{ $cat['label'] }} — {{ $catModel['note'] }} ({{ $catModel['free'] ? 'GRATIS' : 'Berbayar' }})
                                    </option>
                                @endforeach
                            @endforeach
                        </datalist>
                        <span class="form-hint">Cukup masukkan nama model — sistem <strong>otomatis mengenali tipe
                                API-nya</strong> (Gemini / OpenAI / Claude) dan langsung memakainya. Prefix "models/"
                            otomatis dibuang.</span>
                        <div id="aiModelDetectBox" style="margin-top:12px;"></div>
                    </div>

                    {{-- ==== PILIH CEPAT: chip model (GRATIS = hijau) ==== --}}
                    <div style="margin-bottom:20px;">
                        <small style="display:block;font-weight:700;color:var(--nb-black);margin-bottom:8px;">
                            <i class="fas fa-bolt" style="color:#B8860B;"></i> Pilih Cepat Model:
                        </small>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            @foreach ($aiCatalog as $catKey => $cat)
                                @foreach ($cat['models'] as $catModel)
                                    <button type="button" onclick="pickAiModel('{{ $catModel['id'] }}')"
                                        style="background:{{ $catModel['free'] ? '#EAF7EC' : 'var(--nb-offwhite)' }};border:2px solid var(--nb-black);border-radius:999px;padding:4px 12px;font-size:0.72rem;font-weight:700;font-family:var(--font-display);box-shadow:2px 2px 0 #000;cursor:pointer;">
                                        {{ $catModel['id'] }}
                                        @if ($catModel['free'])
                                            <span style="background:#2E7D32;color:#fff;border-radius:999px;padding:1px 7px;font-size:0.6rem;margin-left:4px;">GRATIS</span>
                                        @endif
                                    </button>
                                @endforeach
                            @endforeach
                        </div>
                        <small style="display:block;color:var(--nb-dark);font-size:0.72rem;margin-top:8px;line-height:1.6;">
                            <i class="fas fa-circle-check" style="color:#2E7D32;"></i> Bertanda <strong>GRATIS</strong> =
                            punya kuota gratis resmi dari provider (tanpa biaya) — cocok untuk testing &amp; operasional
                            ringan. Model tanpa tanda = berbayar sesuai tagihan provider.
                        </small>
                    </div>

                    <div
                        style="background:var(--nb-offwhite);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:16px;margin-bottom:20px;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                            <i class="fas fa-circle-info" style="color:var(--nb-purple);"></i>
                            <small style="color:var(--nb-black);font-weight:700;">Provider &amp; Model yang Sedang Aktif:</small>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            @foreach ($aiCatalog as $catKey => $cat)
                                <span
                                    style="background:{{ $aiProvider === $catKey ? 'var(--nb-purple)' : 'var(--nb-gray)' }};color:{{ $aiProvider === $catKey ? 'var(--nb-white)' : 'var(--nb-dark)' }};border:2px solid var(--nb-black);border-radius:999px;padding:5px 14px;font-weight:700;font-size:0.8rem;font-family:var(--font-display);box-shadow:2px 2px 0 #000;">
                                    {{ $cat['label'] }}: {{ $cat['model'] !== '' ? $cat['model'] : '(default sistem)' }}
                                    @if ($aiProvider === $catKey)
                                        ✓
                                    @endif
                                    <em style="font-style:normal;font-weight:600;opacity:0.85;">
                                        (Key: {{ $cat['api_key']['has_db'] ? 'Sistem' : 'belum ada' }})
                                    </em>
                                </span>
                            @endforeach
                        </div>
                        <small
                            style="display:block;color:var(--nb-dark);font-size:0.75rem;margin-top:10px;line-height:1.6;">
                            Jika model yang dipilih tidak tersedia di API provider (mis. sudah di-retire), sistem otomatis
                            mencoba fallback lalu menampilkan daftar model tersedia pada pesan error. Perubahan berlaku
                            langsung tanpa restart.
                        </small>
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn-primary-solid">
                            <i class="fas fa-save"></i> Simpan Model AI
                        </button>
                    </div>
                </form>

                <script>
                    var AI_CATALOG = @json($aiCatalog);

                    function aiDetectProvider(model) {
                        model = (model || '').toLowerCase().trim();
                        if (model === '') {
                            return null;
                        }

                        // 1) Cek katalog resmi per provider
                        for (var key in AI_CATALOG) {
                            if (!Object.prototype.hasOwnProperty.call(AI_CATALOG, key)) {
                                continue;
                            }
                            var models = AI_CATALOG[key].models || [];
                            for (var i = 0; i < models.length; i++) {
                                if (models[i].id.toLowerCase() === model) {
                                    return { label: AI_CATALOG[key].label, free: models[i].free, known: true };
                                }
                            }
                        }

                        // 2) Deteksi dari pola nama model (model custom / baru)
                        if (model.indexOf('gemini') !== -1) {
                            return { label: AI_CATALOG.gemini.label, free: null, known: false };
                        }
                        if (model.indexOf('gpt') !== -1 || model.indexOf('chatgpt') !== -1
                            || model.indexOf('openai') !== -1 || model.indexOf('davinci') !== -1
                            || /^o\d/.test(model)) {
                            return { label: AI_CATALOG.openai.label, free: null, known: false };
                        }
                        if (model.indexOf('claude') !== -1 || model.indexOf('anthropic') !== -1) {
                            return { label: AI_CATALOG.anthropic.label, free: null, known: false };
                        }

                        return null;
                    }

                    function updateAiModelDetect() {
                        var box = document.getElementById('aiModelDetectBox');
                        var input = document.getElementById('aiModelInput');
                        if (!box || !input) {
                            return;
                        }

                        var raw = input.value.trim();
                        if (raw === '') {
                            box.innerHTML = '';
                            return;
                        }

                        var detected = aiDetectProvider(raw);
                        if (!detected) {
                            box.innerHTML = '<div style="background:#FDECEC;border:2px solid var(--nb-red);'
                                + 'border-radius:var(--nb-radius-sm);padding:10px 14px;font-size:0.78rem;font-weight:700;color:#C0392B;">'
                                + '<i class="fas fa-triangle-exclamation me-1"></i>Tipe API "' + raw
                                + '" belum dikenali. Gunakan nama model resmi (gemini-*, gpt-*, claude-*).</div>';
                            return;
                        }

                        var freeBadge = '';
                        if (detected.free === true) {
                            freeBadge = '<span style="background:#EAF7EC;color:#2E7D32;border:2px solid #2E7D32;'
                                + 'border-radius:999px;padding:2px 10px;font-size:0.65rem;font-weight:700;">GRATIS</span>';
                        } else if (detected.free === false) {
                            freeBadge = '<span style="background:var(--nb-offwhite);color:var(--nb-dark);'
                                + 'border:2px solid var(--nb-gray);border-radius:999px;padding:2px 10px;font-size:0.65rem;font-weight:700;">Berbayar</span>';
                        }

                        box.innerHTML = '<div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;'
                            + 'background:var(--nb-offwhite);border:var(--nb-border);border-radius:var(--nb-radius-sm);'
                            + 'padding:10px 14px;font-size:0.78rem;color:var(--nb-black);">'
                            + '<i class="fas fa-wand-magic-sparkles" style="color:var(--nb-purple);"></i>'
                            + 'Tipe API terdeteksi: <strong style="font-family:var(--font-display);">' + detected.label + '</strong>'
                            + freeBadge
                            + '<span style="color:var(--nb-dark);">— otomatis dipakai saat disimpan ✓</span></div>';
                    }

                    function pickAiModel(id) {
                        var input = document.getElementById('aiModelInput');
                        if (!input) {
                            return;
                        }
                        input.value = id;
                        updateAiModelDetect();
                    }

                    // Sinkronkan tampilan awal
                    document.addEventListener('DOMContentLoaded', updateAiModelDetect);
                </script>

                {{-- Card 5b: API Key AI — dimasukkan langsung dari sistem, tersimpan terenkripsi di database --}}
                <div class="settings-card" style="margin-top:24px;">
                    <div class="settings-card-title">
                        <i class="fas fa-key"></i> API Key AI — Langsung dari Sistem
                        <span
                            style="margin-left:auto;background:var(--nb-orange);color:var(--nb-black);border:2px solid var(--nb-black);border-radius:999px;padding:3px 10px;font-size:0.65rem;letter-spacing:0.5px;box-shadow:2px 2px 0 #000;">
                            SUPERADMIN ONLY
                        </span>
                    </div>

                    <div
                        style="background:var(--nb-offwhite);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:12px 16px;margin-bottom:18px;font-size:0.78rem;color:var(--nb-black);line-height:1.7;">
                        <i class="fas fa-shield-halved" style="color:var(--nb-purple);"></i>
                        API key disimpan <strong>terenkripsi</strong> di database dan <strong>langsung dipakai
                        sistem</strong> tanpa restart. Database adalah <strong>satu-satunya sumber</strong> API key AI —
                        konfigurasi AI di file .env sudah tidak dipakai lagi (key lama sudah dimigrasi ke sini).
                    </div>

                    @foreach ($aiCatalog as $catKey => $cat)
                        <form method="POST" action="{{ url('/admin/manage-settings/ai-api-key') }}"
                            style="border:2px dashed var(--nb-gray);border-radius:var(--nb-radius-sm);padding:16px;margin-bottom:14px;">
                            @csrf
                            <input type="hidden" name="ai_key_provider" value="{{ $catKey }}">
                            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px;">
                                <strong style="font-family:var(--font-display);">
                                    <i class="fas {{ $cat['icon'] }} me-1"></i> {{ $cat['label'] }}
                                </strong>
                                @if ($cat['api_key']['has_db'])
                                    <span
                                        style="background:#EAF7EC;color:#2E7D32;border:2px solid #2E7D32;border-radius:999px;padding:2px 10px;font-size:0.65rem;font-weight:700;">
                                        TERSIMPAN DI SISTEM ({{ $cat['api_key']['masked'] }})
                                    </span>
                                @else
                                    <span
                                        style="background:#FDECEC;color:#C0392B;border:2px solid var(--nb-red);border-radius:999px;padding:2px 10px;font-size:0.65rem;font-weight:700;">
                                        BELUM ADA
                                    </span>
                                @endif
                            </div>
                            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:stretch;">
                                <div style="flex:1;min-width:220px;">
                                    <input type="password" name="ai_api_key" class="form-control-modern"
                                        placeholder="Tempel API key {{ $cat['label'] }} di sini..."
                                        autocomplete="new-password">
                                </div>
                                <button type="submit" class="btn-primary-solid" style="padding:10px 18px;">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                @if ($cat['api_key']['has_db'])
                                    <button type="submit" name="action" value="delete"
                                        style="background:#FDECEC;color:#C0392B;border:2px solid #C0392B;border-radius:var(--nb-radius-sm);padding:10px 16px;font-weight:700;font-family:var(--font-display);box-shadow:2px 2px 0 #000;cursor:pointer;"
                                        onclick="return confirm('Hapus API key {{ $cat['label'] }} dari sistem? Key tidak dapat dipulihkan setelah dihapus.');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                @endif
                            </div>
                        </form>
                    @endforeach
                </div>
            @else
                <div class="settings-card" style="margin-top:24px;">
                    <div class="settings-card-title">
                        <i class="fas fa-wand-magic-sparkles"></i> Provider &amp; Model AI — Import Jadwal AI
                    </div>
                    <div
                        style="background:var(--nb-gray);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:16px;">
                        <p style="font-size:0.85rem;color:var(--nb-dark);margin:0;">
                            <i class="fas fa-lock me-1"></i>
                            Pengaturan provider &amp; model AI hanya dapat diakses oleh <strong>Superadmin</strong>. Silakan
                            hubungi Superadmin untuk mengubah provider yang dipakai fitur Import Jadwal AI.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Card 6: Limit Penggunaan AI (Hanya Superadmin) -->
            @if ($isSuperAdmin)
                <div class="settings-card" style="margin-top:24px;">
                    <div class="settings-card-title">
                        <i class="fas fa-gauge-high"></i> Limit Penggunaan AI — Import Jadwal AI
                        <span
                            style="margin-left:auto;background:var(--nb-orange);color:var(--nb-black);border:2px solid var(--nb-black);border-radius:999px;padding:3px 10px;font-size:0.65rem;letter-spacing:0.5px;box-shadow:2px 2px 0 #000;">
                            SUPERADMIN ONLY
                        </span>
                    </div>
                    <small
                        style="display:block;color:var(--nb-dark);font-size:0.75rem;margin-bottom:14px;line-height:1.6;">
                        Limit &amp; counter disimpan <strong>per provider</strong> pada tabel <strong>ai_api_configs</strong> —
                        pengaturan di bawah berlaku untuk provider yang sedang aktif
                        (<strong>{{ \App\Models\AiApiConfig::activeProviderKey() }}</strong>).
                    </small>

                    {{-- Statistik pemakaian saat ini --}}
                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;">
                        <div
                            style="flex:1;min-width:140px;background:var(--nb-offwhite);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:14px;text-align:center;">
                            <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;">
                                {{ $aiUsage['used'] }}</div>
                            <small style="color:var(--nb-dark);font-weight:600;">Scan Terpakai</small>
                        </div>
                        <div
                            style="flex:1;min-width:140px;background:var(--nb-offwhite);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:14px;text-align:center;">
                            <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;">
                                {{ $aiUsage['limit'] > 0 ? $aiUsage['limit'] : '∞' }}</div>
                            <small style="color:var(--nb-dark);font-weight:600;">Batas ({{ $aiUsage['period_label'] }})</small>
                        </div>
                        <div
                            style="flex:1;min-width:140px;background:{{ $aiUsage['limit_reached'] ? '#FDECEC' : 'var(--nb-offwhite)' }};border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:14px;text-align:center;">
                            <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;">
                                {{ $aiUsage['remaining'] === null ? '∞' : $aiUsage['remaining'] }}</div>
                            <small style="color:var(--nb-dark);font-weight:600;">Sisa Kuota</small>
                        </div>
                    </div>

                    @if ($aiUsage['limit_reached'])
                        <div
                            style="background:#FDECEC;border:2px solid var(--nb-red);border-radius:var(--nb-radius-sm);padding:12px 16px;margin-bottom:16px;color:#C0392B;font-weight:700;font-size:0.82rem;">
                            <i class="fas fa-triangle-exclamation me-1"></i>
                            Limit penggunaan AI telah tercapai! Pengguna tidak dapat melakukan Import Jadwal AI sampai direset
                            atau periode berikutnya.
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/admin/manage-settings/ai-usage') }}">
                        @csrf
                        <div class="form-grid-2" style="margin-bottom:20px;">
                            <div class="form-group-custom">
                                <label>Batas Scan (per Periode)</label>
                                <input type="number" name="ai_usage_limit" class="form-control-modern" min="0"
                                    max="1000000" value="{{ $aiUsage['limit'] }}">
                                <span class="form-hint">0 = tanpa batas (unlimited)</span>
                            </div>
                            <div class="form-group-custom">
                                <label>Periode</label>
                                <select name="ai_usage_period" class="form-control-modern">
                                    <option value="daily" {{ $aiUsage['period'] === 'daily' ? 'selected' : '' }}>Harian</option>
                                    <option value="monthly" {{ $aiUsage['period'] === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="total" {{ $aiUsage['period'] === 'total' ? 'selected' : '' }}>Total (selamanya)</option>
                                </select>
                                <span class="form-hint">Counter otomatis direset saat periode berganti (hari/bulan baru)</span>
                            </div>
                        </div>
                        <div style="display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;">
                            <button type="submit" class="btn-primary-solid">
                                <i class="fas fa-save"></i> Simpan Limit
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ url('/admin/manage-settings/ai-usage-reset') }}"
                        onsubmit="return confirm('Yakin reset seluruh penggunaan AI?')">
                        @csrf
                        <div style="display:flex;justify-content:flex-end;margin-top:10px;">
                            <button type="submit" class="btn-destructive-outline">
                                <i class="fas fa-rotate-left"></i> Reset Penggunaan AI
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Danger Zone -->
            @if ($isSuperAdmin)
                <div class="danger-zone">
                    <div class="danger-zone-title">
                        <i class="fas fa-exclamation-triangle"></i> Zona Berbahaya (Hanya Superadmin)
                    </div>
                    <p
                        style="font-size:0.85rem;color:var(--nb-white);margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-info-circle"></i> Hati-hati! Aksi di bawah ini tidak dapat dibatalkan.
                    </p>
                    <div class="danger-grid">
                        <a href="{{ url('/admin/manage-settings/reset-data') }}" class="btn-destructive-outline"
                            onclick="return confirm('Yakin reset semua data jadwal? Semua jadwal akan terhapus!')">
                            <i class="fas fa-redo"></i> Reset Data Jadwal
                        </a>
                        <a href="{{ url('/admin/manage-settings/backup-database') }}"
                            class="btn-destructive-outline">
                            <i class="fas fa-database"></i> Backup Database
                        </a>
                        <a href="{{ url('/admin/manage-settings/clear-logs') }}" class="btn-destructive-outline"
                            onclick="return confirm('Yakin hapus semua log aktivitas?')">
                            <i class="fas fa-trash-alt"></i> Hapus Log Aktivitas
                        </a>
                        <a href="{{ url('/admin/manage-settings/clear-cache') }}" class="btn-destructive-outline"
                            onclick="return confirm('Yakin hapus semua cache sistem?')">
                            <i class="fas fa-broom"></i> Clear Cache
                        </a>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <a href="{{ url('/admin/backup-history') }}" class="btn-primary-solid">
                        <i class="fas fa-history"></i> Lihat Riwayat Backup
                    </a>
                </div>
            @else
                <div
                    style="background:var(--nb-gray);border:var(--nb-border);border-radius:var(--nb-radius);padding:24px;margin-bottom:24px;box-shadow:var(--nb-shadow-sm);">
                    <h6
                        style="font-size:0.9rem;font-weight:700;color:var(--nb-black);margin-bottom:6px;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-lock" style="color:var(--nb-dark);"></i> Akses Terbatas
                    </h6>
                    <p style="font-size:0.85rem;color:var(--nb-dark);margin-bottom:0;">
                        <i class="fas fa-info-circle me-1"></i>
                        Fitur zona berbahaya hanya dapat diakses oleh Superadmin. Hubungi Superadmin untuk aksi-aksi
                        seperti reset data, backup database, atau hapus log.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Real-time preview for running text
        document.addEventListener('DOMContentLoaded', function() {
            const enabledCheckbox = document.getElementById('runningTextEnabled');
            const contentTextarea = document.getElementById('runningTextContent');
            const speedSelect = document.getElementById('runningTextSpeed');
            const colorPicker = document.getElementById('runningTextColor');
            const bgColorPicker = document.getElementById('runningTextBgColor');
            const previewElement = document.getElementById('runningTextPreview');

            function updatePreview() {
                const content = contentTextarea.value || 'Teks contoh untuk preview...';
                const bgColor = bgColorPicker.value;
                const textColor = colorPicker.value;
                const speed = speedSelect.value;

                previewElement.style.backgroundColor = bgColor;
                previewElement.style.color = textColor;

                const marquee = previewElement.querySelector('marquee');
                if (marquee) {
                    marquee.innerHTML = content;
                    switch (speed) {
                        case 'slow':
                            marquee.style.animationDuration = '30s';
                            break;
                        case 'normal':
                            marquee.style.animationDuration = '20s';
                            break;
                        case 'fast':
                            marquee.style.animationDuration = '10s';
                            break;
                    }
                }
            }

            [contentTextarea, speedSelect, colorPicker, bgColorPicker].forEach(el => {
                el.addEventListener('input', updatePreview);
                el.addEventListener('change', updatePreview);
            });

            updatePreview();

            // Auto-hide notifications
            setTimeout(function() {
                const c = document.getElementById('notification-container');
                if (c) {
                    c.style.transition = 'opacity 0.5s ease';
                    c.style.opacity = '0';
                    setTimeout(() => {
                        c.style.display = 'none';
                    }, 500);
                }
            }, 5000);
        });
    </script>
</body>

</html>
