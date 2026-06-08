@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@push('styles')
<style>
  .page-title {
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--gray-800);
    letter-spacing: -.5px;
  }
  .page-sub {
    font-size: .9rem;
    color: var(--gray-400);
    margin-top: .25rem;
    margin-bottom: 2rem;
    font-weight: 400;
  }

  .sett-card {
    background: var(--white);
    border: 1.5px solid var(--gray-200);
    border-radius: 20px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    box-shadow: var(--shadow);
    animation: fadeUp .45s ease both;
    width: 100%;
  }
  .sett-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 1.25rem 1.5rem;
    border-bottom: 1.5px solid var(--gray-200);
    background: linear-gradient(to right, var(--gray-100), var(--white));
  }
  .sett-card-icon {
    width: 40px; height: 40px;
    background: var(--white);
    border: 1.5px solid var(--gray-300);
    border-radius: 11px;
    display: grid; place-items: center;
    font-size: 16px;
    box-shadow: 0 2px 10px rgba(55,36,102,0.08);
  }
  .sett-card-title    { font-size: .95rem; font-weight: 700; color: var(--gray-800); }
  .sett-card-subtitle { font-size: .78rem; color: var(--gray-400); margin-top: 1px; }
  .sett-card-body     { padding: 1.5rem; }

  /* ── PROFILE ── */
  .profile-layout {
    display: flex;
    align-items: flex-start;
    gap: 2rem;
  }
  .avatar-wrap {
    display: flex; flex-direction: column;
    align-items: center; gap: 10px;
    flex-shrink: 0;
  }
  .avatar-ring {
    width: 96px; height: 96px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, var(--primary), var(--accent), #a78bd4);
    box-shadow: 0 4px 20px rgba(55,36,102,0.25);
    cursor: pointer;
    position: relative;
  }
  .avatar-ring:hover .avatar-overlay { opacity: 1; }
  .avatar-inner {
    width: 100%; height: 100%;
    border-radius: 50%;
    border: 3px solid var(--white);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--gray-300), var(--gray-100));
    font-size: 2rem;
    position: relative;
  }
  .avatar-inner img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
  }
  .avatar-overlay {
    position: absolute; inset: 3px;
    border-radius: 50%;
    background: rgba(55,36,102,0.55);
    display: flex; align-items: center; justify-content: center;
    opacity: 0;
    transition: opacity .2s;
    color: white;
    font-size: .65rem;
    font-weight: 700;
    flex-direction: column;
    gap: 3px;
  }
  .avatar-overlay svg { width: 18px; height: 18px; }

  .avatar-btn {
    font-size: .78rem; font-weight: 600;
    color: var(--primary);
    background: var(--gray-100);
    border: 1.5px solid var(--gray-300);
    border-radius: 8px;
    padding: 5px 14px;
    cursor: pointer;
    transition: background .2s, box-shadow .2s;
    font-family: var(--font);
    white-space: nowrap;
  }
  .avatar-btn:hover { background: var(--gray-200); box-shadow: 0 2px 10px rgba(55,36,102,.12); }

  /* hidden file input */
  #fotoInput { display: none; }

  .profile-fields { flex: 1; display: flex; flex-direction: column; gap: 1rem; }

  .field-group   { display: flex; flex-direction: column; gap: 5px; }
  .field-label   { font-size: .8rem; font-weight: 600; color: var(--gray-500); }
  .field-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--gray-200);
    border-radius: 10px;
    font-size: .88rem;
    font-family: var(--font);
    color: var(--gray-800);
    background: var(--gray-100);
    transition: border .2s, box-shadow .2s, background .2s;
    outline: none;
  }
  .field-input:focus {
    border-color: var(--primary);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(55,36,102,.1);
  }
  .field-input::placeholder { color: var(--gray-400); }

  /* ── ACTION ── */
  .action-row {
    display: flex; gap: .75rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
    animation: fadeUp .45s .1s ease both;
  }
  .btn-save {
    padding: 11px 28px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: var(--font);
    font-size: .88rem; font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(55,36,102,.3);
    transition: box-shadow .2s, transform .15s, filter .2s;
  }
  .btn-save:hover { box-shadow: 0 6px 24px rgba(55,36,102,.4); transform: translateY(-1px); filter: brightness(1.08); }
  .btn-save:active { transform: translateY(0); }
  .btn-save:disabled { opacity: .7; cursor: not-allowed; transform: none; }

  .btn-cancel {
    padding: 11px 28px;
    background: var(--gray-100);
    color: var(--gray-500);
    border: 1.5px solid var(--gray-200);
    border-radius: 10px;
    font-family: var(--font);
    font-size: .88rem; font-weight: 600;
    cursor: pointer;
    transition: background .2s, border-color .2s;
  }
  .btn-cancel:hover { background: var(--gray-200); border-color: var(--gray-300); }

  /* ── TOAST ── */
  .toast {
    position: fixed;
    bottom: 30px; left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: var(--gray-800);
    color: #fff;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: .82rem; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
    box-shadow: 0 8px 30px rgba(0,0,0,.18);
    transition: transform .35s cubic-bezier(.4,0,.2,1), opacity .35s;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
  }
  .toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 640px) {
    .profile-layout { flex-direction: column; align-items: center; gap: 1.25rem; }
    .profile-fields { width: 100%; }
    .sett-card-body { padding: 1rem; }
    .action-row { flex-direction: column; }
    .btn-save, .btn-cancel { width: 100%; text-align: center; }
  }
</style>
@endpush

@section('content')

