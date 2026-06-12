@extends('layouts.app')

@section('title', 'TKJPedia - Wujudkan Impianmu di Dunia IT')

@push('head')
<style>
:root {
    --primary: #FF4D00;
    --primary-light: #FF6A00;
    --accent: #FF8100;
    --accent-light: #FFB366;
    --accent-glow-soft:rgba(255,77,0,0.12);
    --accent-glow:rgba(255,77,0,0.25);
    --accent-glow-mid:rgba(255,77,0,0.35);
    --accent-glow-strong:rgba(255,77,0,0.40);
    --stat-warn: #f59e0b;
    --stat-ok: #10b981;
    --white: #ffffff;
    --gray-50: #fffaf5;
    --gray-100: #fff3e6;
    --gray-200: #ffe0bf;
    --gray-400: #c28d6d;
    --gray-500: #9a6a4a;
    --gray-700: #5a3722;
    --gray-800: #3b2415;
    --radius: 18px;
    --radius-sm: 12px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    background: var(--white);
    color: var(--gray-800);
    overflow-x: hidden;
}

/* ─── NAVBAR ─── */
.navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--gray-200);
    padding: 0 6%;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: box-shadow 0.3s;
}
.navbar.scrolled { box-shadow: 0 4px 24px rgba(255,77,0,0.12); }
.nav-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}
.logo-icon {
    display: flex;
    align-items: center;
}
.logo-icon img {
    width: 38px;
    height: 38px;
    object-fit: contain;
    display: block;
}
.nav-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
}
.nav-actions { display: flex; align-items: center; gap: 0.6rem; }
.btn-nav-login {
    padding: 0.5rem 1.3rem;
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    font-weight: 600;
    border: 1.5px solid var(--gray-200);
    background: transparent;
    color: var(--primary);
    text-decoration: none;
    transition: all 0.2s;
}
.btn-nav-login:hover { border-color: var(--primary); background: var(--gray-100); }
.btn-nav-daftar {
    padding: 0.5rem 1.3rem;
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    font-weight: 700;
    border: 1.5px solid var(--primary);
    background: var(--primary);
    color: white;
    text-decoration: none;
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
}
.btn-nav-daftar::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.12));
    pointer-events: none;
}
.btn-nav-daftar:hover {
    background: var(--primary-light);
    border-color: var(--primary-light);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(255,77,0,0.35);
}

/* ─── HERO ─── */
.hero {
    text-align: center;
    padding: 7rem 6% 5rem;
    background: linear-gradient(160deg, #fffaf5 0%, #fff3e6 50%, #fff8f2 100%);
    position: relative;
    overflow: hidden;
}
.hero-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    opacity: 0.55;
}
.hero-blob-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, #ffd6b3 0%, transparent 70%);
    top: -150px; left: -100px;
}
.hero-blob-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, #ffb366 0%, transparent 70%);
    bottom: -100px; right: -80px;
}
.hero-blob-3 {
    width: 300px; height: 300px;
    background: radial-gradient(circle, #ffe6cc 0%, transparent 70%);
    top: 40%; left: 50%;
    transform: translateX(-50%);
}

.hero-title {
    font-size: clamp(1.6rem, 4vw, 2.8rem);
    font-weight: 800;
    color: var(--gray-800);
    line-height: 1.2;
    margin-bottom: 1.25rem;
    animation: fadeUp 0.7s ease both;
    white-space: nowrap;
}
@media (max-width: 600px) {
    .hero-title { white-space: normal; font-size: clamp(1.5rem, 6vw, 2rem); }
}
.hero-title .highlight {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}
.hero-desc {
    font-size: clamp(0.95rem, 1.8vw, 1.1rem);
    color: var(--gray-500);
    max-width: 580px;
    margin: 0 auto 2.5rem;
    line-height: 1.75;
    animation: fadeUp 0.8s ease both;
}
.hero-cta-group {
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeUp 0.9s ease both;
}
.btn-cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: var(--primary);
    color: white;
    padding: 0.85rem 2rem;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(255,77,0,0.25);
    position: relative;
    overflow: hidden;
}
.btn-cta-primary::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s;
}
.btn-cta-primary:hover::before { left: 100%; }
.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 36px rgba(255,77,0,0.4);
}

