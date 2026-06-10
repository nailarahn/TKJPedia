@extends('layouts.dashboard')

@section('title', isset($target) ? 'Edit Target' : 'Tambah Target')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
  .page-hdr { margin-bottom: 24px; }
  .page-hdr h1 { font-size: 28px; font-weight: 800; color: var(--gray-800); }
  .page-hdr p  { color: var(--gray-400); font-size: 14px; margin-top: 4px; }

  .btn-back {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--gray-100); color: var(--primary);
    border: 1.5px solid var(--gray-200); border-radius: 10px;
    padding: 9px 18px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all .2s; margin-bottom: 24px;
  }
  .btn-back:hover { background: var(--gray-200); color: var(--primary); }
  .btn-back svg { width: 16px; height: 16px; }

  .form-card {
    background: #fff; border-radius: 16px;
    border: 1.5px solid var(--gray-200);
    padding: 32px 36px; max-width: 860px;
    box-shadow: var(--shadow);
  }

  .field { margin-bottom: 24px; }
  .field-lbl { display: block; font-size: 14px; font-weight: 700; color: var(--gray-800); margin-bottom: 8px; }
  .field-hint { font-size: 12px; color: var(--gray-400); margin-top: 5px; display: block; }

  .f-input, .f-select, .f-textarea {
    width: 100%; padding: 12px 15px;
    border: 1.5px solid var(--gray-200); border-radius: 10px;
    font-size: 14px; color: var(--gray-800);
    background: #fff; outline: none;
    transition: border-color .2s, box-shadow .2s;
  }
  .f-input:focus, .f-select:focus, .f-textarea:focus {
    border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,36,102,.08);
  }
  .f-select { appearance: none; -webkit-appearance: none; cursor: pointer; }

  .f-input[readonly]:not(#deadline):not(#start_date) {
    background: var(--gray-100);
    color: var(--gray-600);
    cursor: not-allowed;
  }

  .sel-wrap { position: relative; }
  .sel-wrap.has-arrow::after {
    content: ''; position: absolute; right: 15px; top: 50%;
    transform: translateY(-50%); pointer-events: none;
    width: 0; height: 0;
    border-left: 5px solid transparent; border-right: 5px solid transparent;
    border-top: 6px solid var(--gray-400);
  }
  .sel-wrap.has-calendar::after {
    content: '';
    position: absolute; right: 14px; top: 50%;
    transform: translateY(-50%); pointer-events: none;
    width: 18px; height: 18px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af' stroke-width='2'%3E%3Crect x='3' y='4' width='18' height='18' rx='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: contain;
  }

  .f-input[type="number"] { -moz-appearance: textfield; }
  .f-input[type="number"]::-webkit-inner-spin-button,
  .f-input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }

  .err-msg { font-size: 12px; font-weight: 600; color: #dc2626; margin-top: 5px; display: none; }

  .btn-save {
    width: 100%; padding: 14px; border-radius: 10px; border: none;
    font-size: 15px; font-weight: 700; cursor: pointer; transition: all .2s; margin-top: 6px;
  }
  .btn-save:disabled { background: var(--gray-200); color: var(--gray-400); cursor: not-allowed; }
  .btn-save:not(:disabled) { background: var(--primary); color: #fff; box-shadow: 0 4px 16px rgba(55,36,102,.25); }
  .btn-save:not(:disabled):hover { background: var(--primary-light); transform: translateY(-1px); }

  /* DATE PICKERS - CLICKABLE */
  #start_date, #deadline {
    cursor: pointer !important;
    background-color: #fff !important;
    padding-right: 40px !important;
  }

  /* ── Flatpickr base ── */
  .flatpickr-calendar {
    border-radius: 16px !important;
    box-shadow: 0 12px 40px rgba(255,107,0,.18) !important;
    border: 2px solid #ffb347 !important;
    font-family: inherit !important;
    overflow: visible !important;
    position: absolute !important;
    z-index: 99999 !important;
  }
  .flatpickr-day.selected,
  .flatpickr-day.selected:hover {
    background: linear-gradient(135deg, #ff6b00, #ff9f43) !important;
    border-color: #ff6b00 !important;
    box-shadow: 0 2px 8px rgba(255,107,0,.4) !important;
    font-weight: 700 !important;
  }
  .flatpickr-day:hover:not(.selected) {
    background: rgba(255,107,0,.1) !important;
    border-color: #ffb347 !important;
  }
  .flatpickr-day.today:not(.selected) {
    border-color: #ff6b00 !important;
    color: #ff6b00 !important;
    font-weight: 700 !important;
  }
  .flatpickr-months .flatpickr-month,
  .flatpickr-weekdays,
  span.flatpickr-weekday {
    background: linear-gradient(135deg, #ff6b00, #ff9f43) !important;
    color: #fff !important;
    font-weight: 700 !important;
  }
  .flatpickr-months .flatpickr-month { border-radius: 0 !important; }
  .flatpickr-current-month .flatpickr-monthDropdown-months,
  .flatpickr-current-month input.cur-year { color: #fff !important; font-weight: 700 !important; }
  .flatpickr-prev-month svg,
  .flatpickr-next-month svg { fill: #fff !important; }
  .flatpickr-prev-month:hover svg,
  .flatpickr-next-month:hover svg { fill: #ffe0b2 !important; }

  /* ── Rocket inside calendar ── */
  .cal-rocket-wrap {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 10;
    border-radius: 14px;
  }
  .cal-rocket {
    position: absolute;
    font-size: 22px;
    line-height: 1;
    top: 50%;
    transform: translateY(-50%);
  }
  @keyframes calFly {
    0%   { left: -40px; opacity: 0; }
    6%   { opacity: 1; }
    92%  { opacity: 1; }
    100% { left: 108%; opacity: 0; }
  }
  @keyframes calPuff {
    0%   { opacity: .7; transform: scale(.5) translateY(0); }
    100% { opacity: 0;  transform: scale(1.6) translateY(-10px); }
  }
  .cal-smoke {
    position: absolute;
    font-size: 11px;
    pointer-events: none;
  }
  @keyframes starPop {
    0%   { opacity: 0; transform: scale(0) rotate(0deg); }
    50%  { opacity: 1; transform: scale(1.3) rotate(180deg); }
    100% { opacity: 0; transform: scale(0) rotate(360deg); }
  }
  .cal-star {
    position: absolute;
    font-size: 10px;
    pointer-events: none;
    z-index: 11;
    animation: starPop .8s ease-out forwards;
  }
  .flatpickr-day.selected::after {
    content: '🚀';
    position: absolute;
    top: -8px; right: -6px;
    font-size: 10px;
    line-height: 1;
    pointer-events: none;
  }
  .flatpickr-day.selected { position: relative !important; overflow: visible !important; }

  .toast {
    position: fixed; bottom: 22px; right: 22px;
    padding: 11px 16px; border-radius: 11px;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
    z-index: 999; opacity: 0; transform: translateY(12px);
    transition: all .3s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 8px 24px rgba(0,0,0,.12); max-width: 280px;
  }
  .toast.show    { opacity: 1; transform: translateY(0); }
  .toast.success { background: #059669; color: #fff; }
  .toast.error   { background: #ef4444; color: #fff; }

  @media (max-width: 560px) {
    .page-hdr h1 { font-size: 20px; }
    .form-card { padding: 20px 16px; }
    .date-row { flex-direction: column !important; }
  }
</style>
@endpush

@section('content')

<div class="page-hdr">
  <h1>Target Belajar Mingguan</h1>
  <p>Tentukan apa yang ingin kamu capai minggu ini</p>
</div>

<a href="{{ route('target') }}" class="btn-back">
  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
    <polyline points="15 18 9 12 15 6"/>
  </svg>
  Kembali
</a>

<div class="form-card">
  <form id="targetForm" method="POST"
        action="{{ isset($target) ? route('target.update', $target->id) : route('target.store') }}">
    @csrf
    @if(isset($target)) @method('PUT') @endif

{{-- Field 1: jenis target --}}
<div class="field">
  <label class="field-lbl" for="target_type">Apa yang ingin kamu capai?</label>
  <div class="sel-wrap has-arrow">
    <select class="f-select" id="target_type" name="name" required>
      <option value="">-- Pilih jenis target --</option>
      <option value="Menyelesaikan Materi Video"
        {{ old('name', $target->name ?? '') == 'Menyelesaikan Materi Video' ? 'selected' : '' }}>
        🎬 Menyelesaikan Materi Video
      </option>
      <option value="Menyelesaikan Kuis"
        {{ old('name', $target->name ?? '') == 'Menyelesaikan Kuis' ? 'selected' : '' }}>
        📝 Menyelesaikan Kuis
      </option>
    </select>
  </div>
  <span class="field-hint">Pilih jenis target yang ingin kamu capai minggu ini</span>
</div>

{{-- Field 2: pilih roadmap --}}
<div class="field">
  <label class="field-lbl" for="roadmap_id">Roadmap Terkait</label>
  <div class="sel-wrap has-arrow">
    <select class="f-select" id="roadmap_id" name="roadmap_id">
      <option value="">-- Tidak terkait roadmap --</option>
      @foreach($roadmaps as $roadmap)
        <option value="{{ $roadmap->id }}"
          {{ old('roadmap_id', $target->roadmap_id ?? '') == $roadmap->id ? 'selected' : '' }}>
          {{ $roadmap->title }}
        </option>
      @endforeach
    </select>
  </div>
  <span class="field-hint">Hubungkan target ini dengan roadmap yang sedang kamu pelajari</span>
</div>

{{-- Field 3: jumlah --}}
<div class="field">
  <label class="field-lbl" for="target_value">Berapa Banyak?</label>
  <input type="number" class="f-input" id="target_value" name="target_value"
         min="1" max="999" placeholder="Contoh : 3"
         value="{{ old('target_value', $target->target_value ?? '') }}"
         autocomplete="off" required>
  <span class="field-hint">Jumlah materi yang ingin diselesaikan</span>
  @error('target_value')
    <span class="err-msg" style="display:block">{{ $message }}</span>
  @enderror
  <span class="err-msg" id="valErr">Wajib masukkan jumlah (minimal 1)</span>
</div>

{{-- Field 4: durasi target --}}
<div class="field">
  <label class="field-lbl">Durasi Target</label>
  <div class="date-row" style="display: flex; gap: 12px;">
    <div style="flex: 1;">
      <div class="sel-wrap has-calendar">
        <input type="text" class="f-input" id="start_date" name="start_date"
               placeholder="Tanggal mulai..."
               value="{{ old('start_date', isset($target) ? $target->start_date?->format('Y-m-d') : '') }}"
               autocomplete="off">
      </div>
      <span class="field-hint">Tanggal mulai</span>
      <span class="err-msg" id="startErr">Wajib pilih tanggal mulai</span>
    </div>
    <div style="flex: 1;">
      <div class="sel-wrap has-calendar">
        <input type="text" class="f-input" id="deadline" name="deadline"
               placeholder="Tanggal selesai..."
               value="{{ old('deadline', isset($target) ? $target->deadline?->format('Y-m-d') : '') }}"
               autocomplete="off">
      </div>
      <span class="field-hint">Tanggal selesai</span>
      <span class="err-msg" id="deadlineErr">Wajib pilih tanggal selesai</span>
    </div>
  </div>
</div>

<button class="btn-save" type="submit" id="saveBtn" disabled>
  {{ isset($target) ? 'Update Target' : 'Simpan Target' }}
</button>
  </form>
</div>

<div class="toast" id="toast"></div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('✅ DOM Ready - Initializing date pickers...');
  
  const valEl       = document.getElementById('target_value');
  const startEl     = document.getElementById('start_date');
  const deadlineEl  = document.getElementById('deadline');
  const saveBtn     = document.getElementById('saveBtn');
  const valErr      = document.getElementById('valErr');
  const startErr    = document.getElementById('startErr');
  const deadlineErr = document.getElementById('deadlineErr');

  // ── Rocket animation ──
  function launchCalendarRocket(calEl) {
    if (!calEl || calEl.querySelector('.cal-rocket-wrap')) return;

    const wrap = document.createElement('div');
    wrap.className = 'cal-rocket-wrap';
    calEl.appendChild(wrap);

    const rocket = document.createElement('div');
    rocket.className = 'cal-rocket';
    rocket.textContent = '🚀';
    rocket.style.animation = 'calFly 1.4s cubic-bezier(.3,0,.5,1) forwards';
    wrap.appendChild(rocket);

    ['💨','💨','💨','💨'].forEach((s, i) => {
      setTimeout(() => {
        const smoke = document.createElement('div');
        smoke.className = 'cal-smoke';
        smoke.textContent = s;
        smoke.style.top  = (42 + Math.random() * 6) + '%';
        smoke.style.left = (8 + i * 14) + 'px';
        smoke.style.animation = 'calPuff .6s ease-out forwards';
        wrap.appendChild(smoke);
        setTimeout(() => smoke.remove(), 700);
      }, 80 + i * 140);
    });

    const stars = ['✨','⭐','🌟','✨','⭐'];
    stars.forEach((s, i) => {
      setTimeout(() => {
        const star = document.createElement('div');
        star.className = 'cal-star';
        star.textContent = s;
        star.style.top  = (8 + Math.random() * 22) + 'px';
        star.style.left = (20 + Math.random() * 200) + 'px';
        calEl.appendChild(star);
        setTimeout(() => star.remove(), 900);
      }, i * 120);
    });

    setTimeout(() => {
      if (wrap.parentNode) wrap.remove();
    }, 1600);
  }

  const today = new Date();
  today.setHours(0,0,0,0);

  const fpConfig = {
    locale: "id",
    dateFormat: "Y-m-d",
    minDate: today,
    disableMobile: false,
    onOpen: function(_d, _s, instance) {
      setTimeout(() => launchCalendarRocket(instance.calendarContainer), 60);
    }
  };

  // START DATE PICKER
  const startPicker = flatpickr("#start_date", {
    ...fpConfig,
    onChange: function(selectedDates, dateStr) {
      console.log('Start date changed:', dateStr);
      startErr.style.display = 'none';
      startEl.style.borderColor = '';
      if (selectedDates.length && deadlinePicker) {
        deadlinePicker.set('minDate', selectedDates[0]);
      }
      check();
    },
    onClose: function(selectedDates) {
      if (!selectedDates.length) {
        startErr.style.display = 'block';
        startEl.style.borderColor = '#dc2626';
      }
      check();
    }
  });

  // DEADLINE DATE PICKER
  const deadlinePicker = flatpickr("#deadline", {
    ...fpConfig,
    onChange: function(selectedDates, dateStr) {
      console.log('Deadline changed:', dateStr);
      deadlineErr.style.display = 'none';
      deadlineEl.style.borderColor = '';
      check();
    },
    onClose: function(selectedDates) {
      if (!selectedDates.length) {
        deadlineErr.style.display = 'block';
        deadlineEl.style.borderColor = '#dc2626';
      }
      check();
    }
  });

  // VALIDATION CHECK
  function check() {
    const v  = parseInt(valEl.value);
    const ok = valEl.value !== '' && v >= 1 && startEl.value !== '' && deadlineEl.value !== '';
    saveBtn.disabled = !ok;
    console.log('Form valid:', ok);
  }

  // QUANTITY INPUT LISTENER
  valEl.addEventListener('input', () => {
    const v = parseInt(valEl.value);
    if (!valEl.value || v < 1) {
      valEl.style.borderColor = '#dc2626';
      valErr.style.display = 'block';
    } else {
      valEl.style.borderColor = '';
      valErr.style.display = 'none';
    }
    check();
  });

  check();

  @if($errors->any())
    showToast('Periksa kembali form kamu.', 'error');
  @endif

  function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
    t.className = `toast ${type} show`;
    setTimeout(() => t.classList.remove('show'), 3500);
  }

  console.log('🚀 Date pickers initialized successfully!');
  console.log('Start picker:', startPicker);
  console.log('Deadline picker:', deadlinePicker);
});
</script>
@endpush