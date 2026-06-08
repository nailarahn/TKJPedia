@extends('layouts.dashboard')

@section('title', 'Target Belajar')

@push('styles')
<style>
  .page-hdr { margin-bottom: 24px; }
  .page-hdr h1 { font-size: 28px; font-weight: 800; color: var(--gray-800); }
  .page-hdr p  { color: var(--gray-400); font-size: 14px; margin-top: 4px; }

  .btn-add {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--primary);
    color: #fff; border: none; border-radius: 12px;
    padding: 12px 22px; font-size: 14px; font-weight: 600;
    text-decoration: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(55,36,102,.25);
    transition: all .2s; margin-bottom: 28px;
  }
  .btn-add:hover { background: var(--primary-light); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(55,36,102,.35); color: #fff; }
  .btn-add-plus {
    width: 22px; height: 22px; border-radius: 6px;
    background: rgba(255,255,255,.22);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700; line-height: 1;
  }

  .section-title { font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 14px; }

  .empty-card {
    background: #fff; border-radius: 16px;
    border: 1.5px solid var(--gray-200);
    padding: 72px 40px; text-align: center;
  }
  .empty-icon-wrap {
    width: 76px; height: 76px; border-radius: 50%;
    background: var(--gray-100);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
  }
  .empty-icon-wrap svg { width: 34px; height: 34px; color: var(--primary); }
  .empty-card h3 { font-size: 17px; font-weight: 700; margin-bottom: 8px; color: var(--gray-800); }
  .empty-card p  { color: var(--gray-400); font-size: 13px; max-width: 320px; margin: 0 auto; line-height: 1.6; }

  .targets-list { display: flex; flex-direction: column; gap: 12px; }

  .t-card {
    background: #fff; border-radius: 16px;
    border: 1.5px solid var(--gray-200);
    padding: 20px 24px;
    transition: box-shadow .2s, transform .2s;
  }
  .t-card:hover { box-shadow: 0 6px 24px rgba(55,36,102,.08); transform: translateY(-1px); }

  .t-top {
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px; margin-bottom: 16px;
  }
  .t-left { display: flex; align-items: center; gap: 14px; }

  .t-icon {
    width: 48px; height: 48px; border-radius: 14px;
    background: var(--gray-100);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .t-icon svg { width: 24px; height: 24px; color: var(--primary); }

  .t-name { font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 4px; }
  .t-date { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--gray-400); font-weight: 500; }
  .t-date svg { width: 13px; height: 13px; }

  .t-actions { display: flex; gap: 8px; flex-shrink: 0; }
  .btn-act {
    width: 34px; height: 34px; border-radius: 8px;
    border: 1.5px solid var(--gray-200); background: transparent;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--gray-400); transition: all .2s; text-decoration: none;
  }
  .btn-act.edit:hover { background: var(--gray-100); color: var(--primary); border-color: var(--gray-300); }
  .btn-act.del:hover  { background: #fef2f2; color: #dc2626; border-color: #fca5a5; }
  .btn-act svg { width: 15px; height: 15px; }

  .t-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 14px; }
  .t-stat { background: var(--gray-100); border-radius: 10px; padding: 12px; text-align: center; }
  .t-stat .sv { font-size: 22px; font-weight: 800; line-height: 1; margin-bottom: 4px; }
  .t-stat .sl { font-size: 11px; color: var(--gray-400); font-weight: 600; }
  .sv.purple { color: var(--primary); }
  .sv.blue   { color: var(--info); }
  .sv.green  { color: var(--success); }

  .t-prog-hdr { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
  .t-prog-hdr .pl { font-size: 12px; font-weight: 500; color: var(--gray-400); }
  .t-prog-hdr .pr { font-size: 12px; font-weight: 700; color: var(--gray-600); }

  .prog-track { width: 100%; height: 7px; background: var(--gray-200); border-radius: 99px; overflow: hidden; }
  .prog-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--accent-light));
    border-radius: 99px; width: 0%;
    transition: width 1.2s cubic-bezier(.4,0,.2,1);
  }

  .t-status {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600; padding: 3px 9px;
    border-radius: 20px; margin-top: 10px;
  }
  .s-done     { background: #dcfce7; color: #15803d; }
  .s-almost   { background: #fef3c7; color: #92400e; }
  .s-progress { background: var(--gray-100); color: var(--primary); }
  .s-start    { background: #f3f4f6; color: #6b7280; }

  .modal-wrap {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.4); backdrop-filter: blur(4px);
    z-index: 500; align-items: center; justify-content: center;
  }
  .modal-wrap.open { display: flex; }
  .modal-box {
    background: #fff; border-radius: 20px; padding: 32px;
    max-width: 380px; width: 92%; text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
    animation: scaleIn .2s cubic-bezier(.34,1.56,.64,1);
  }
  .modal-emoji { font-size: 44px; margin-bottom: 12px; display: block; }
  .modal-box h3 { font-size: 18px; font-weight: 700; margin-bottom: 6px; }
  .modal-box p  { color: var(--gray-400); font-size: 13px; margin-bottom: 22px; line-height: 1.6; }
  .modal-btns { display: flex; gap: 10px; }
  .btn-cancel, .btn-del {
    flex: 1; padding: 11px; border-radius: 10px;
    font-size: 14px; font-weight: 600; cursor: pointer; border: none;
    transition: all .2s;
  }
  .btn-cancel { background: var(--gray-100); color: var(--gray-700); }
  .btn-cancel:hover { background: var(--gray-200); }
  .btn-del { background: #ef4444; color: #fff; }
  .btn-del:hover { background: #dc2626; }

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

  @keyframes scaleIn { from { opacity:0; transform:scale(.9); } to { opacity:1; transform:scale(1); } }

  @media (max-width: 560px) {
    .page-hdr h1 { font-size: 20px; }
    .btn-add { width: 100%; justify-content: center; }
    .t-card { padding: 14px; }
    .t-stat .sv { font-size: 18px; }
  }
</style>
@endpush

@section('content')

@if(session('success'))
  <div id="flashMsg" data-msg="{{ session('success') }}" data-type="success" hidden></div>
@endif
@if(session('error'))
  <div id="flashMsg" data-msg="{{ session('error') }}" data-type="error" hidden></div>
@endif

<div class="page-hdr">
  <h1>Target Belajar Mingguan</h1>
  <p>Tentukan apa yang ingin kamu capai minggu ini</p>
</div>

<a href="{{ route('target.create') }}" class="btn-add">
  <div class="btn-add-plus">+</div>
  Tambah Target
</a>

@if($targets->isEmpty())
  <div class="empty-card">
    <div class="empty-icon-wrap">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <circle cx="12" cy="12" r="3"/><path d="M12 1v4m0 14v4M1 12h4m14 0h4m-4.22-6.78l-2.83 2.83M6.05 17.95l-2.83 2.83m0-14.14l2.83 2.83M17.95 17.95l2.83 2.83"/>
      </svg>
    </div>
    <h3>Belum Ada Target Minggu ini</h3>
    <p>Atur target pertamamu di atas untuk memulai perjalanan belajar minggu ini</p>
  </div>

@else
  <div class="section-title">Target Aktif</div>
  <div class="targets-list">
    @foreach($targets as $target)
      @php
        $progress = $target->getProgressPercent();
        $sisa     = max(0, $target->target_value - $target->current_value);
        if ($progress >= 100)    { $sc = 's-done';     $st = '✅ Selesai!'; }
        elseif ($progress >= 50) { $sc = 's-almost';   $st = '🔥 Hampir Selesai'; }
        elseif ($progress > 0)   { $sc = 's-progress'; $st = '⚡ Sedang Berjalan'; }
        else                      { $sc = 's-start';    $st = '⏳ Belum Dimulai'; }
        $deadlineLabel = '';
        if ($target->deadline) {
          $end   = $target->deadline;
          $start = $target->start_date ?? $end->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
          $deadlineLabel = $start->translatedFormat('j M') . ' - ' . $end->translatedFormat('j M Y');
        }
      @endphp
      <div class="t-card">
        <div class="t-top">
          <div class="t-left">
            <div class="t-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="3"/><path d="M12 1v4m0 14v4M1 12h4m14 0h4m-4.22-6.78l-2.83 2.83M6.05 17.95l-2.83 2.83m0-14.14l2.83 2.83M17.95 17.95l2.83 2.83"/>
              </svg>
            </div>
            <div>
              <div class="t-name">{{ $target->name }} {{ $target->target_value }} Materi</div>
              @if($target->roadmap)
                <div class="t-date" style="margin-bottom: 3px;">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                  </svg>
                  {{ $target->roadmap->title }}
                </div>
              @endif
              @if($target->deadline)
                <div class="t-date">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                  </svg>
                  {{ $deadlineLabel }}
                </div>
              @endif
            </div>
          </div>
          <div class="t-actions">
            <a href="{{ route('target.edit', $target->id) }}" class="btn-act edit" title="Edit">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </a>
            <button class="btn-act del"
                    onclick="confirmDelete({{ $target->id }}, '{{ addslashes($target->name) }}')"
                    title="Hapus">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="t-stats">
          <div class="t-stat"><div class="sv purple">{{ $target->target_value }}</div><div class="sl">Target</div></div>
          <div class="t-stat"><div class="sv blue">{{ $target->current_value }}</div><div class="sl">Selesai</div></div>
          <div class="t-stat"><div class="sv green">{{ $sisa }}</div><div class="sl">Tersisa</div></div>
        </div>
        <div class="t-prog-hdr">
          <span class="pl">Progress</span>
          <span class="pr">{{ $progress }}%</span>
        </div>
        <div class="prog-track">
          <div class="prog-fill" data-pct="{{ $progress }}"></div>
        </div>
        <span class="t-status {{ $sc }}">{{ $st }}</span>
      </div>
    @endforeach
  </div>
@endif

<div class="modal-wrap" id="deleteModal">
  <div class="modal-box">
    <span class="modal-emoji">🗑️</span>
    <h3>Hapus Target?</h3>
    <p id="modalText">Tindakan ini tidak bisa dibatalkan.</p>
    <div class="modal-btns">
      <button class="btn-cancel" onclick="closeModal()">Batal</button>
      <form id="deleteForm" method="POST" style="flex:1">
        @csrf @method('DELETE')
        <button type="submit" class="btn-del" style="width:100%">Hapus</button>
      </form>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>
@endsection

@push('scripts')
<script>
  window.addEventListener('load', () => {
    document.querySelectorAll('.prog-fill').forEach(b => {
      setTimeout(() => { b.style.width = b.dataset.pct + '%'; }, 300);
    });
  });
  function confirmDelete(id, name) {
    document.getElementById('modalText').textContent = `Kamu yakin ingin menghapus target "${name}"?`;
    document.getElementById('deleteForm').action = `/target/${id}`;
    document.getElementById('deleteModal').classList.add('open');
  }
  function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
  document.getElementById('deleteModal')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) closeModal();
  });
  const flash = document.getElementById('flashMsg');
  if (flash) showToast(flash.dataset.msg, flash.dataset.type);
  function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
    t.className = `toast ${type} show`;
    setTimeout(() => t.classList.remove('show'), 3500);
  }
</script>
@endpush