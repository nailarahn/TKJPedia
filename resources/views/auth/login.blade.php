@extends('layouts.app')

@section('title', 'Masuk - TKJPedia')

@push('head')
<style>
:root {
    --primary: #FF4D00;
    --primary-light: #FF6A00;
    --accent: #FF8100;
    --accent-light: #FFB366;
    --accent-glow: rgba(255,77,0,0.25);
    --white: #ffffff;
    --gray-50: #fffaf5;
    --gray-100: #fff3e6;
    --gray-200: #ffe0bf;
    --gray-300: #f5c89a;
    --gray-400: #c28d6d;
    --gray-500: #9a6a4a;
    --gray-700: #5a3722;
    --gray-800: #3b2415;
    --danger: #ef4444;
    --radius: 18px;
    --radius-sm: 12px;
    --font: 'Poppins', sans-serif;
}

body { 
    background: var(--white); 
    min-height: 100vh; 
}

.login-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 100vh;
}

/* LEFT PANEL */
.login-left {
    background: linear-gradient(135deg, #FF8100 0%, #FF6A00 50%, #FF4D00 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
}

.login-left::before {
    content: '';
    position: absolute;
    top: -30%; right: -20%;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.login-left::after {
    content: '';
    position: absolute;
    bottom: -20%; left: -10%;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
    pointer-events: none;
}

.left-header { 
    display: flex;
    align-items: center; 
    gap: 0.75rem; 
    z-index: 1; 
}

.left-logo {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.left-logo img {
    width: 48px;
    height: 48px;
    object-fit: contain;
    display: block;
}

.left-brand { 
    font-size: 1.2rem; 
    font-weight: 700; 
    color: white; 
}

.left-content { z-index: 1; }

.left-tagline {
    font-size: clamp(1.3rem, 2.5vw, 1.7rem);
    font-weight: 700; 
    color: white; 
    line-height: 1.4; 
    margin-bottom: 1rem;
}

.left-sub {
    color: rgba(255,255,255,0.75);
    font-size: 1rem;
    font-weight: 500;
}

/* Stat mini cards */
.login-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-top: 0.5rem;
}

.login-stat-card {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 16px;
    padding: 1rem;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.login-stat-card:hover {
    background: rgba(255,255,255,0.22);
    border-color: rgba(255,255,255,0.4);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}

.login-stat-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 2px 10px rgba(0,0,0,0.15);
}

.login-stat-label {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.92);
    margin-top: 0.35rem;
    font-weight: 500;
}

.left-footer {
    font-size: 0.8rem;
    color: white;
    opacity: 0.85;
}

/* RIGHT PANEL */
.login-right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 3rem 4rem;
    background: var(--gray-50);
    overflow-y: auto;
}

.login-form-box { 
    width: 100%; 
    max-width: 420px; }

.form-title {
    font-size: 2.2rem; 
    font-weight: 800;
    color: var(--primary); 
    margin-bottom: 0.4rem;
}

.form-subtitle {
    font-size: 0.95rem;
    color: var(--gray-400);
    margin-bottom: 2.5rem;
}

.form-group { margin-bottom: 1.4rem; }

.form-label {
    display: block; 
    font-size: 0.875rem; 
    font-weight: 600;
    color: var(--gray-700); 
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%; 
    padding: 0.8rem 1rem;
    border: 1.5px solid var(--gray-200); 
    border-radius: var(--radius-sm);
    font-family: var(--font); 
    font-size: 0.9rem; 
    color: var(--gray-800);
    background: var(--white); 
    transition: all 0.2s; 
    outline: none;
}

.form-input::placeholder { color: var(--gray-300); }

.form-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--accent-glow);
}

.form-input.error { border-color: var(--danger); }

.password-field { position: relative; }

.password-toggle {
    position: absolute; 
    right: 0.85rem; 
    top: 50%; 
    transform: translateY(-50%);
    cursor: pointer; 
    color: var(--gray-400); 
    background: none; 
    border: none;
    padding: 0.25rem; 
    display: flex; 
    align-items: center; 
    justify-content: center;
    transition: color 0.2s;
}

.password-toggle:hover { color: var(--primary); }

.password-field .form-input { padding-right: 2.8rem; }

.remember-row {
    display: flex;
    justify-content: space-between;
    align-items: center; 
    margin-top: 0.5rem;
    margin-bottom: 1.8rem;
    width: 100%;
}

.remember-left {
    display: flex;
    align-items: center; 
    gap: 0.5rem;
}

.remember-row input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: var(--primary);
    cursor: pointer;
}

.remember-row label {
    font-size: 0.85rem; 
    color: var(--gray-500);
    cursor: pointer;
}