.hero-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2.5rem;
    margin-top: 3rem;
    flex-wrap: wrap;
    animation: fadeUp 1s ease both;
}
.hero-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-500);
    font-size: 0.875rem;
    font-weight: 500;
}
.stat-check {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 0.65rem;
    flex-shrink: 0;
}
.hero-divider {
    width: 1px; height: 16px;
    background: var(--gray-200);
}

/* ─── DEMO CARD ─── */
.demo-section {
    display: flex;
    justify-content: center;
    padding: 2rem 6% 5rem;
    background: linear-gradient(180deg, #fff3e6 0%, #fff 100%);
}
.demo-card {
    background: white;
    border-radius: 24px;
    padding: 2rem 2.2rem;
    color: var(--gray-800);
    width: 100%;
    max-width: 520px;

    border: 2px solid rgba(255,106,0,0.25);

    box-shadow:
        0 20px 50px rgba(255,77,0,0.15),
        0 4px 12px rgba(255,77,0,0.08),
        inset 0 1px 0 rgba(255,255,255,0.9);

    animation: floatCard 5s ease-in-out infinite;
    position: relative;
    overflow: hidden;
}

.demo-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -120%;

    width: 60%;
    height: 100%;

    background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.5),
        transparent
    );

    transform: skewX(-20deg);
    animation: shine 6s infinite;
}

@keyframes shine {
    0% {
        left: -120%;
    }

    100% {
        left: 180%;
    }
}

/* Avatar pakai ikon orang */
.demo-avatar {
    width: 48px; height: 48px;
    background: var(--gray-100);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1.5px solid var(--gray-200);
    flex-shrink: 0;
}
.demo-avatar svg { color: var(--accent); }

.demo-user {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 1.5rem;
}
.demo-user-info { flex: 1; }
.demo-user-name { font-size: 0.95rem; font-weight: 700; color: var(--gray-800); }
.demo-user-stage { font-size: 0.8rem; color: var(--gray-500); margin-top: 0.15rem; }
.demo-badge {
    background: #fff3e6;
    color: #cc3300;
    border: 1px solid #ffb366;
    border-radius: 8px;
    padding: 0.3rem 0.65rem;
    font-size: 0.72rem;
    font-weight: 700;
    white-space: nowrap;
}

/* Progress label + angka sejajar */
.demo-progress-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}
.demo-progress-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--gray-700);
}
.demo-progress-value {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--primary);
}
.demo-bar {
    height: 7px;
    background: var(--gray-100);
    border-radius: 50px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.demo-bar-fill {
    height: 100%;
    width: 75%;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    border-radius: 50px;
}

.demo-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
}

.demo-stat-box {
    background: #fff8f2;
    border-radius: 12px;
    padding: 0.85rem 0.75rem;
    text-align: center;
    border: 1px solid var(--gray-200);
}
.demo-stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--gray-800);
    line-height: 1;
}
.demo-stat-value.orange { color: #f59e0b; }
.demo-stat-value.green { color: #10b981; }
.demo-stat-label { font-size: 0.72rem; color: var(--gray-500); margin-top: 0.3rem; font-weight: 500; }

/* ─── FEATURES ─── */
.features-section {
    padding: 5.5rem 6%;
    background: var(--white);
    position: relative;
}
.features-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gray-200), transparent);
}
.section-header {
    text-align: center;
    margin-bottom: 3.5rem;
}
.section-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--gray-100);
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    margin-bottom: 1rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    border: 1px solid var(--gray-200);
}
.section-title {
    font-size: clamp(1.4rem, 2.5vw, 1.9rem);
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.75rem;
    line-height: 1.3;
}
.section-desc {
    color: var(--gray-500);
    font-size: 1rem;
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.75;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1.25rem;
}
.features-grid .feature-card:nth-child(1) { grid-column: span 2; }
.features-grid .feature-card:nth-child(2) { grid-column: span 2; }
.features-grid .feature-card:nth-child(3) { grid-column: span 2; }
.features-grid .feature-card:nth-child(4) { grid-column: 2 / span 2; }
.features-grid .feature-card:nth-child(5) { grid-column: 4 / span 2; }


