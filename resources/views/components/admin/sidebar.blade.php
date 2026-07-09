<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h3><i class="fas fa-calendar-alt"></i> Admin Panel</h3>
    </div>

    <div class="sidebar-profile">
        <div class="sidebar-avatar">
            {{ strtoupper(substr(session('username'), 0, 1)) }}
        </div>
        <div class="sidebar-profile-info">
            <h6>{{ session('username') }}</h6>
            <small>{{ ucfirst(session('role')) }}</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <span class="nav-section-label">Menu Utama</span>
        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->is('admin/manage-schedule') ? 'active' : '' }}"
            href="{{ url('/admin/manage-schedule') }}">
            <i class="fas fa-calendar"></i> Kelola Jadwal
        </a>
        <a class="nav-link {{ request()->is('admin/manage-rooms') ? 'active' : '' }}"
            href="{{ url('/admin/manage-rooms') }}">
            <i class="fas fa-door-open"></i> Kelola Ruangan
        </a>
        <a class="nav-link {{ request()->is('admin/manage-semester') ? 'active' : '' }}"
            href="{{ url('/admin/manage-semester') }}">
            <i class="fas fa-calendar-alt"></i> Kelola Semester
        </a>

        <span class="nav-section-label">Pengaturan</span>
        <a class="nav-link {{ request()->is('admin/manage-settings') ? 'active' : '' }}"
            href="{{ url('/admin/manage-settings') }}">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
        <a class="nav-link {{ request()->is('admin/manage-users') ? 'active' : '' }}"
            href="{{ url('/admin/manage-users') }}">
            <i class="fas fa-users"></i> Kelola Admin
        </a>
        <a class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}" href="{{ url('/admin/reports') }}">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>
        <a class="nav-link {{ request()->is('admin/saran') ? 'active' : '' }}" href="{{ url('/admin/saran') }}">
            <i class="fas fa-comments"></i> Kritik & Saran
        </a>
        <a class="nav-link {{ request()->is('admin/maintenance') ? 'active' : '' }}"
            href="{{ url('/admin/maintenance') }}">
            <i class="fas fa-tools"></i> Maintenance
        </a>
    </nav>

    <div class="sidebar-footer">
        <a class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}" href="{{ url('/admin/profile') }}">
            <i class="fas fa-user"></i> Profile
        </a>
        <form action="{{ url('/logout') }}" method="POST" style="display:block;">
            @csrf
            <button type="submit" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

</aside>

<style>
    .sidebar {
        background: #0f172a;
        color: white;
        min-height: 100vh;
        position: fixed;
        width: 260px;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .sidebar-brand {
        padding: 24px 24px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }

    .sidebar-brand h3 {
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: -0.3px;
        color: white;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-brand h3 i {
        color: #60a5fa;
        font-size: 1.1rem;
    }

    .sidebar-profile {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }

    .sidebar-avatar {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: white;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .sidebar-profile-info h6 {
        color: white;
        font-size: 0.88rem;
        font-weight: 600;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .sidebar-profile-info small {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
        font-weight: 400;
    }

    .sidebar-nav {
        padding: 12px 12px;
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
    }

    .nav-section-label {
        font-size: 0.68rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.25);
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px 12px 8px;
        display: block;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        margin: 2px 0;
        border-radius: 10px;
        color: rgba(255, 255, 255, 0.65);
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .sidebar-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: white;
    }

    .sidebar-nav .nav-link.active {
        background: rgba(255, 255, 255, 0.12);
        color: white;
    }

    .sidebar-nav .nav-link i {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .sidebar-footer {
        padding: 12px 12px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }

    .sidebar-footer .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 10px;
        color: rgba(255, 255, 255, 0.65);
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.15s ease;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .sidebar-footer .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: white;
    }

    .sidebar-footer .nav-link i {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
</style>
