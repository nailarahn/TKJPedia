<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - TKJPedia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    
    <style>
        :root {
        --primary: #FF4D00;
        --primary-light: #FF6A00;
        --primary-dark: #cc3d00;
        --accent: #FF8100;
        --accent-light: #FFB366;
        --accent-glow: rgba(255,77,0,0.25);
        --sidebar-bg: #fffaf5;
        --sidebar-width: 260px;
        --topbar-height: 70px;
        --white: #ffffff;
        --gray-50: #fffaf5;
        --gray-100: #fff3e6;
        --gray-200: #ffe0bf;
        --gray-300: #f5c89a;
        --gray-400: #c28d6d;
        --gray-500: #9a6a4a;
        --gray-600: #7a5038;
        --gray-700: #5a3722;
        --gray-800: #3b2415;
        --success: #22c55e;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --font: 'Poppins', sans-serif;
        --radius: 14px;
        --shadow: 0 4px 20px rgba(255,77,0,0.08);
        --shadow-lg: 0 10px 40px rgba(255,77,0,0.15);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: var(--font);
        background: var(--gray-50);
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
        box-shadow: 2px 0 20px rgba(255,77,0,0.05);
    }

    .sidebar-logo {
        padding: 1.5rem 1.5rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .logo-icon {
        display: flex;
        align-items: center;
    }
    .logo-icon img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        display: block;
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
        box-shadow: 0 2px 10px rgba(255,77,0,0.04);
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
    .stat-cards{
    display:grid;
    grid-template-columns:repeat(5, minmax(0,1fr));
    gap:1rem;
    margin-bottom:1.5rem;
    }

    .stat-card{
    min-width:0;
    }

    .stat-value{
        font-size:1.35rem;
    }

    .stat-label{
        font-size:.75rem;
    }

    .stat-card {
    background: var(--white);
    border-radius: var(--radius);
    padding: 1.1rem;
    border: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: .6rem;
    transition: all .2s;
    min-height: 170px; 
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
   .stat-value{
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    line-height: 1.1;
    min-height: 80px;
    display: flex;
    align-items: center;
    gap: 2px;
}

.stat-sub{
    font-size: .9rem;
    color: var(--gray-400);
    font-weight: 500;
}

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
        position: relative;
        overflow: hidden;
    }
    .btn::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s;
    }
    .btn:hover::before { left: 100%; }
    .btn-primary { background: var(--primary); color: var(--white); }
    .btn-primary:hover {
        background: var(--primary-light);
        box-shadow: 0 4px 15px var(--accent-glow);
        transform: translateY(-1px);
    }
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
        .sidebar { transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); }
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
        box-shadow: 0 10px 40px rgba(255,77,0,0.13);
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

  .current-title{
    font-size: 1.1rem !important; 
    font-weight: 700;
    line-height: 1.3;
    min-height: 55px; 
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">
            <img src="{{ asset('img/Icon.png') }}" alt="Logo TKJPedia">
        </div>
        <span class="logo-text">TKJPedia</span>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('roadmap') }}" class="nav-item {{ request()->routeIs('roadmap') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Roadmap
        </a>
        <a href="{{ route('target') }}" class="nav-item {{ request()->routeIs('target') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v4m0 14v4M1 12h4m14 0h4m-4.22-6.78l-2.83 2.83M6.05 17.95l-2.83 2.83m0-14.14l2.83 2.83M17.95 17.95l2.83 2.83"/></svg>
            Target Belajar
        </a>
        <a href="{{ route('progress') }}" class="nav-item {{ request()->routeIs('progress') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Progress
        </a>
    </nav>
    <div class="sidebar-bottom">
        <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            Pengaturan
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item logout w-100" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-family:var(--font);">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<div class="main-wrapper">
    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle" onclick="toggleSidebar()">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="topbar-right">
            {{-- XP BADGE --}}
            <div style="display:flex;align-items:center;gap:.4rem;background:linear-gradient(135deg,#fffbeb,#fef3c7);border:1.5px solid #fcd34d;border-radius:20px;padding:.3rem .85rem;font-size:.78rem;font-weight:700;color:#92400e;">
                <span>⚡</span>
                <span id="topbar-xp">{{ Auth::user()->fresh()->total_xp ?? 0 }} XP</span>
            </div>
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
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                            Pengaturan
                        </a>
                        <div class="profile-drop-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="profile-drop-item danger" style="background:none;border:none;width:100%;text-align:left;font-family:var(--font);">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="page-content">
        @yield('content')
    </main>
</div>

<!-- ===== GAMIFICATION POPUP SYSTEM ===== -->
<div id="tkj-reward-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9998;backdrop-filter:blur(4px);transition:opacity .3s;"></div>

<div id="tkj-reward-popup" style="
    display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-60%) scale(0.8);
    z-index:9999;width:360px;max-width:calc(100vw - 2rem);
    background:white;border-radius:24px;padding:2rem 1.75rem;text-align:center;
    box-shadow:0 25px 80px rgba(55,36,102,0.35);
    transition:all .4s cubic-bezier(0.34,1.56,0.64,1);opacity:0;
">
    <div id="tkj-reward-confetti" style="position:absolute;inset:0;pointer-events:none;overflow:hidden;border-radius:24px;"></div>
    <div id="tkj-reward-badge-wrap" style="width:90px;height:90px;border-radius:24px;margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;font-size:2.5rem;background:#efe9ff;position:relative;">
        <span id="tkj-reward-emoji">🏅</span>
        <div style="position:absolute;inset:-5px;border-radius:50%;border:3px solid transparent;border-top-color:#6C4CF1;border-right-color:#A586FF;animation:spinRing 2s linear infinite;"></div>
    </div>
    <div id="tkj-reward-type" style="font-size:.72rem;font-weight:700;color:#9589b8;letter-spacing:.08em;text-transform:uppercase;margin-bottom:.35rem;">Pencapaian Baru!</div>
    <div id="tkj-reward-title" style="font-size:1.4rem;font-weight:800;color:#1e1640;margin-bottom:.35rem;">Kerja Bagus!</div>
    <div id="tkj-reward-desc" style="font-size:.875rem;color:#6d5f9a;line-height:1.6;margin-bottom:1.25rem;">Kamu berhasil menyelesaikan materi ini.</div>
    <div style="display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#fffbeb,#fef3c7);border:1.5px solid #fcd34d;border-radius:99px;padding:.45rem 1.25rem;font-size:.95rem;font-weight:700;color:#92400e;margin-bottom:1.5rem;">
        <span style="font-size:1.1rem;">⚡</span>
        <span id="tkj-reward-xp-text">+50 XP</span>
        <span style="font-size:.75rem;font-weight:500;color:#b45309;">diperoleh!</span>
    </div>
    <div id="tkj-reward-badge-info" style="display:none;background:#f4f1ff;border:1.5px solid #c4b5fd;border-radius:14px;padding:.9rem;margin-bottom:1.25rem;">
        <div style="font-size:.72rem;font-weight:600;color:#7c3aed;margin-bottom:.35rem;">🏆 Badge Diraih!</div>
        <div id="tkj-reward-badge-name" style="font-size:1rem;font-weight:700;color:#1e1640;"></div>
    </div>
    <button onclick="closeTKJReward()" style="width:100%;padding:.85rem;border:none;border-radius:14px;background:linear-gradient(135deg,#372466,#6C4CF1);color:white;font-family:var(--font);font-size:.95rem;font-weight:700;cursor:pointer;transition:all .2s;"
        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(55,36,102,.4)'"
        onmouseout="this.style.transform='';this.style.boxShadow=''">
        Lanjutkan Belajar 🚀
    </button>
</div>

<style>
@keyframes spinRing    { to{transform:rotate(360deg)} }
@keyframes slideInRight{ from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:translateX(0)} }
@keyframes confettiFall{ to{transform:translateY(120px) rotate(360deg);opacity:0} }
</style>