a.feature-card {
    text-decoration: none;
    color: inherit;
    display: block;
}
.feature-card {
    background: var(--white);
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 1.85rem 1.75rem;
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.feature-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient( 135deg, rgba(255,77,0,0.05), transparent);
    opacity: 0;
    transition: opacity 0.3s;
}
.feature-card:hover {
    border-color: var(--accent-light);
    box-shadow: 0 16px 48px rgba(255,77,0,0.15), 0 2px 8px rgba(255,77,0,0.08);
    transform: translateY(-6px);
}
.feature-card:hover::before { opacity: 1; }
.feature-card:active { transform: translateY(-2px); }

.feature-card-arrow {
    position: absolute;
    top: 1.5rem; right: 1.5rem;
    width: 28px; height: 28px;
    border-radius: 8px;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    font-size: 0.8rem;
    transition: all 0.3s;
    opacity: 0;
    transform: translateX(-4px);
}
.feature-card:hover .feature-card-arrow {
    opacity: 1;
    transform: translateX(0);
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: white;
}

.feature-icon-wrap {
    width: 54px; height: 54px;
    border-radius: 16px;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1.25rem;
    transition: all 0.3s;
    border: 1px solid transparent;
    position: relative;
}
.feature-card:hover .feature-icon-wrap {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-color: transparent;
    box-shadow: 0 8px 24px var(--accent-glow);
    transform: scale(1.08) rotate(-3deg);
}

.feature-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.5rem;
    transition: color 0.3s;
}
.feature-card:hover .feature-title { color: var(--primary); }
.feature-desc {
    font-size: 0.875rem;
    color: var(--gray-500);
    line-height: 1.65;
}
.feature-tag {
    display: inline-block;
    margin-top: 1rem;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--accent);
    background: rgba(255,77,0,0.10);
    padding: 0.25rem 0.65rem;
    border-radius: 50px;
    letter-spacing: 0.04em;
}

/* ─── STATS STRIP ─── */
.stats-strip {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    padding: 3.5rem 6%;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.stats-strip::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.stat-item { position: relative; }
.stat-number {
    font-size: 2.6rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}
.stat-number span { color: rgba(255,255,255,0.6); font-size: 1.8rem; }
.stat-label {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.7);
    margin-top: 0.5rem;
    font-weight: 500;
}

/* ─── HOW IT WORKS ─── */
.how-section {
    padding: 5.5rem 6%;
    background: var(--gray-50);
    position: relative;
}
.how-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 3rem;
}
.how-card {
    background: white;
    border-radius: var(--radius);
    padding: 2rem;
    border: 1.5px solid var(--gray-200);
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
}
.how-card:hover {
    box-shadow: 0 12px 40px rgba(255,77,0,0.15);
    transform: translateY(-4px);
    border-color: var(--accent-light);
}
.how-number {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--gray-200);
    line-height: 1;
    margin-bottom: 1rem;
    transition: color 0.3s;
}
.how-card:hover .how-number { color: rgba(255,77,0,0.2); }
.how-icon { font-size: 1.8rem; margin-bottom: 0.75rem; }
.how-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.5rem;
}
.how-desc { font-size: 0.875rem; color: var(--gray-500); line-height: 1.65; }

/* ─── CTA SECTION ─── */
.cta-section {
    padding: 5rem 6%;
    text-align: center;
    background: white;
}
.cta-box {
    background: linear-gradient(135deg, #FF4D00 0%, #FF6A00 50%, #FF8100 100%);
    border-radius: 28px;
    padding: 4rem 3rem;
    color: white;
    position: relative;
    overflow: hidden;
    max-width: 800px;
    margin: 0 auto;
}
.cta-box::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
}
.cta-box::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 250px; height: 250px;
    background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
}
.cta-emoji { font-size: 3rem; margin-bottom: 1rem; display: block; }
.cta-title {
    font-size: clamp(1.4rem, 2.5vw, 1.9rem);
    font-weight: 700;
    margin-bottom: 0.75rem;
}
.cta-desc { opacity: 0.8; font-size: 1rem; margin-bottom: 2rem; line-height: 1.7; }
.btn-cta-white {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: white;
    color: var(--primary);
    padding: 0.9rem 2rem;
    border-radius: var(--radius);
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.btn-cta-white:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}

