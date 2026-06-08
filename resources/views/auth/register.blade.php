@extends('layouts.app')
 
@section('title', 'Daftar - Mappy Path')
 
@push('head')
<style>
:root {
    --primary: #372466;
    --primary-light: #4e35a0;
    --accent: #7c5cbf;
    --accent-light: #a78bd4;
    --white: #ffffff;
    --gray-100: #f4f1ff;
    --gray-200: #e4e0f5;
    --gray-300: #c8bfe8;
    --gray-400: #9589b8;
    --gray-500: #6d5f9a;
    --gray-700: #332a5c;
    --gray-800: #1e1640;
    --danger: #ef4444;
    --success: #22c55e;
    --font: 'Poppins', sans-serif;
}
 
body { background: var(--white); min-height: 100vh; }
 
.register-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 100vh;
}
 
/* LEFT PANEL */
.register-left {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--accent) 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
}
.register-left::before {
    content: '';
    position: absolute;
    top: -30%; right: -20%;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.register-left::after {
    content: '';
    position: absolute;
    bottom: -20%; left: -10%;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
    pointer-events: none;
}
 
.left-header { display: flex; align-items: center; gap: 0.75rem; z-index: 1; }
.left-logo {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; color: white; font-size: 0.95rem; object-fit: contain;
}
.left-brand { font-size: 1.2rem; font-weight: 700; color: white; }
 
.left-content { z-index: 1; }
.left-tagline {
    font-size: clamp(1.3rem, 2.5vw, 1.7rem);
    font-weight: 700; color: white; line-height: 1.4; margin-bottom: 1rem;
}
.left-sub {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.75);
    line-height: 1.6; margin-bottom: 1.5rem;
}
.benefit-list { display: flex; flex-direction: column; gap: 0.75rem; }
.benefit-item {
    display: flex; align-items: center; gap: 0.75rem;
    color: rgba(255,255,255,0.9); font-size: 0.875rem;
}
.benefit-check {
    width: 24px; height: 24px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; flex-shrink: 0;
}
.left-footer { font-size: 0.78rem; color: rgba(255,255,255,0.5); z-index: 1; }
 
/* RIGHT PANEL */
.register-right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 3rem 4rem;
    background: var(--white);
    overflow-y: auto;
}
.register-form-box { width: 100%; max-width: 440px; }
 
.form-title { font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 0.4rem; }
.form-subtitle { font-size: 0.9rem; color: var(--gray-400); margin-bottom: 2rem; }
 
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
 
.form-group { margin-bottom: 1.2rem; }
.form-label {
    display: block; font-size: 0.85rem; font-weight: 600;
    color: var(--gray-700); margin-bottom: 0.45rem;
}
.form-input {
    width: 100%; padding: 0.75rem 1rem;
    border: 1.5px solid var(--gray-200); border-radius: 10px;
    font-family: var(--font); font-size: 0.875rem; color: var(--gray-800);
    background: var(--white); transition: all 0.2s; outline: none;
}
.form-input::placeholder { color: var(--gray-300); }
.form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,36,102,0.08); }
.form-input.is-invalid { border-color: var(--danger); }
 
.input-hint { font-size: 0.75rem; color: var(--gray-400); margin-top: 0.3rem; }
.input-error {
    font-size: 0.75rem; color: var(--danger); margin-top: 0.3rem;
    display: flex; align-items: center; gap: 0.25rem;
}
 
.password-field { position: relative; }
.password-toggle {
    position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%);
    cursor: pointer; color: var(--gray-400); background: none; border: none;
    padding: 0.25rem; display: flex; align-items: center; justify-content: center;
    transition: color 0.2s;
}
.password-toggle:hover { color: var(--primary); }
.password-field .form-input { padding-right: 2.8rem; }
 