.btn-login {
    width: 100%; 
    padding: 0.9rem;
    background: var(--primary);
    color: white; 
    border: none; 
    border-radius: var(--radius-sm);
    font-family: var(--font); 
    font-size: 1rem; 
    font-weight: 700;
    cursor: pointer; 
    transition: all 0.25s; 
    letter-spacing: 0.01em;
    position: relative; 
    overflow: hidden;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s;
}

.btn-login:hover::before { left: 100%; }

.btn-login:hover {
    background: var(--primary-light);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px var(--accent-glow);
}

.btn-login:disabled { 
    opacity: 0.7; 
    cursor: not-allowed; 
    transform: none; 
}

.register-row {
    text-align: 
    center; margin-top: 1.5rem;
    font-size: 0.875rem; 
    color: var(--gray-400);
}

.register-row a { 
    color: var(--primary); 
    font-weight: 700; 
    text-decoration: none; 
}

.register-row a:hover { text-decoration: underline; }

.alert-danger {
    background: #fef2f2; 
    border: 1px solid #fecaca; 
    color: #dc2626;
    border-radius: var(--radius-sm); 
    padding: 0.85rem 1rem; 
    font-size: 0.875rem;
    margin-bottom: 1.5rem; 
    display: flex; 
    align-items: center; 
    gap: 0.5rem;
}

.alert-success {
    background: #f0fdf4; 
    border: 1px solid #bbf7d0; 
    color: #16a34a;
    border-radius: var(--radius-sm); 
    padding: 0.85rem 1rem; 
    font-size: 0.875rem;
    margin-bottom: 1.5rem; 
    display: flex; 
    align-items: center; 
    gap: 0.5rem;
}

@media (max-width: 900px) {
    .login-wrapper { grid-template-columns: 1fr; }
    .login-left { padding: 2rem; min-height: 220px; justify-content: center; gap: 1rem; }
    .left-content { text-align: center; }
    .login-stats { max-width: 280px; margin: 0.5rem auto 0; }
    .left-footer { display: none; }
    .login-right { padding: 2rem 1.5rem; }
}

@media (max-width: 480px) {
    .login-right { padding: 2rem 1.25rem; }
    .form-title { font-size: 1.8rem; }
    .login-left { min-height: 180px; }
    .left-tagline { font-size: 1.2rem; }
}

.forgot-link {
    color: var(--primary);
    font-size: 0.85rem; 
    font-weight: 500;
    text-decoration: none;
}

.forgot-link:hover {
    text-decoration: underline;
}

</style>
@endpush

@section('content')
<div class="login-wrapper">

    <!-- LEFT -->
    <div class="login-left">
        <div class="left-header">
    <div class="left-logo">
    <img src="{{ asset('img/Icon1.png') }}" alt="TKJPedia Logo">
    </div>
    <span class="left-brand">TKJPedia</span>
    </div>

        <div class="left-content">
            <div class="left-tagline">Halo, sudah kembali! 👋</div>
            <p class="left-sub">Yuk, lanjut belajar dari mana kamu berhenti.</p>
            <div class="login-stats">
                <div class="login-stat-card">
                    <div class="login-stat-number">19</div>
                    <div class="login-stat-label">📚 Materi tersedia</div>
                </div>
                <div class="login-stat-card">
                    <div class="login-stat-number">4 CP</div>
                    <div class="login-stat-label">📋 Capaian Pembelajaran</div>
                </div>
                <div class="login-stat-card">
                    <div class="login-stat-number">1K+</div>
                    <div class="login-stat-label">🎓 Siswa aktif</div>
                </div>
                <div class="login-stat-card">
                    <div class="login-stat-number">100%</div>
                    <div class="login-stat-label">✨ Gratis selamanya</div>
                </div>
            </div>
        </div>

        <div class="left-footer">© 2026 TKJPedia. All rights reserved.</div>
    </div>

    <!-- RIGHT -->
    <div class="login-right">
        <div class="login-form-box">
            <h1 class="form-title">Masuk</h1>
            <p class="form-subtitle">Masuk ke akunmu dan lanjut belajar</p>

            @if ($errors->any())
                <div class="alert-danger">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="alert-success">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="password-field">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()" id="toggleBtn">
                            <svg id="eyeOff" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                            <svg id="eyeOn" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

           <div class="remember-row">
    <div class="remember-left">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Ingat saya</label>
    </div>

    <a href="{{ route('password.request') }}" class="forgot-link">
        Lupa Password?
    </a>
</div>
                <button type="submit" class="btn-login">Masuk</button>
            </form>
    
            <div class="register-row">
                Tidak Punya Akun? <a href="{{ route('register') }}">Daftar</a>
            </div>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeOff = document.getElementById('eyeOff');
    const eyeOn = document.getElementById('eyeOn');
    if (input.type === 'password') {
        input.type = 'text';
        eyeOff.style.display = 'none';
        eyeOn.style.display = 'block';
    } else {
        input.type = 'password';
        eyeOff.style.display = 'block';
        eyeOn.style.display = 'none';
    }
}
</script>
@endsection