/* ─── FOOTER ─── */
.footer {
    background: var(--primary);
    color: white;
    padding: 3.5rem 6% 1.75rem;
}
.footer-top {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding-bottom: 2.5rem;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    text-align: center;
}
.footer-brand { display: flex; align-items: center; gap: 0.75rem; }
.footer-logo img { width: 38px; height: 38px; object-fit: contain; }
.footer-brand-name {
    font-size: 1.1rem;
    font-weight: 700;
}
.footer-tagline {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.9);
    margin-top: 0.4rem;
    max-width: 500px;
    line-height: 1.8;
}

.footer-socials { display: flex; gap: 0.75rem; margin-top: 1rem; }
.social-btn {
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.12);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    text-decoration: none;
    backdrop-filter: blur(10px);
}

.social-btn:hover {
    background: white;
    color: var(--primary);
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(255,255,255,0.2);
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.75rem;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.85);
    flex-wrap: wrap;
    gap: 0.75rem;
}

.footer-links { display: flex; gap: 1.5rem; }
.footer-links a { color: white; text-decoration: none; transition: opacity 0.2s; }
.footer-links a:hover { opacity: 0.8; text-decoration: underline; }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ─── RESPONSIVE ─── */
@media (max-width: 1024px) {
    .features-grid { grid-template-columns: repeat(2, 1fr); }
    .stats-strip { grid-template-columns: repeat(2, 1fr); }
    .how-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .navbar { padding: 0 4%; }
    .hero { padding: 5rem 4% 4rem; }
    .features-section, .how-section, .cta-section { padding: 4rem 4%; }
    .stats-strip { padding: 3rem 4%; }
    .demo-section { padding: 2rem 4% 4rem; }
    .hero-divider { display: none; }
}
@media (max-width: 600px) {
    .features-grid { grid-template-columns: 1fr; }
    .stats-strip { grid-template-columns: repeat(2, 1fr); }
    .how-grid { grid-template-columns: 1fr; }
    .btn-nav-login { display: none; }
    .footer-bottom { flex-direction: column; text-align: center; }
    .cta-box { padding: 3rem 1.75rem; }
}
@media (max-width: 400px) {
    .btn-cta-primary { width: 100%; justify-content: center; }
}
.tkj-alert {
    border-radius: 24px !important;
    border: 2px solid #FFB366 !important;
    box-shadow: 0 20px 60px rgba(255,77,0,0.25) !important;
}

.swal2-title {
    font-weight: 700 !important;
}

.swal2-confirm {
    border-radius: 12px !important;
    padding: 10px 24px !important;
    font-weight: 600 !important;
}
</style>
@endpush

@section('content')

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="{{ route('landing') }}" class="nav-brand">
        <div class="logo-icon">
            <img src="img/Icon.png" alt="Logo TKJPedia" style="width:48px;height:48px;object-fit:contain;">
        </div>
        <span class="nav-name">TKJPedia</span>
    </a>
    <div class="nav-actions">
        <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
        <a href="{{ route('register') }}" class="btn-nav-daftar">Daftar Gratis</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="hero-blob hero-blob-3"></div>

    <h1 class="hero-title">
        Wujudkan Impianmu di <span class="highlight">Dunia IT</span>
    </h1>
    <p class="hero-desc">
        Platform roadmap pembelajaran yang dirancang khusus untuk siswa SMK Teknik Komputer dan
        Jaringan. Rencanakan, pantau, dan capai target belajarmu dengan lebih terstruktur.
    </p>
    <div class="hero-cta-group">
        <a href="{{ route('register') }}" class="btn-cta-primary">
            Daftar Gratis
        </a>
    </div>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="stat-check">✓</div>
            Gratis selamanya
        </div>
        <div class="hero-stat">
            <div class="stat-check">✓</div>
            19 Materi
        </div>
        <div class="hero-stat">
            <div class="stat-check">✓</div>
            1k+ Siswa
        </div>

    </div>
</section>

