<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --canvas-bg: #f1f5f9;
            --card-bg: #ffffff;
            --card-radius: 16px;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.05);
            --card-shadow-hover: 0 4px 16px rgba(0, 0, 0, 0.08);
            --corporate-blue: #1d4ed8;
            --corporate-blue-hover: #1e3a8a;
            --zinc-900: #18181b;
            --zinc-800: #27272a;
            --zinc-700: #3f3f46;
            --zinc-600: #52525b;
            --zinc-500: #71717a;
            --zinc-400: #a1a1aa;
            --zinc-300: #d4d4d8;
            --zinc-200: #e4e4e7;
            --zinc-100: #f4f4f5;
            --zinc-50: #fafafa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--canvas-bg);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
        }

        /* Top Bar */
        .top-bar {
            background: var(--card-bg);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--zinc-100);
            position: sticky;
            top: 0;
            z-index: 500;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-bar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--zinc-600);
            cursor: pointer;
            padding: 4px;
        }

        .top-bar-left h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 0;
            letter-spacing: -0.3px;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .top-bar-date {
            font-size: 0.85rem;
            color: var(--zinc-500);
            font-weight: 500;
        }

        .top-bar-right .dropdown-toggle {
            background: var(--zinc-50);
            border: 1px solid var(--zinc-200);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--zinc-700);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .top-bar-right .dropdown-toggle:hover {
            background: var(--zinc-100);
            border-color: var(--zinc-300);
        }

        .top-bar-right .dropdown-toggle::after {
            display: none;
        }

        .top-bar-right .dropdown-menu {
            border-radius: 12px;
            border: 1px solid var(--zinc-200);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 6px;
            min-width: 180px;
        }

        .top-bar-right .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            color: var(--zinc-700);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar-right .dropdown-item:hover {
            background: var(--zinc-50);
        }

        .top-bar-right .dropdown-item.text-danger:hover {
            background: #fef2f2;
        }

        .top-bar-right .dropdown-divider {
            margin: 4px 0;
            border-color: var(--zinc-100);
        }

        .content-wrapper {
            padding: 28px 32px;
            max-width: 960px;
        }

        .page-title-section {
            margin-bottom: 28px;
        }

        .page-title-section h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .page-title-section p {
            font-size: 0.88rem;
            color: var(--zinc-500);
            margin-bottom: 0;
        }

        /* Settings Cards */
        .settings-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 28px 32px;
            margin-bottom: 24px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .settings-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--zinc-800);
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 20px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--zinc-100);
        }

        .settings-card-title i {
            color: var(--zinc-400);
            font-size: 0.95rem;
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
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--zinc-700);
        }

        .form-control-modern {
            padding: 10px 14px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 10px;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            color: var(--zinc-700);
            background: var(--card-bg);
            outline: none;
            transition: all 0.15s ease;
            width: 100%;
        }

        .form-control-modern:focus {
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .form-control-modern::placeholder {
            color: var(--zinc-400);
        }

        select.form-control-modern {
            appearance: auto;
        }

        textarea.form-control-modern {
            resize: vertical;
        }

        .form-hint {
            font-size: 0.75rem;
            color: var(--zinc-400);
            margin-top: 2px;
        }

        /* iOS Toggle */
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
            background: var(--zinc-300);
            border-radius: 28px;
            transition: all 0.3s ease;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }

        .toggle-switch input:checked+.toggle-slider {
            background: var(--corporate-blue);
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(20px);
        }

        .toggle-label-text {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--zinc-700);
        }

        /* Color Picker Row */
        .color-picker-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .color-input-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-input-wrap input[type="color"] {
            width: 48px;
            height: 48px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 10px;
            cursor: pointer;
            padding: 3px;
            background: var(--card-bg);
            flex-shrink: 0;
        }

        .color-input-wrap input[type="color"]:hover {
            border-color: var(--zinc-300);
        }

        .color-input-wrap .color-label {
            font-size: 0.82rem;
            color: var(--zinc-600);
        }

        .color-input-wrap .color-label small {
            color: var(--zinc-400);
            display: block;
            font-size: 0.75rem;
        }

        /* Preview Box */
        .preview-box {
            border: 2px dashed var(--zinc-300);
            border-radius: 12px;
            padding: 20px;
            background: var(--zinc-50);
            margin-top: 8px;
        }

        .preview-box-title {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--zinc-400);
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
            border-radius: 10px;
            padding: 12px 16px;
            overflow: hidden;
        }

        #runningTextPreview marquee {
            width: 100%;
            font-weight: 600;
        }

        /* Security Row */
        .security-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Danger Zone */
        .danger-zone {
            background: #fff1f2;
            border: 1px solid #fecaca;
            border-radius: var(--card-radius);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        .danger-zone-title {
            font-size: 1rem;
            font-weight: 700;
            color: #b91c1c;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: 1px solid #fecaca;
        }

        .danger-zone-title i {
            color: #fca5a5;
        }

        .danger-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .btn-destructive-outline {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border: 1.5px solid #fca5a5;
            background: var(--card-bg);
            color: #b91c1c;
            width: 100%;
        }

        .btn-destructive-outline:hover {
            background: #fef2f2;
            border-color: #f87171;
        }

        /* Primary Button */
        .btn-primary-solid {
            padding: 10px 28px;
            background: var(--corporate-blue);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary-solid:hover {
            background: var(--corporate-blue-hover);
            color: white;
        }

        /* Alert flash */
        .alert-flash {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
        }

        .alert-flash.success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-flash.error {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-flash.info {
            background: #eff6ff;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
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
    <div id="notification-container">
        @if (session('success'))
            <div class="alert-flash success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-flash error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if (session('info'))
            <div class="alert-flash info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
        @endif
    </div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <h4>Pengaturan Sistem</h4>
            </div>
            <div class="top-bar-right">
                <span class="top-bar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> {{ session('username') }}
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
                            <input type="text" name="fakultas" class="form-control-modern"
                                value="{{ $settings['fakultas'] ?? '' }}">
                        </div>
                        <div class="form-group-custom">
                            <label>Email Admin</label>
                            <input type="email" name="admin_email" class="form-control-modern"
                                value="{{ $settings['admin_email'] ?? '' }}">
                        </div>
                    </div>
                </div>

                <!-- Card 2: Running Text -->
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
                                <small style="color:var(--zinc-400);font-size:0.75rem;">
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
                        <div></div>
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
                            style="background-color: {{ $settings['running_text_bg_color'] ?? '#4361ee' }};
                                   color: {{ $settings['running_text_color'] ?? '#ffffff' }};">
                            <marquee behavior="scroll" direction="left" class="fw-semibold">
                                {{ $settings['running_text_content'] ?? 'Selamat datang di Sistem Informasi Jadwal Kuliah' }}
                            </marquee>
                        </div>
                        <small style="color:var(--zinc-400);font-size:0.75rem;margin-top:8px;display:block;">
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
                                style="background:var(--zinc-50);color:var(--zinc-500);">
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

                <div style="display:flex;justify-content:flex-end;margin-bottom:24px;">
                    <button type="submit" name="update_settings" class="btn-primary-solid">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>

            <!-- Danger Zone -->
            @if ($isSuperAdmin)
                <div class="danger-zone">
                    <div class="danger-zone-title">
                        <i class="fas fa-exclamation-triangle"></i> Zona Berbahaya (Hanya Superadmin)
                    </div>
                    <p
                        style="font-size:0.85rem;color:#991b1b;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
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
                    </div>
                </div>
            @else
                <div
                    style="background:var(--zinc-50);border:1px solid var(--zinc-200);border-radius:var(--card-radius);padding:24px;margin-bottom:24px;">
                    <h6
                        style="font-size:0.9rem;font-weight:600;color:var(--zinc-600);margin-bottom:6px;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-lock" style="color:var(--zinc-400);"></i> Akses Terbatas
                    </h6>
                    <p style="font-size:0.85rem;color:var(--zinc-500);margin-bottom:0;">
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