<div class="page-title">Pengaturan</div>
<div class="page-sub">Kelola preferensi dan akun Anda</div>

@if(session('success'))
  <div style="background:#e7fff1;border:1.5px solid #a7f3d0;color:#065f46;padding:.85rem 1.2rem;border-radius:12px;font-size:.85rem;font-weight:600;margin-bottom:1.25rem;">
    ✓ &nbsp;{{ session('success') }}
  </div>
@endif
@if($errors->any())
  <div style="background:#fef2f2;border:1.5px solid #fecaca;color:#991b1b;padding:.85rem 1.2rem;border-radius:12px;font-size:.85rem;font-weight:600;margin-bottom:1.25rem;">
    ✕ &nbsp;{{ $errors->first() }}
  </div>
@endif

<div class="sett-card">
  <div class="sett-card-header">
    <div class="sett-card-icon">👤</div>
    <div>
      <div class="sett-card-title">Profil</div>
      <div class="sett-card-subtitle">Informasi akun Anda</div>
    </div>
  </div>
  <div class="sett-card-body">

    {{-- Form pakai enctype multipart supaya bisa upload foto --}}
    <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
      @csrf
      @method('PUT')

      {{-- Hidden input file foto --}}
      <input type="file" id="fotoInput" name="foto" accept="image/*" onchange="previewFoto(this)">

      <div class="profile-layout">

        {{-- AVATAR --}}
        <div class="avatar-wrap">
          <div class="avatar-ring" onclick="document.getElementById('fotoInput').click()" title="Klik untuk ganti foto">
            <div class="avatar-inner" id="avatarInner">
              @if(Auth::user()->foto)
                <img id="avatarImg" src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil">
              @else
                <span id="avatarEmoji">👩‍💻</span>
              @endif
            </div>
            <div class="avatar-overlay">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
                <circle cx="12" cy="13" r="4"/>
              </svg>
              Ganti Foto
            </div>
          </div>
          <button type="button" class="avatar-btn" onclick="document.getElementById('fotoInput').click()">Ubah Foto</button>
          @if(Auth::user()->foto)
            <button type="button" class="avatar-btn" style="color:#dc2626;border-color:#fecaca;background:#fef2f2;"
              onclick="hapusFoto()">Hapus Foto</button>
            <input type="hidden" name="hapus_foto" id="hapusFotoInput" value="0">
          @endif
        </div>

        {{-- FIELDS --}}
        <div class="profile-fields">
          <div class="field-group">
            <label class="field-label" for="nama">Nama Lengkap</label>
            <input class="field-input" id="nama" name="name" type="text"
              placeholder="Nama lengkap Anda"
              value="{{ old('name', Auth::user()->name) }}" required>
          </div>
          <div class="field-group">
            <label class="field-label" for="email">Email</label>
            <input class="field-input" id="email" name="email" type="email"
              placeholder="email@contoh.com"
              value="{{ old('email', Auth::user()->email) }}" required>
          </div>
          <div class="field-group">
            <label class="field-label" for="jurusan">Jurusan</label>
            <input class="field-input" id="jurusan" name="jurusan" type="text"
              placeholder="Jurusan Anda"
              value="{{ old('jurusan', Auth::user()->jurusan ?? '') }}">
          </div>
        </div>
      </div>

      <div class="action-row">
        <button type="submit" class="btn-save" id="btnSave">✓ &nbsp;Simpan Perubahan</button>
        <button type="button" class="btn-cancel" onclick="resetForm()">Batalkan</button>
      </div>

    </form>
  </div>
</div>

<div class="toast" id="toast">
  <span id="toastIcon">✓</span>
  <span id="toastMsg">Perubahan berhasil disimpan!</span>
</div>

@endsection

@push('scripts')
<script>
  const origName    = @json(Auth::user()->name);
  const origEmail   = @json(Auth::user()->email);
  const origJurusan = @json(Auth::user()->jurusan ?? '');

  // Preview foto sebelum upload
  function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    if (file.size > 2 * 1024 * 1024) {
      showToast('Ukuran foto maksimal 2MB', '⚠️');
      input.value = '';
      return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
      const inner = document.getElementById('avatarInner');
      inner.innerHTML = `<img id="avatarImg" src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
    showToast('Foto dipilih, klik Simpan untuk menyimpan', '📸');
  }

  // Hapus foto
  function hapusFoto() {
    document.getElementById('avatarInner').innerHTML = '<span id="avatarEmoji">👩‍💻</span>';
    const hInput = document.getElementById('hapusFotoInput');
    if (hInput) hInput.value = '1';
    document.getElementById('fotoInput').value = '';
    showToast('Foto akan dihapus saat kamu simpan', '🗑️');
  }

  // Reset form
  function resetForm() {
    document.getElementById('nama').value    = origName;
    document.getElementById('email').value   = origEmail;
    document.getElementById('jurusan').value = origJurusan;
    document.getElementById('fotoInput').value = '';
    showToast('Perubahan dibatalkan', '↩');
  }

  // Loading saat submit
  document.getElementById('profileForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSave');
    btn.innerHTML = '⏳ &nbsp;Menyimpan...';
    btn.disabled = true;
  });

  // Toast
  let toastTimer;
  function showToast(msg, icon = '✓') {
    document.getElementById('toastMsg').textContent = msg;
    document.getElementById('toastIcon').textContent = icon;
    const t = document.getElementById('toast');
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
  }

  @if(session('success'))
    showToast(@json(session('success')), '✓');
  @endif
</script>
@endpush