<!-- DEMO CARD -->
<section class="demo-section">
    <div class="demo-card">
        <div class="demo-user">
            <!-- Avatar icon orang -->
            <div class="demo-avatar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="demo-user-info">
                <div class="demo-user-name">Anatasha Berliane</div>
                <div class="demo-user-stage">Jaringan Dasar — 75% Selesai</div>
            </div>
            <div class="demo-badge"><div class="demo-badge">
    🔥 7 Hari Streak • 1.250 XP
</div> </div>
        </div>
        <div class="demo-progress-row">
            <span class="demo-progress-label">Progress Minggu Ini 🔥</span>
            <span class="demo-progress-value">19 Materi</span>
        </div>
        <div class="demo-bar">
            <div class="demo-bar-fill"></div>
        </div>
        <div class="demo-stats">
           <div class="demo-stat-box">
            <div class="demo-stat-value">19</div>
            <div class="demo-stat-label">Materi Selesai</div>
        </div>
            <div class="demo-stat-box">
                <div class="demo-stat-value orange">6h</div>
                <div class="demo-stat-label">Minggu ini</div>
            </div>
            <div class="demo-stat-box">
                <div class="demo-stat-value orange">4</div>
                <div class="demo-stat-label">Kuis Selesai</div>
            </div>
            <div class="demo-stat-box">
                <div class="demo-stat-value green">120</div>
                <div class="demo-stat-label">Badge</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section">
    <div class="section-header reveal">
        <div class="section-tag">✨ Fitur Unggulan</div>
        <h2 class="section-title">Semua yang kamu butuhkan<br>ada di sini</h2>
        <p class="section-desc">Belajar jadi lebih mudah, terarah, dan menyenangkan dengan fitur-fitur yang kami siapkan untukmu.</p>
    </div>
    <div class="features-grid">

        <a href="{{ auth()->check() ? route('roadmap') : route('register') }}" class="feature-card reveal">
            <div class="feature-card-arrow">→</div>
            <div class="feature-icon-wrap">🗺️</div>
            <div class="feature-title">Roadmap Terstruktur</div>
            <div class="feature-desc">Peta belajar yang sudah disusun oleh guru dan praktisi IT berpengalaman sesuai kurikulum TKJ.</div>
            <span class="feature-tag">CP 1, 2, 4, 6</span>
        </a>

        <a href="{{ auth()->check() ? route('progress') : route('register') }}" class="feature-card reveal">
            <div class="feature-card-arrow">→</div>
            <div class="feature-icon-wrap">📊</div>
            <div class="feature-title">Pantau Progress</div>
            <div class="feature-desc">Lihat perkembangan belajarmu setiap hari, minggu, dan bulan dengan grafik yang mudah dipahami.</div>
            <span class="feature-tag">Harian & Mingguan</span>
        </a>

        <a href="{{ auth()->check() ? route('target') : route('register') }}" class="feature-card reveal">
            <div class="feature-card-arrow">→</div>
            <div class="feature-icon-wrap">🎯</div>
            <div class="feature-title">Target Belajar</div>
            <div class="feature-desc">Tetapkan target belajar harianmu dan pantau perkembangan belajarmu setiap saat.</div>
            <span class="feature-tag">Capaian Belajar</span>
        </a>

        <a href="{{ auth()->check() ? route('progress') : route('register') }}" class="feature-card reveal">
            <div class="feature-card-arrow">→</div>
            <div class="feature-icon-wrap">🏆</div>
            <div class="feature-title">Badge & Prestasi</div>
            <div class="feature-desc">Kumpulkan badge setiap kali menyelesaikan materi dan buktikan kemampuanmu kepada semua orang.</div>
            <span class="feature-tag">Gamifikasi</span>
        </a>

        <a href="{{ auth()->check() ? route('roadmap') : route('register') }}" class="feature-card reveal">
            <div class="feature-card-arrow">→</div>
            <div class="feature-icon-wrap">📚</div>
            <div class="feature-title">19 Materi Lengkap</div>
            <div class="feature-desc">Video berdasarkan CP 1, 2, 4 & 6 yang selalu diperbarui sesuai teknologi terkini.</div>
            <span class="feature-tag">CP-Based Content</span>
        </a>

    </div>
</section>