.pwd-strength { margin-top: 0.5rem; }
.pwd-bars { display: flex; gap: 4px; margin-bottom: 0.25rem; }
.pwd-bar { flex: 1; height: 4px; border-radius: 2px; background: var(--gray-200); transition: background 0.3s; }
.pwd-bar.weak { background: #ef4444; }
.pwd-bar.medium { background: #f59e0b; }
.pwd-bar.strong { background: #22c55e; }
.pwd-label { font-size: 0.72rem; color: var(--gray-400); }
.pwd-label.weak { color: #ef4444; }
.pwd-label.medium { color: #f59e0b; }
.pwd-label.strong { color: #22c55e; }
 
.terms-row {
    display: flex; align-items: flex-start; gap: 0.6rem; margin-bottom: 1.5rem;
}
.terms-row input[type="checkbox"] {
    width: 16px; height: 16px; accent-color: var(--primary);
    cursor: pointer; margin-top: 2px; flex-shrink: 0;
}
.terms-row label { font-size: 0.82rem; color: var(--gray-500); line-height: 1.5; cursor: pointer; }
.terms-row label a { color: var(--primary); font-weight: 600; text-decoration: none; }
.terms-row label a:hover { text-decoration: underline; }
 
.btn-register {
    width: 100%; padding: 0.9rem; background: var(--primary);
    color: white; border: none; border-radius: 10px;
    font-family: var(--font); font-size: 1rem; font-weight: 700;
    cursor: pointer; transition: all 0.25s;
}
.btn-register:hover {
    background: var(--primary-light); transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(55,36,102,0.3);
}
.btn-register:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
 
.login-row {
    text-align: center; margin-top: 1.25rem;
    font-size: 0.875rem; color: var(--gray-400);
}
.login-row a { color: var(--primary); font-weight: 700; text-decoration: none; }
.login-row a:hover { text-decoration: underline; }
 
.alert-danger {
    background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;
    border-radius: 10px; padding: 0.85rem 1rem; font-size: 0.875rem; margin-bottom: 1.25rem;
}
.alert-danger ul { margin: 0; padding-left: 1.25rem; }
.alert-danger li { margin-bottom: 0.2rem; }
 
.step-indicator { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.75rem; }
.step-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gray-200); transition: all 0.3s; }
.step-dot.active { width: 24px; border-radius: 4px; background: var(--primary); }
.step-label { font-size: 0.78rem; color: var(--gray-400); margin-left: 0.5rem; }
 
@media (max-width: 900px) {
    .register-wrapper { grid-template-columns: 1fr; }
    .register-left { padding: 2rem; min-height: 200px; justify-content: center; gap: 1rem; }
    .left-content { text-align: center; }
    .benefit-list { display: none; }
    .left-footer { display: none; }
    .register-right { padding: 2rem 1.5rem; }
    .form-title { font-size: 1.75rem; }
}
@media (max-width: 480px) {
    .register-right { padding: 1.75rem 1.25rem; }
    .form-row { grid-template-columns: 1fr; gap: 0; }
}
</style>
@endpush
 
@section('content')
<div class="register-wrapper">
 
    <!-- LEFT PANEL -->
    <div class="register-left">
        <div class="left-header">
            <div class="left-icon">
                <img src="img/Icon1.png" alt="Logo Mappy Path">
            </div>
            <span class="left-brand"> Mappy Path</span>
        </div>
 
        <div class="left-content">
            <div class="left-tagline">Daftar untuk menggunakan MappyPath!</div>
            <p class="left-sub">Belajar, nggak perlu bingung.</p>
            <div class="benefit-list">
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    Gratis selamanya, tanpa biaya tersembunyi
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    19 Materi video
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    Roadmap belajar terstruktur sesuai kurikulum TKJ
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    Badge penyelesaian materi
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    Pantau progress belajar 
                </div>
            </div>
        </div>
 
        <div class="left-footer">© 2026 Mappy Path. All rights reserved.</div>
    </div>
 
    <!-- RIGHT PANEL -->
    <div class="register-right">
        <div class="register-form-box">
 
            <div class="step-indicator">
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
                <div class="step-dot"></div>
                <span class="step-label">Langkah 1 dari 3</span>
            </div>
 
            <h1 class="form-title">Buat Akun Baru</h1>
            <p class="form-subtitle">Daftar dan mulai perjalanan belajarmu</p>
 
            @if ($errors->any())
                <div class="alert-danger">
                    <strong>⚠️ Mohon perbaiki kesalahan berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
 
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}" autocomplete="name" required>
                    @error('name')
                        <div class="input-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}" autocomplete="email" required>
                    @error('email')
                        <div class="input-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username"
                    class="form-input {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    placeholder="Contoh: putri_dewi"
                    value="{{ old('username') }}" autocomplete="username" required>
                <div class="input-hint">Huruf kecil, angka, dan underscore saja.</div>
                @error('username')
                    <div class="input-error">⚠ {{ $message }}</div>
                @enderror
            </div>

                <div class="form-group">
                    <label class="form-label" for="jurusan">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan"
                        class="form-input {{ $errors->has('jurusan') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan jurusan"
                        value="{{ old('jurusan') }}" required>
                    @error('jurusan')
                        <div class="input-error">⚠ {{ $message }}</div>
                    @enderror
                </div>
 
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password"
                            class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Masukkan password"
                            autocomplete="new-password"
                            oninput="checkStrength(this.value)" required>
                        <button type="button" class="password-toggle" onclick="togglePass('password','eyeOff1','eyeOn1')">
                            <svg id="eyeOff1" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                            <svg id="eyeOn1" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <div class="pwd-strength" id="pwdStrength" style="display:none">
                        <div class="pwd-bars">
                            <div class="pwd-bar" id="bar1"></div>
                            <div class="pwd-bar" id="bar2"></div>
                            <div class="pwd-bar" id="bar3"></div>
                            <div class="pwd-bar" id="bar4"></div>
                        </div>
                        <span class="pwd-label" id="pwdLabel">Terlalu pendek</span>
                    </div>
                    @error('password')
                        <div class="input-error">⚠ {{ $message }}</div>
                    @enderror
                </div>
 
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-field">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-input" placeholder="Ulangi password"
                            autocomplete="new-password" required>
                        <button type="button" class="password-toggle" onclick="togglePass('password_confirmation','eyeOff2','eyeOn2')">
                            <svg id="eyeOff2" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                            <svg id="eyeOn2" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="terms-row">
                <input type="checkbox" id="terms" name="terms" value="1"
                    {{ old('terms') ? 'checked' : '' }}>
                <label for="terms">
                    Saya menyetujui
                    <a href="#">syarat & ketentuan</a>
                    yang berlaku.
                </label>
            </div>
            @error('terms')
                <div class="input-error" style="margin-top:-1rem; margin-bottom:1rem;">⚠ {{ $message }}</div>
            @enderror
 
                <button type="submit" class="btn-register">
                    Daftar Sekarang
                </button>
            </form>
 
            <div class="login-row">
                Sudah Punya Akun? <a href="{{ route('login') }}">Masuk</a>
            </div>
 
        </div>
    </div>
 
</div>
 
<script>
function togglePass(inputId, offId, onId) {
    const input = document.getElementById(inputId);
    const eyeOff = document.getElementById(offId);
    const eyeOn = document.getElementById(onId);
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
 
function checkStrength(val) {
    const strengthDiv = document.getElementById('pwdStrength');
    const label = document.getElementById('pwdLabel');
    const bars = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4'),
    ];
    if (val.length === 0) { strengthDiv.style.display = 'none'; return; }
    strengthDiv.style.display = 'block';
    bars.forEach(b => { b.className = 'pwd-bar'; });
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = ['weak', 'weak', 'medium', 'strong'];
    const labels = ['Terlalu pendek', 'Lemah', 'Sedang', 'Kuat 💪'];
    for (let i = 0; i < score; i++) { bars[i].classList.add(levels[score - 1]); }
    label.textContent = score === 0 ? 'Terlalu pendek' : labels[score - 1];
    label.className = 'pwd-label ' + (score === 0 ? 'weak' : levels[score - 1]);
}
</script>
@endsection