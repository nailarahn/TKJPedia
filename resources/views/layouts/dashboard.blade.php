<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Mappy Path</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    
    <style>
        :root {
            --primary: #372466;
            --primary-light: #4e35a0;
            --primary-dark: #251848;
            --accent: #7c5cbf;
            --accent-light: #a78bd4;
            --accent-glow: rgba(55, 36, 102, 0.2);
            --sidebar-bg: #f4f1ff;
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --white: #ffffff;
            --gray-50: #fafafa;
            --gray-100: #f4f1ff;
            --gray-200: #e4e0f5;
            --gray-300: #c8bfe8;
            --gray-400: #9589b8;
            --gray-500: #6d5f9a;
            --gray-600: #4e4275;
            --gray-700: #332a5c;
            --gray-800: #1e1640;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --font: 'Poppins', sans-serif;
            --radius: 14px;
            --shadow: 0 4px 20px rgba(55,36,102,0.08);
            --shadow-lg: 0 10px 40px rgba(55,36,102,0.15);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font);
            background: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 3px; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 20px rgba(55,36,102,0.05);
        }

        .sidebar-logo {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .logo-icon img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        .logo-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            color: var(--gray-500);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            background: var(--gray-100);
            color: var(--primary);
        }
        .nav-item.active {
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
        }
        .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

        .sidebar-bottom {
            padding: 1rem 0.75rem 1.5rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .nav-item.logout { color: #dc2626; }
        .nav-item.logout:hover { background: #fef2f2; color: #dc2626; }

        /* ===== MAIN AREA ===== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: var(--topbar-height);
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 10px rgba(55,36,102,0.04);
            overflow: visible;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            color: var(--primary);
        }
        .menu-toggle:hover { background: var(--gray-100); }
        
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
    
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.4rem 0.75rem;
            border-radius: 10px;
            transition: background 0.2s;
        }
        .user-info:hover { background: var(--gray-100); }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            overflow: hidden;
        }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .user-meta { text-align: right; }
        .user-name { font-size: 0.875rem; font-weight: 600; color: var(--gray-800); line-height: 1.2; }
        .user-role {
            font-size: 0.72rem;
            color: var(--warning);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            justify-content: flex-end;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* ===== STAT CARDS ===== */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.25rem;
            border: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        .stat-card:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
        .stat-card-header { display: flex; align-items: center; justify-content: space-between; }
        .stat-label { font-size: 0.8rem; color: var(--gray-400); font-weight: 500; }
        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--gray-800); line-height: 1; }
        .stat-sub { font-size: 0.8rem; color: var(--gray-400); font-weight: 500; }
        .stat-progress { margin-top: 0.25rem; }

        /* ===== PROGRESS BAR ===== */
        .progress-bar {
            width: 100%;
            height: 6px;
            background: var(--gray-200);
            border-radius: 3px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--accent-light));
            border-radius: 3px;
            transition: width 1s ease;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            font-family: var(--font);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary { background: var(--primary); color: var(--white); }
        .btn-primary:hover { background: var(--primary-light); box-shadow: 0 4px 15px var(--accent-glow); transform: translateY(-1px); }
        .btn-outline { background: transparent; color: var(--primary); border-color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: var(--white); }
        .btn-sm { padding: 0.45rem 1rem; font-size: 0.8rem; border-radius: 8px; }

        /* ===== CARD ===== */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            font-weight: 700;
            font-size: 1rem;
            color: var(--gray-800);
        }
        .card-body { padding: 1.5rem; }

        /* ===== GRID ===== */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }

        /* ===== SIDEBAR OVERLAY ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 90;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .stat-cards { grid-template-columns: repeat(2, 1fr); }
            .grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-overlay.show { display: block; }
            .main-wrapper { margin-left: 0; }
            .menu-toggle { display: flex; }
            .search-bar { width: 200px; }
        }

        @media (max-width: 640px) {
            .stat-cards { grid-template-columns: 1fr 1fr; }
            .page-content { padding: 1rem; }
            .topbar { padding: 0 1rem; }
            .search-bar { display: none; }
            .topbar-left { gap: 0.5rem; }
            .grid-3 { grid-template-columns: 1fr; }
            .user-meta { display: none; }
        }

        @media (max-width: 400px) {
            .stat-cards { grid-template-columns: 1fr; }
        }

        /* ===== PROFILE DROPDOWN ===== */
        .user-wrap { position: relative; }
        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 220px;
            background: var(--white);
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(55,36,102,0.13);
            display: none;
            z-index: 9999;
            overflow: hidden;
        }
    .profile-dropdown.show { display: block; }
    .profile-drop-header {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .profile-drop-avatar {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 1rem;
        flex-shrink: 0;
    }
    .profile-drop-name { font-size: 0.82rem; font-weight: 700; color: var(--gray-800); line-height: 1.3; }
    .profile-drop-role { font-size: 0.68rem; color: var(--warning); font-weight: 500; }
    .profile-drop-menu { padding: 0.5rem; }
    .profile-drop-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 0.75rem;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--gray-600);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s;
    }
    .profile-drop-item:hover { background: var(--gray-100); color: var(--primary); }
    .profile-drop-item svg { width: 16px; height: 16px; flex-shrink: 0; }
    .profile-drop-item.danger { color: #dc2626; }
    .profile-drop-item.danger:hover { background: #fef2f2; color: #dc2626; }
    .profile-drop-divider { height: 1px; background: var(--gray-100); margin: 0.35rem 0; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">
            <img src="{{ asset('img/Icon.png') }}" alt="Logo Mappy Path">
        </div>
        <span class="logo-text">Mappy Path</span>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('roadmap') }}" class="nav-item {{ request()->routeIs('roadmap') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Roadmap
        </a>
        <a href="{{ route('target') }}" class="nav-item {{ request()->routeIs('target') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3"/><path d="M12 1v4m0 14v4M1 12h4m14 0h4m-4.22-6.78l-2.83 2.83M6.05 17.95l-2.83 2.83m0-14.14l2.83 2.83M17.95 17.95l2.83 2.83"/>
            </svg>
            Target Belajar
        </a>
        <a href="{{ route('progress') }}" class="nav-item {{ request()->routeIs('progress') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            Progress
        </a>
    </nav>

    <div class="sidebar-bottom">
        <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
            Pengaturan
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item logout w-100" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-family:var(--font);">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="main-wrapper">
    <!-- Topbar -->
    <header class="topbar">
    <div class="topbar-left">
        <button class="menu-toggle" id="menuToggle" onclick="toggleSidebar()">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="topbar-right">

    {{-- PROFIL --}}
        <div class="user-wrap">
            <div class="user-info" id="userBtn" onclick="toggleProfile()">
                <div class="user-meta">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">⭐ {{ Auth::user()->getRoleLabel() }}</div>
                </div>
                <div class="user-avatar">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
            </div>
            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-drop-header">
                    <div class="profile-drop-avatar" style="overflow:hidden;padding:0;">
                        @if(Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="profile-drop-name">{{ Auth::user()->name }}</div>
                        <div class="profile-drop-role">⭐ {{ Auth::user()->getRoleLabel() }}</div>
                    </div>
                </div>
                <div class="profile-drop-menu">
                    <a href="{{ route('pengaturan.index') }}" class="profile-drop-item">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                        </svg>
                        Pengaturan
                    </a>
                    <div class="profile-drop-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="profile-drop-item danger" style="background:none;border:none;width:100%;text-align:left;font-family:var(--font);">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>

    <!-- Content -->
    <main class="page-content">
        @yield('content')
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

function toggleProfile() {
    document.getElementById('profileDropdown').classList.toggle('show');
    document.getElementById('notifDropdown').classList.remove('show');
}
function markRead(el) {
    el.classList.remove('unread');
    const dot = el.querySelector('.notif-unread-dot');
    if (dot) dot.remove();
    updateBadge();
}
function markAllRead() {
    document.querySelectorAll('.notif-item.unread').forEach(el => {
        el.classList.remove('unread');
        const dot = el.querySelector('.notif-unread-dot');
        if (dot) dot.remove();
    });
    updateBadge();
}
function updateBadge() {
    const unread = document.querySelectorAll('.notif-item.unread').length;
    const badge = document.getElementById('notifBadge');
    if (unread === 0) badge.style.display = 'none';
}

document.addEventListener('click', function(e) {
    if (!document.getElementById('userBtn').contains(e.target) &&
        !document.getElementById('profileDropdown').contains(e.target)) {
        document.getElementById('profileDropdown').classList.remove('show');
    }
});
</script>
@stack('scripts')
</body>
</html>