<!-- STATS STRIP -->
<div class="stats-strip reveal">
    <div class="stat-item">
        <div class="stat-number">19<span>+</span></div>
        <div class="stat-label">📚 Total Materi</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">4<span>CP</span></div>
        <div class="stat-label">📋 Capaian Pembelajaran</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">1K<span>+</span></div>
        <div class="stat-label">🎓 Siswa Aktif</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">100<span>%</span></div>
        <div class="stat-label">✨ Gratis Selamanya</div>
    </div>
</div>

<!-- HOW IT WORKS -->
<section class="how-section">
    <div class="section-header reveal">
        <div class="section-tag">🚦 Cara Kerja</div>
        <h2 class="section-title">Mulai belajar dalam 3 langkah</h2>
        <p class="section-desc">Tidak perlu bingung harus mulai dari mana. Kami sudah siapkan semuanya untukmu.</p>
    </div>
    <div class="how-grid">
        <div class="how-card reveal">
            <div class="how-number">01</div>
            <div class="how-icon">📝</div>
            <div class="how-title">Daftar Gratis</div>
            <div class="how-desc">Buat akun dalam hitungan detik. Tidak perlu kartu kredit, tidak ada biaya tersembunyi.</div>
        </div>
        <div class="how-card reveal">
            <div class="how-number">02</div>
            <div class="how-icon">🗺️</div>
            <div class="how-title">Pilih Roadmap</div>
            <div class="how-desc">Pilih jalur belajar sesuai CP yang ingin dikuasai dan mulai dari tahap yang paling dasar.</div>
        </div>
        <div class="how-card reveal">
            <div class="how-number">03</div>
            <div class="how-icon">🏆</div>
            <div class="how-title">Belajar & Raih Badge</div>
            <div class="how-desc">Selesaikan materi satu per satu, pantau progresmu, dan kumpulkan badge sebagai bukti keahlianmu.</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-box reveal">
        <span class="cta-emoji">🚀</span>
        <h2 class="cta-title">Siap memulai perjalanan belajarmu?</h2>
        <p class="cta-desc">Bergabung bersama 1K+ siswa SMK TKJ yang sudah belajar lebih terstruktur bersama TKJPedia. Gratis selamanya.</p>
        <a href="{{ route('register') }}" class="btn-cta-white">
            Daftar Sekarang — Gratis! ✨
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="img/Icon1.png" alt="Logo TKJPedia">
            </div>
            <span class="footer-brand-name">TKJPedia</span>
        </div>
        <p class="footer-tagline">Platform roadmap pembelajaran terstruktur untuk siswa SMK Teknik Komputer dan Jaringan berbasis Kurikulum Merdeka.</p>
        <div class="footer-socials">
            <a href="#" onclick="fiturBelumTersedia(event)" class="social-btn" title="Instagram">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                </svg>
            </a>
            <a href="#" onclick="fiturBelumTersedia(event)" class="social-btn" title="YouTube">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/>
                    <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="var(--gray-800)"/>
                </svg>
            </a>
            <a href="#" onclick="fiturBelumTersedia(event)" class="social-btn" title="X (Twitter)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
            <a href="#" onclick="fiturBelumTersedia(event)" class="social-btn" title="Website">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© 2026 TKJPedia. All Rights Reserved.</span>
       <div class="footer-links">
    <a href="#" onclick="fiturBelumTersedia(event)">Kebijakan Privasi</a>
    <a href="#" onclick="fiturBelumTersedia(event)">Panduan Penggunaan</a>
</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function fiturBelumTersedia(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'info',
        title: '🚀 Segera Hadir',
        text: 'Fitur ini masih dalam tahap pengembangan oleh tim TKJPedia.',
        confirmButtonText: 'Nantikan!',
        confirmButtonColor: '#FF4D00',
        background: '#fffaf5',
        color: '#3b2415',
        customClass: {
            popup: 'tkj-alert'
        }
    });
}

const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, entry.target.dataset.delay || 0);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach((el, i) => {
    el.dataset.delay = (i % 3) * 80;
    observer.observe(el);
});

document.querySelectorAll('.features-grid .feature-card').forEach((card, i) => {
    card.style.transitionDelay = `${i * 60}ms`;
});
</script>

@endsection