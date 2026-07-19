<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h3><i class="fas fa-calendar-alt"></i> Admin Panel</h3>
    </div>

    <div class="sidebar-profile">
        <div class="sidebar-avatar" id="sidebarAvatar">
            @php
                $sidebarUserFoto = session('user_foto');
            @endphp
            @if ($sidebarUserFoto)
                <img src="{{ $sidebarUserFoto }}" alt="Foto"
                    style="width:100%;height:100%;object-fit:cover;border-radius:6px;">
            @else
                {{ strtoupper(substr(session('username'), 0, 1)) }}
            @endif
        </div>
        <div class="sidebar-profile-info">
            <h6>{{ session('username') }}</h6>
            <small>{{ ucfirst(session('role')) }}</small>
        </div>
    </div>

    @if (!$superadminVerified)
        <div class="sidebar-verification-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="sidebar-verification-text">
                <strong>Email Belum Terverifikasi</strong>
                <small>Verifikasi email Anda untuk mengakses semua fitur</small>
            </div>
            <a href="{{ url('/admin/profile') }}" class="btn-verify-now">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
    @endif

    <nav class="sidebar-nav">
        <span class="nav-section-label">Menu Utama</span>
        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->is('admin/manage-schedule') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/manage-schedule') }}">
            <i class="fas fa-calendar"></i> Kelola Jadwal
        </a>
        <a class="nav-link {{ request()->is('admin/manage-rooms') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/manage-rooms') }}">
            <i class="fas fa-door-open"></i> Kelola Ruangan
        </a>
        <a class="nav-link {{ request()->is('admin/manage-semester') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/manage-semester') }}">
            <i class="fas fa-calendar-alt"></i> Kelola Semester
        </a>

        <span class="nav-section-label">Pengaturan</span>
        <a class="nav-link {{ request()->is('admin/manage-settings') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/manage-settings') }}">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
        <a class="nav-link {{ request()->is('admin/manage-users') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/manage-users') }}">
            <i class="fas fa-users"></i> Kelola Admin
        </a>
        <a class="nav-link {{ request()->is('admin/saran') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ url('/admin/saran') }}">
            <i class="fas fa-comments"></i> Kritik & Saran
        </a>
        <a class="nav-link {{ request()->is('admin/maintenance') ? 'active' : '' }} {{ !$superadminVerified ? 'disabled-link' : '' }}"
            href="{{ !$superadminVerified ? '#' : url('/admin/maintenance') }}">
            <i class="fas fa-tools"></i> Maintenance
        </a>
    </nav>

    <div class="sidebar-footer">
        <a class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}" href="{{ url('/admin/profile') }}">
            <i class="fas fa-user"></i> Profile
        </a>
        <form action="{{ url('/logout') }}" method="POST" style="display:block; margin:0;">
            @csrf
            <button type="submit" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

</aside>