<script>
function showTKJReward(data) {
    const popup   = document.getElementById('tkj-reward-popup');
    const overlay = document.getElementById('tkj-reward-overlay');
    document.getElementById('tkj-reward-emoji').textContent   = data.emoji  || '🏅';
    document.getElementById('tkj-reward-type').textContent    = data.type   || 'Pencapaian Baru!';
    document.getElementById('tkj-reward-title').textContent   = data.title  || 'Kerja Bagus!';
    document.getElementById('tkj-reward-desc').textContent    = data.desc   || '';
    document.getElementById('tkj-reward-xp-text').textContent = '+' + (data.xp || 50) + ' XP';
    const badgeInfo = document.getElementById('tkj-reward-badge-info');
    if (data.badge) { badgeInfo.style.display = 'block'; document.getElementById('tkj-reward-badge-name').textContent = data.badge; }
    else { badgeInfo.style.display = 'none'; }
    document.getElementById('tkj-reward-badge-wrap').style.background = data.bgColor || '#efe9ff';

    spawnConfetti();
    overlay.style.display = 'block';
    popup.style.display   = 'block';
    setTimeout(() => {
        overlay.style.opacity = '1';
        popup.style.opacity   = '1';
        popup.style.transform = 'translate(-50%,-50%) scale(1)';
    }, 10);
}

function closeTKJReward() {
    const popup   = document.getElementById('tkj-reward-popup');
    const overlay = document.getElementById('tkj-reward-overlay');
    popup.style.opacity   = '0';
    popup.style.transform = 'translate(-50%,-50%) scale(0.8)';
    overlay.style.opacity = '0';
    setTimeout(() => { popup.style.display = 'none'; overlay.style.display = 'none'; }, 350);
}

function spawnConfetti() {
    const container = document.getElementById('tkj-reward-confetti');
    container.innerHTML = '';
    const colors = ['#6C4CF1','#fcd34d','#22c55e','#f472b6','#38bdf8','#fb923c'];
    for(let i=0;i<30;i++){
        const el = document.createElement('div');
        const color = colors[Math.floor(Math.random()*colors.length)];
        const size  = 5 + Math.random()*8;
        el.style.cssText = `position:absolute;width:${size}px;height:${size}px;background:${color};border-radius:${Math.random()>.5?'50%':'2px'};top:-10px;left:${5+Math.random()*90}%;animation:confettiFall ${1+Math.random()*.8}s ease ${Math.random()*.5}s forwards;`;
        container.appendChild(el);
    }
}

function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
function closeSidebar()   { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('show'); }
function toggleProfile()  { document.getElementById('profileDropdown').classList.toggle('show'); }

document.addEventListener('click', function(e) {
    const btn = document.getElementById('userBtn');
    const dd  = document.getElementById('profileDropdown');
    if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
        dd.classList.remove('show');
    }
});
</script>
@stack('scripts')
</body>
</html>