<style>
    :root {
        --nb-black: #000000;
        --nb-white: #FFFFFF;
        --nb-yellow: #FFE66D;
        --nb-teal: #4ECDC4;
        --nb-purple: #A66CFF;
        --nb-green: #95E1D3;
        --nb-orange: #FFB347;
        --nb-red: #FF6B6B;
        --nb-blue: #6BB5FF;
        --nb-pink: #F38181;
        --nb-gray: #E8E8E8;
        --nb-offwhite: #F8F7F4;
        --nb-dark: #1A1A2E;
        --nb-border: 3px solid #000;
        --nb-border-thick: 4px solid #000;
        --nb-shadow: 6px 6px 0px #000;
        --nb-shadow-sm: 4px 4px 0px #000;
        --nb-shadow-hover: 10px 10px 0px #000;
        --nb-radius: 12px;
        --nb-radius-sm: 8px;
        --font-display: 'Space Grotesk', sans-serif;
        --font-body: 'Inter', sans-serif;
    }

    .sidebar {
        background: var(--nb-dark);
        color: var(--nb-white);
        min-height: 100vh;
        position: fixed;
        width: 260px;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        border-right: var(--nb-border-thick);
        box-shadow: var(--nb-shadow-lg);
    }

    .sidebar-brand {
        padding: 24px 24px 20px;
        border-bottom: var(--nb-border);
        flex-shrink: 0;
        background: var(--nb-purple);
    }

    .sidebar-brand h3 {
        font-family: var(--font-display);
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: -0.3px;
        color: var(--nb-black);
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
    }

    .sidebar-brand h3 i {
        color: var(--nb-yellow);
        font-size: 1.1rem;
    }

    .sidebar-profile {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: var(--nb-border);
        flex-shrink: 0;
        background: var(--nb-dark);
    }

    .sidebar-avatar {
        width: 40px;
        height: 40px;
        background: var(--nb-yellow);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--nb-black);
        flex-shrink: 0;
        box-shadow: var(--nb-shadow-sm);
        overflow: hidden;
    }

    .sidebar-profile-info h6 {
        color: var(--nb-white);
        font-family: var(--font-display);
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .sidebar-profile-info small {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        font-weight: 500;
    }

    .sidebar-nav {
        padding: 12px 12px;
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--nb-yellow) transparent;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: var(--nb-yellow);
        border-radius: 3px;
        border: 1px solid var(--nb-black);
    }

    .nav-section-label {
        font-family: var(--font-display);
        font-size: 0.68rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px 12px 8px;
        display: block;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        margin: 3px 0;
        border-radius: var(--nb-radius-sm);
        color: rgba(255, 255, 255, 0.75);
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
        border: 2px solid transparent;
        box-shadow: var(--nb-shadow-sm);
        background: var(--nb-dark);
    }

    .sidebar-nav .nav-link:hover {
        background: var(--nb-yellow);
        color: var(--nb-black);
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
        border-color: var(--nb-black);
    }

    .sidebar-nav .nav-link.active {
        background: var(--nb-teal);
        color: var(--nb-black);
        box-shadow: var(--nb-shadow);
        border-color: var(--nb-black);
    }

    .sidebar-nav .nav-link i {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .sidebar-footer {
        padding: 12px 12px 20px;
        border-top: var(--nb-border);
        flex-shrink: 0;
        background: var(--nb-dark);
    }

    .sidebar-footer .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: var(--nb-radius-sm);
        color: rgba(255, 255, 255, 0.75);
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
        background: var(--nb-dark);
        border: 2px solid transparent;
        box-shadow: var(--nb-shadow-sm);
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .sidebar-footer .nav-link:hover {
        background: var(--nb-red);
        color: var(--nb-white);
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
        border-color: var(--nb-black);
    }

    .sidebar-footer .nav-link i {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    /* Verification Warning */
    .sidebar-verification-warning {
        background: var(--nb-orange);
        border-left: var(--nb-border);
        border-right: var(--nb-border);
        border-bottom: var(--nb-border);
        margin: 8px 12px;
        padding: 12px;
        border-radius: var(--nb-radius-sm);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        box-shadow: var(--nb-shadow-sm);
    }

    .sidebar-verification-warning>i:first-child {
        color: var(--nb-black);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .sidebar-verification-text {
        flex: 1;
        min-width: 0;
    }

    .sidebar-verification-text strong {
        display: block;
        font-family: var(--font-display);
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--nb-black);
        line-height: 1.3;
    }

    .sidebar-verification-text small {
        display: block;
        font-size: 0.65rem;
        color: var(--nb-black);
        opacity: 0.8;
        line-height: 1.3;
        margin-top: 2px;
        font-weight: 600;
    }

    .btn-verify-now {
        width: 28px;
        height: 28px;
        border-radius: var(--nb-radius-sm);
        background: var(--nb-white);
        border: var(--nb-border);
        color: var(--nb-black);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        flex-shrink: 0;
        transition: all 0.15s ease;
        font-size: 0.75rem;
        box-shadow: var(--nb-shadow-sm);
    }

    .btn-verify-now:hover {
        background: var(--nb-yellow);
        transform: translate(-1px, -1px);
        box-shadow: var(--nb-shadow);
    }

    /* Disabled Link */
    .sidebar-nav .nav-link.disabled-link {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .sidebar-nav .nav-link.disabled-link:hover {
        background: var(--nb-dark);
        color: rgba(255, 255, 255, 0.65);
        transform: none;
        box-shadow: var(--nb-shadow-sm);
        border-color: transparent;
    }
</style>

<script>
    // Session Timeout & Activity Monitor
    (function() {
        const SESSION_TIMEOUT_MINUTES = {{ $sessionTimeoutMinutes ?? 30 }};
        const SESSION_AUTO_LOGOUT_ENABLED = {{ $sessionAutoLogoutEnabled ?? '1' }} === '1';
        const WARNING_BEFORE_LOGOUT = 60;
        let timeoutWarningShown = false;
        let logoutTimer;
        let warningTimer;

        function resetSessionTimer() {
            if (!SESSION_AUTO_LOGOUT_ENABLED) return;
            clearTimeout(logoutTimer);
            clearTimeout(warningTimer);
            timeoutWarningShown = false;

            const timeoutMs = SESSION_TIMEOUT_MINUTES * 60 * 1000;
            const warningMs = timeoutMs - (WARNING_BEFORE_LOGOUT * 1000);

            warningTimer = setTimeout(showTimeoutWarning, warningMs);
            logoutTimer = setTimeout(autoLogout, timeoutMs);
        }

        function showTimeoutWarning() {
            if (timeoutWarningShown) return;
            timeoutWarningShown = true;

            const minutes = Math.floor(WARNING_BEFORE_LOGOUT / 60);
            const seconds = WARNING_BEFORE_LOGOUT % 60;

            if (confirm('Session akan berakhir dalam ' + minutes + ':' + (seconds < 10 ? '0' : '') + seconds +
                    '.\nKlik OK untuk melanjutkan session, atau Cancel untuk logout sekarang.')) {
                resetSessionTimer();
            }
        }

        function autoLogout() {
            alert('Session telah berakhir karena tidak ada aktivitas. Anda akan diarahkan ke halaman login.');
            window.location.href = '/login?expired=1';
        }

        const activityEvents = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];

        activityEvents.forEach(function(event) {
            document.addEventListener(event, function(e) {
                if (e.target.closest('.modal') || e.target.closest('.dropdown-menu') || e.target
                    .closest('select')) {
                    return;
                }
                resetSessionTimer();
            }, {
                passive: true
            });
        });

        if (SESSION_AUTO_LOGOUT_ENABLED) {
            resetSessionTimer();
        }
    })();
</script>
