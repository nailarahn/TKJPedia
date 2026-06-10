@extends('layouts.dashboard')

@section('title', 'Progress')

@push('styles')
<style>

/* ───────────────── PAGE ───────────────── */
.progress-wrapper{ padding:.25rem; }
.progress-title{ font-size:1.6rem; font-weight:800; color:var(--gray-800); line-height:1.2; }
.progress-subtitle{ font-size:.92rem; color:var(--gray-400); margin-top:.35rem; margin-bottom:2rem; }

/* ───────────────── STATS ───────────────── */
.stats-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.75rem; }

.stats-card{
    background:var(--white); border:1.5px solid var(--gray-200);
    border-radius:20px; padding:1.35rem; transition:.25s;
    cursor:pointer; position:relative; overflow:hidden;
}
.stats-card::after{
    content:''; position:absolute; inset:0;
    background:linear-gradient(135deg,rgba(108,76,241,.04),transparent);
    opacity:0; transition:.25s;
}
.stats-card:hover{ transform:translateY(-4px); box-shadow:0 14px 34px rgba(55,36,102,.10); }
.stats-card:hover::after{ opacity:1; }

.stats-top{ display:flex; align-items:center; justify-content:space-between; margin-bottom:.9rem; }

.stats-icon{
    font-size:1.55rem; width:52px; height:52px; border-radius:16px;
    display:flex; align-items:center; justify-content:center; background:#f3edff;
}
.stats-badge{ font-size:.72rem; font-weight:700; padding:.28rem .7rem; border-radius:20px; }
.badge-green  { background:#e7fff1; color:#18b56a; }
.badge-blue   { background:#e8f0ff; color:#3b6cf4; }
.badge-purple { background:#efe9ff; color:#6C4CF1; }

.stats-label{ font-size:.82rem; color:var(--gray-400); font-weight:600; }
.stats-number{ font-size:2rem; font-weight:800; color:var(--gray-800); line-height:1; margin-bottom:.55rem; }
.stats-small{ font-size:.78rem; color:var(--gray-400); font-weight:500; }

.stats-click-hint{
    position:absolute; bottom:.6rem; right:.9rem;
    font-size:.65rem; color:var(--gray-400); opacity:0;
    transition:.2s; font-weight:600;
}
.stats-card:hover .stats-click-hint{ opacity:1; }

/* ───────────────── CHART ───────────────── */
.chart-box{ background:var(--white); border:1.5px solid var(--gray-200); border-radius:24px; padding:1.6rem; margin-bottom:1.75rem; }
.chart-title{ font-size:1.15rem; font-weight:800; color:var(--gray-800); margin-bottom:.3rem; }
.chart-sub  { font-size:.82rem; color:var(--gray-400); margin-bottom:1.5rem; }
.chart-wrapper{ width:100%; overflow:hidden; border-radius:18px; }

/* ───────────────── ACHIEVEMENT ───────────────── */
.achievement-box{ background:var(--white); border:1.5px solid var(--gray-200); border-radius:24px; padding:1.6rem; }
.achievement-title{ font-size:1.15rem; font-weight:800; color:var(--gray-800); margin-bottom:.3rem; }
.achievement-sub  { font-size:.82rem; color:var(--gray-400); }

.achievement-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-top:1.4rem; }

/* ── Card tetap ungu (sesuai permintaan) ── */
.achievement-card{
    position:relative; overflow:hidden; border-radius:24px;
    padding:1.5rem 1.2rem 1.2rem; text-align:center;
    transition:all .35s cubic-bezier(.34,1.56,.64,1);
    background:linear-gradient(160deg,#fdfcff 0%,#f5f0ff 100%);
    border:1.5px solid rgba(108,76,241,.18); cursor:pointer;
}
.achievement-card:hover{ transform:translateY(-8px) scale(1.02); box-shadow:0 22px 55px rgba(108,76,241,.18); border-color:#b09fff; }

.card-shine{
    position:absolute; inset:0;
    background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.6) 50%,transparent 60%);
    transform:translateX(-100%); transition:transform .55s ease; z-index:1; pointer-events:none;
}
.achievement-card:hover .card-shine{ transform:translateX(100%); }
.card-glow{ position:absolute; inset:0; pointer-events:none; z-index:0; }

.achievement-badge-wrap{
    position:relative; width:72px; height:72px; margin:0 auto 1rem;
    display:flex; align-items:center; justify-content:center; z-index:2; border-radius:20px;
}
.badge-emoji{ font-size:2rem; line-height:1; position:relative; z-index:2; }
.badge-ring{ position:absolute; inset:-4px; border-radius:50%; border:2.5px solid transparent; animation:spin-ring 4s linear infinite; }
@keyframes spin-ring{ to{ transform:rotate(360deg); } }

/* ── Badge wrap backgrounds tetap ungu/pink/bronze (dekoratif) ── */
.purple-wrap{ background:#efe9ff; }
.purple-wrap .badge-ring{ border-top-color:#6C4CF1; border-right-color:#A586FF; }
.pink-wrap{ background:#ffe7ef; }
.pink-wrap .badge-ring{ border-top-color:#e54b7a; border-right-color:#ff8fab; }
.bronze-wrap{ background:#fff1e0; }
.bronze-wrap .badge-ring{ border-top-color:#cd7f32; border-right-color:#e8a96a; }
.silver-wrap{ background:#f1f1f1; }
.gold-wrap  { background:#fff4d8; }
.green-wrap { background:#e7fff1; }

.achievement-name{ font-size:1rem; font-weight:800; color:var(--gray-800); margin-bottom:.3rem; position:relative; z-index:2; }
.achievement-desc{ font-size:.76rem; color:var(--gray-400); line-height:1.5; margin-bottom:.9rem; position:relative; z-index:2; }
.achv-footer{ display:flex; align-items:center; justify-content:space-between; position:relative; z-index:2; }

/* FIX: XP pill → oranye */
.achv-xp{
    font-size:.72rem; font-weight:700;
    background:var(--gray-100);       /* was #efe9ff ungu */
    color:var(--primary);             /* was #6C4CF1 ungu */
    padding:.25rem .65rem; border-radius:20px;
}
.achv-date{ font-size:.72rem; font-weight:600; color:var(--gray-400); }

.locked-card{ border:1.5px dashed var(--gray-200) !important; background:#fafafa !important; cursor:default !important; }
.locked-card:hover{ transform:none !important; box-shadow:none !important; border-color:var(--gray-200) !important; }
.lock-overlay{ position:absolute; top:.8rem; right:.8rem; font-size:1rem; opacity:.45; }
.locked-bar{ height:5px; background:#eee; border-radius:10px; overflow:hidden; margin:.7rem 0 .3rem; }

/* FIX: locked progress bar → oranye */
.locked-bar-fill{
    height:100%;
    background:linear-gradient(90deg, var(--accent-light), var(--primary)); /* was #b09fff,#6C4CF1 ungu */
    border-radius:10px;
}
.locked-progress-text{ font-size:.7rem; color:var(--gray-400); font-weight:600; }

/* ───────────────── BIG MODAL ───────────────── */
.big-modal{
    position:fixed; inset:0;
    background:rgba(10,5,30,.65); backdrop-filter:blur(12px);
    display:none; align-items:center; justify-content:center;
    z-index:9999; padding:1rem;
}
.big-modal.active{ display:flex; }

.big-modal-box{
    background:white; border-radius:28px;
    width:580px; max-height:88vh;
    overflow:hidden; display:flex; flex-direction:column;
    box-shadow:0 30px 80px rgba(108,76,241,.22);
    animation:slideUp .4s cubic-bezier(.34,1.56,.64,1);
}
@keyframes slideUp{
    from{ opacity:0; transform:translateY(50px) scale(.9); }
    to{   opacity:1; transform:translateY(0)    scale(1);  }
}

.big-modal-header{
    padding:1.6rem 1.8rem 1.2rem;
    display:flex; align-items:center; justify-content:space-between;
    border-bottom:1.5px solid #f0ebff; flex-shrink:0;
}
.big-modal-header-left{ display:flex; align-items:center; gap:.9rem; }
.big-modal-icon{ font-size:2rem; width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; background:#f3edff; }
.big-modal-title{ font-size:1.2rem; font-weight:800; color:var(--gray-800); }
.big-modal-sub  { font-size:.78rem; color:var(--gray-400); margin-top:.1rem; }
.big-modal-close{
    width:34px; height:34px; border-radius:10px; border:none;
    background:#f5f0ff; color:#6C4CF1; font-size:1.1rem;
    cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.2s;
}
.big-modal-close:hover{ background:#6C4CF1; color:white; }

.big-modal-body{ padding:1.4rem 1.8rem; overflow-y:auto; flex:1; }

/* ── HEATMAP ── */
.streak-row{ display:grid; grid-template-columns:repeat(3,1fr); gap:.8rem; margin-bottom:1.2rem; }
.streak-mini{ background:linear-gradient(135deg,#f5f0ff,#ede4ff); border-radius:16px; padding:.9rem; text-align:center; }
.streak-mini-num{ font-size:1.5rem; font-weight:800; color:#6C4CF1; }
.streak-mini-label{ font-size:.7rem; color:var(--gray-400); font-weight:600; margin-top:.1rem; }

.heatmap-grid{ display:grid; grid-template-columns:repeat(17,1fr); gap:3px; }
.heatmap-cell{ aspect-ratio:1; border-radius:3px; background:#f0ebff; transition:.15s; cursor:default; position:relative; }
.heatmap-cell.l1{ background:#d4c5ff; }
.heatmap-cell.l2{ background:#a98bff; }
.heatmap-cell.l3{ background:#7c5bfa; }
.heatmap-cell.l4{ background:#4f2fcc; }
.heatmap-cell:hover::after{
    content:attr(data-tip); position:absolute; bottom:calc(100% + 5px); left:50%; transform:translateX(-50%);
    background:#1a1a2e; color:#fff; font-size:.65rem; white-space:nowrap;
    padding:.2rem .5rem; border-radius:6px; pointer-events:none; z-index:10;
}
.heatmap-legend{ display:flex; align-items:center; gap:.4rem; margin-top:.8rem; font-size:.7rem; color:var(--gray-400); }
.hm-leg{ width:12px; height:12px; border-radius:3px; }

/* ── MATERI LIST ── */
.cp-filter{ display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1rem; }
.cp-btn{
    font-size:.72rem; font-weight:700; padding:.3rem .8rem;
    border-radius:20px; border:1.5px solid #e0d5ff;
    background:white; color:var(--gray-400); cursor:pointer; transition:.2s;
}
.cp-btn.active, .cp-btn:hover{ background:#6C4CF1; color:white; border-color:#6C4CF1; }

.materi-search{
    width:100%; border:1.5px solid #e8e0ff; border-radius:12px;
    padding:.6rem 1rem; font-size:.85rem; outline:none;
    font-family:var(--font); color:var(--gray-800); margin-bottom:1rem; transition:.2s;
    box-sizing:border-box;
}
.materi-search:focus{ border-color:#6C4CF1; box-shadow:0 0 0 3px rgba(108,76,241,.1); }

.materi-list{ display:flex; flex-direction:column; gap:.6rem; }

.materi-item{
    display:flex; align-items:center; gap:.9rem;
    padding:.85rem 1rem; border-radius:14px;
    border:1.5px solid #f0ebff; background:#fdfcff; transition:.2s;
}
.materi-item:hover{ border-color:#c4b0ff; background:#f7f3ff; transform:translateX(3px); }

.materi-num{
    width:34px; height:34px; border-radius:10px;
    background:linear-gradient(135deg,#6C4CF1,#A586FF);
    color:white; font-size:.75rem; font-weight:800;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.materi-info{ flex:1; }
.materi-title{ font-size:.85rem; font-weight:700; color:var(--gray-800); }
.materi-meta { font-size:.72rem; color:var(--gray-400); margin-top:.2rem; }
.materi-cp-tag{
    font-size:.65rem; font-weight:700; padding:.15rem .5rem;
    border-radius:10px; background:#efe9ff; color:#6C4CF1; white-space:nowrap;
}
.materi-check{ font-size:1.1rem; }

/* ── JAM ── */
.jam-week-grid{ display:grid; grid-template-columns:repeat(7,1fr); gap:.5rem; margin-bottom:1.2rem; }
.jam-day{ background:#f5f0ff; border-radius:12px; padding:.6rem .3rem; text-align:center; }
.jam-day-bar-wrap{ height:80px; display:flex; align-items:flex-end; justify-content:center; margin-bottom:.4rem; }
.jam-day-bar{ width:28px; border-radius:8px 8px 0 0; background:linear-gradient(180deg,#A586FF,#6C4CF1); }
.jam-day-name{ font-size:.65rem; font-weight:700; color:var(--gray-400); }
.jam-day-val { font-size:.7rem;  font-weight:800; color:#6C4CF1; margin-top:.15rem; }
.jam-stat-row{ display:grid; grid-template-columns:repeat(3,1fr); gap:.8rem; }
.jam-stat{ background:linear-gradient(135deg,#f5f0ff,#ede4ff); border-radius:16px; padding:1rem; text-align:center; }
.jam-stat-num  { font-size:1.4rem; font-weight:800; color:#6C4CF1; }
.jam-stat-label{ font-size:.7rem; color:var(--gray-400); font-weight:600; margin-top:.1rem; }

/* ── BADGE GALLERY ── */
.badge-gallery{ display:grid; grid-template-columns:repeat(3,1fr); gap:.8rem; }
.badge-gal-card{ border-radius:18px; padding:1.1rem .8rem; text-align:center; border:1.5px solid rgba(108,76,241,.15); background:linear-gradient(160deg,#fdfcff,#f5f0ff); transition:.25s; }
.badge-gal-card:hover{ transform:translateY(-4px); box-shadow:0 12px 30px rgba(108,76,241,.15); }
.badge-gal-card.locked-gal{ opacity:.4; filter:grayscale(1); }
.badge-gal-icon{ font-size:2.2rem; margin-bottom:.5rem; }
.badge-gal-name{ font-size:.78rem; font-weight:800; color:var(--gray-800); }

/* FIX: XP di badge gallery → oranye */
.badge-gal-xp{ font-size:.68rem; color:var(--primary); font-weight:700; margin-top:.2rem; } /* was #6C4CF1 ungu */

.badge-gal-status{ display:inline-block; font-size:.62rem; font-weight:700; padding:.18rem .55rem; border-radius:20px; margin-top:.4rem; }
.status-done  { background:#e7fff1; color:#18b56a; }
.status-locked{ background:#f1f1f1; color:#9b9b9b; }

/* ── ACHIEVEMENT MODAL ── */
.achievement-modal{
    position:fixed; inset:0; background:rgba(10,5,30,.65); backdrop-filter:blur(12px);
    display:none; align-items:center; justify-content:center; z-index:9999;
}
.modal-content{
    width:440px; background:white; border-radius:32px; padding:2.2rem 2rem 2rem;
    position:relative; overflow:hidden; text-align:center;
    box-shadow:0 30px 80px rgba(108,76,241,.28);
    animation:popup .4s cubic-bezier(.34,1.56,.64,1);
}
@keyframes popup{ from{ opacity:0; transform:translateY(40px) scale(.86); } to{ opacity:1; transform:translateY(0) scale(1); } }
#confettiCanvas{ position:absolute; inset:0; width:100%; height:100%; pointer-events:none; border-radius:32px; z-index:0; }
.modal-inner{ position:relative; z-index:1; }
.modal-badge-wrap{ position:relative; width:100px; height:100px; margin:0 auto .4rem; display:flex; align-items:center; justify-content:center; }
.modal-badge{ font-size:3.2rem; line-height:1; position:relative; z-index:2; animation:bounce-in .5s .15s cubic-bezier(.34,1.56,.64,1) both; }
@keyframes bounce-in{ from{ transform:scale(0) rotate(-20deg); } to{ transform:scale(1) rotate(0deg); } }
.modal-badge-ring{ position:absolute; inset:-6px; border-radius:50%; border:3px solid transparent; border-top-color:#6C4CF1; border-right-color:#A586FF; animation:spin-ring 2s linear infinite; }
.modal-sparkles{ display:flex; justify-content:center; gap:1.2rem; font-size:1.1rem; color:#A586FF; margin:.5rem 0 .8rem; animation:sparkle-pop .5s .35s ease both; }
@keyframes sparkle-pop{ from{ opacity:0; transform:scale(.4); } to{ opacity:1; transform:scale(1); } }
.modal-sparkles span:nth-child(2){ color:#6C4CF1; font-size:.8rem; }
.modal-title{ font-size:1.7rem; font-weight:800; color:var(--gray-800); margin-bottom:.5rem; }
.modal-desc{ font-size:.9rem; color:var(--gray-400); line-height:1.7; margin-bottom:1.3rem; }
.modal-reward{ background:linear-gradient(135deg,#f5f0ff,#ede4ff); border:1px solid #ddd0ff; border-radius:20px; padding:1.1rem 1.2rem; margin-bottom:1.4rem; text-align:left; }
.reward-label{ font-size:.72rem; color:var(--gray-400); margin-bottom:.3rem; font-weight:600; }

/* FIX: reward value (XP) → oranye */
.reward-value{ font-size:1.1rem; font-weight:800; color:var(--primary); margin-bottom:.8rem; } /* was #6C4CF1 ungu */

.xp-bar-track{ height:8px; background:#e0d5ff; border-radius:10px; overflow:hidden; margin-bottom:.4rem; }

/* FIX: XP bar fill → oranye */
.xp-bar-fill{
    height:100%;
    background:linear-gradient(90deg, var(--primary), var(--accent-light)); /* was #6C4CF1,#A586FF ungu */
    border-radius:10px; width:0%;
    transition:width 1.2s cubic-bezier(.4,0,.2,1);
}
.xp-bar-labels{ display:flex; justify-content:space-between; font-size:.68rem; color:var(--gray-400); font-weight:600; }

/* FIX: tombol close modal → oranye */
.modal-close{
    width:100%; border:none;
    background:linear-gradient(135deg, var(--primary), var(--accent)); /* was #6C4CF1,#A586FF ungu */
    color:white; font-family:var(--font); font-size:.92rem; font-weight:700;
    padding:1rem; border-radius:16px; cursor:pointer; transition:.25s;
    box-shadow:0 8px 24px var(--accent-glow); /* was rgba(108,76,241,.35) ungu */
}
.modal-close:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 36px rgba(255,77,0,0.45); /* was rgba(108,76,241,.45) ungu */
}

/* ───────────────── RESPONSIVE ───────────────── */
@media(max-width:1024px){
    .stats-grid       { grid-template-columns:repeat(2,1fr); }
    .achievement-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:640px){
    .stats-grid, .achievement-grid{ grid-template-columns:1fr; }
    .big-modal-box{ width:95%; }
    .modal-content{ width:92%; padding:1.5rem; }
}
</style>
@endpush

@section('content')

<div class="progress-wrapper">

    <div class="progress-title">Progress Tracking</div>
    <div class="progress-subtitle">Pantau perkembangan belajarmu dari waktu ke waktu</div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stats-card" onclick="openStatsModal('hari')">
            <div class="stats-top">
                <div class="stats-icon">📅</div>
                <span class="stats-badge badge-blue">↑ aktif</span>
            </div>
            <div class="stats-label">Total Hari Belajar</div>
            <div class="stats-number">{{ $totalHariBelajar }}</div>
            <div class="stats-small">Sejak pertama belajar</div>
            <div class="stats-click-hint">Lihat detail →</div>
        </div>

        <div class="stats-card" onclick="openStatsModal('materi')">
            <div class="stats-top">
                <div class="stats-icon">📚</div>
                <span class="stats-badge badge-green">Total</span>
            </div>
            <div class="stats-label">Materi Selesai</div>
            <div class="stats-number">{{ $materiSelesai }}</div>
            <div class="stats-small">Total materi selesai</div>
            <div class="stats-click-hint">Lihat riwayat →</div>
        </div>

        <div class="stats-card" onclick="openStatsModal('jam')">
            <div class="stats-top">
                <div class="stats-icon">⏱️</div>
                <span class="stats-badge badge-green">Total</span>
            </div>
            <div class="stats-label">Total Jam Belajar</div>
            <div class="stats-number">{{ $totalJam }}</div>
            <div class="stats-small">Total jam belajar</div>
            <div class="stats-click-hint">Lihat grafik →</div>
        </div>

        <div class="stats-card" onclick="openStatsModal('badge')">
            <div class="stats-top">
                <div class="stats-icon">🏅</div>
                <span class="stats-badge badge-purple">{{ $badgeEarned }}/{{ $totalBadge }}</span>
            </div>
            <div class="stats-label">Badge Earned</div>
            <div class="stats-number">{{ $badgeEarned }}</div>
            <div class="stats-small">dari {{ $totalBadge }} badge</div>
            <div class="stats-click-hint">Lihat koleksi →</div>
        </div>
    </div>

    {{-- CHART --}}
    <div class="chart-box">
        <div class="chart-title">Tren Belajar Bulanan</div>
        <div class="chart-sub">Materi selesai dan jam belajar per bulan</div>
        <div class="chart-wrapper" style="position:relative; height:300px;">
            <canvas id="progressChart"></canvas>
        </div>
    </div>

    {{-- ACHIEVEMENTS --}}
    <div class="achievement-box">
        <div class="achievement-title">🏆 Pencapaian</div>
        <div class="achievement-sub">Badge dan achievements yang sudah diraih</div>

        <div class="achievement-grid">

            <div class="achievement-card" onclick="openAchievement('⭐','First Step','Berhasil menyelesaikan materi pertama dan memulai perjalanan belajar di MappyPath!','100 XP + Beginner Badge',100,500)">
                <div class="card-shine"></div>
                <div class="card-glow" style="background:radial-gradient(circle at 65% 0%,rgba(108,76,241,.15),transparent 70%)"></div>
                <div class="achievement-badge-wrap purple-wrap"><div class="badge-emoji">⭐</div><div class="badge-ring"></div></div>
                <div class="achievement-name">First Step</div>
                <div class="achievement-desc">Selesaikan materi pertama</div>
                <div class="achv-footer"><span class="achv-xp">+100 XP</span><span class="achv-date">Jan 2026</span></div>
            </div>

            <div class="achievement-card" onclick="openAchievement('🔥','Consistent','Kamu berhasil belajar selama 7 hari berturut-turut tanpa terputus. Luar biasa!','250 XP + Streak Bonus',250,500)">
                <div class="card-shine"></div>
                <div class="card-glow" style="background:radial-gradient(circle at 65% 0%,rgba(229,75,122,.15),transparent 70%)"></div>
                <div class="achievement-badge-wrap pink-wrap"><div class="badge-emoji">🔥</div><div class="badge-ring"></div></div>
                <div class="achievement-name">Consistent</div>
                <div class="achievement-desc">Belajar 7 hari berturut-turut</div>
                <div class="achv-footer"><span class="achv-xp">+250 XP</span><span class="achv-date">Jan 2026</span></div>
            </div>

            <div class="achievement-card" onclick="openAchievement('🥉','Bronze Medal','Menyelesaikan 5 modul pembelajaran dengan progress yang konsisten. Terus semangat!','500 XP + Bronze Rank',500,1000)">
                <div class="card-shine"></div>
                <div class="card-glow" style="background:radial-gradient(circle at 65% 0%,rgba(205,127,50,.15),transparent 70%)"></div>
                <div class="achievement-badge-wrap bronze-wrap"><div class="badge-emoji">🥉</div><div class="badge-ring"></div></div>
                <div class="achievement-name">Bronze Medal</div>
                <div class="achievement-desc">Selesaikan 5 modul</div>
                <div class="achv-footer"><span class="achv-xp">+500 XP</span><span class="achv-date">Jan 2026</span></div>
            </div>

            <div class="achievement-card locked-card">
                <div class="lock-overlay">🔒</div>
                <div class="achievement-badge-wrap silver-wrap" style="opacity:.35"><div class="badge-emoji">🥈</div></div>
                <div class="achievement-name" style="opacity:.45">Silver Medal</div>
                <div class="achievement-desc" style="opacity:.4">Selesaikan 10 modul</div>
                <div class="locked-bar"><div class="locked-bar-fill" style="width:50%"></div></div>
                <div class="locked-progress-text">5 / 10 modul</div>
            </div>

            <div class="achievement-card locked-card">
                <div class="lock-overlay">🔒</div>
                <div class="achievement-badge-wrap gold-wrap" style="opacity:.35"><div class="badge-emoji">🥇</div></div>
                <div class="achievement-name" style="opacity:.45">Gold Medal</div>
                <div class="achievement-desc" style="opacity:.4">Selesaikan 20 modul</div>
                <div class="locked-bar"><div class="locked-bar-fill" style="width:25%"></div></div>
                <div class="locked-progress-text">5 / 20 modul</div>
            </div>

            <div class="achievement-card locked-card">
                <div class="lock-overlay">🔒</div>
                <div class="achievement-badge-wrap green-wrap" style="opacity:.35"><div class="badge-emoji">🏆</div></div>
                <div class="achievement-name" style="opacity:.45">Winner</div>
                <div class="achievement-desc" style="opacity:.4">Selesaikan semua roadmap</div>
                <div class="locked-bar"><div class="locked-bar-fill" style="width:10%"></div></div>
                <div class="locked-progress-text">2 / 20 roadmap</div>
            </div>

        </div>
    </div>

</div>

{{-- BIG MODAL --}}
<div class="big-modal" id="bigModal" onclick="handleBigModalBg(event)">
    <div class="big-modal-box" id="bigModalBox">
        <div class="big-modal-header">
            <div class="big-modal-header-left">
                <div class="big-modal-icon" id="bmIcon">📅</div>
                <div>
                    <div class="big-modal-title" id="bmTitle">Detail</div>
                    <div class="big-modal-sub"   id="bmSub">—</div>
                </div>
            </div>
            <button class="big-modal-close" onclick="closeBigModal()">✕</button>
        </div>
        <div class="big-modal-body" id="bmBody"></div>
    </div>
</div>

{{-- ACHIEVEMENT MODAL --}}
<div class="achievement-modal" id="achievementModal" onclick="handleAchvModalBg(event)">
    <div class="modal-content" id="modalBox">
        <canvas id="confettiCanvas"></canvas>
        <div class="modal-inner">
            <div class="modal-badge-wrap">
                <div class="modal-badge" id="modalEmoji">⭐</div>
                <div class="modal-badge-ring"></div>
            </div>
            <div class="modal-sparkles"><span>✦</span><span>✦</span><span>✦</span></div>
            <div class="modal-title" id="modalTitle">First Step</div>
            <div class="modal-desc"  id="modalDesc">Deskripsi</div>
            <div class="modal-reward">
                <div class="reward-label">🎁 Reward yang didapat</div>
                <div class="reward-value" id="modalReward">100 XP</div>
                <div class="xp-bar-track"><div class="xp-bar-fill" id="xpBarFill"></div></div>
                <div class="xp-bar-labels"><span>0 XP</span><span id="xpMax">1000 XP</span></div>
            </div>
            <button class="modal-close" onclick="closeAchievement()">Keren! Tutup 🎉</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

/* ══ DATA DARI CONTROLLER ══ */
const chartData      = @json($chartData);
const heatmapData    = @json($heatmapData);
const completedStages= @json($completedStages);
const jamMingguIni   = @json($jamMingguIni);
const badgesData     = @json($badges);
const streakNow      = {{ $streakNow }};
const streakMax      = {{ $streakMax }};
const totalHari      = {{ $totalHariBelajar }};
const totalJam       = {{ $totalJam }};
const jamMingguTotal = {{ $jamMingguIniTotal }};
const jamRata        = {{ $jamRataHarian }};

/* ══ CHART ══ */
const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.map(d => d.label),
        datasets: [
            {
                label: 'Materi selesai',
                data: chartData.map(d => d.materi),
                borderColor: '#8B7BFF', backgroundColor: 'rgba(139,123,255,0.18)',
                fill: true, tension: 0.4, pointRadius: 5,
                pointBackgroundColor: '#fff', pointBorderColor: '#8B7BFF', pointBorderWidth: 2
            },
            {
                label: 'Jam belajar',
                data: chartData.map(d => d.jam),
                borderColor: '#FFA69E', backgroundColor: 'rgba(255,166,158,0.15)',
                fill: true, tension: 0.4, pointRadius: 5,
                pointBackgroundColor: '#fff', pointBorderColor: '#FFA69E', pointBorderWidth: 2
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 12 } } } },
        scales: { y: { beginAtZero: true, grid: { color: '#eee' } }, x: { grid: { color: '#f5f5f5' } } }
    }
});

/* ══ BUILD CONTENT ══ */

function buildHariContent() {
    const cells = [];
    for (let i = 89; i >= 0; i--) {
        const d = new Date();
        d.setDate(d.getDate() - i);
        const key  = d.toISOString().split('T')[0];
        const mins = heatmapData[key] || 0;
        const lvl  = mins === 0 ? '' : mins < 60 ? 'l1' : mins < 120 ? 'l2' : mins < 180 ? 'l3' : 'l4';
        const tip  = mins === 0 ? 'Tidak belajar' : `${Math.round(mins / 60 * 10) / 10} jam`;
        cells.push(`<div class="heatmap-cell ${lvl}" data-tip="${key}: ${tip}"></div>`);
    }
    return `
    <div class="streak-row">
        <div class="streak-mini"><div class="streak-mini-num">${totalHari}</div><div class="streak-mini-label">Total Hari</div></div>
        <div class="streak-mini"><div class="streak-mini-num">${streakMax}</div><div class="streak-mini-label">Streak Terpanjang 🔥</div></div>
        <div class="streak-mini"><div class="streak-mini-num">${streakNow}</div><div class="streak-mini-label">Streak Sekarang ⚡</div></div>
    </div>
    <div style="font-size:.78rem;font-weight:700;color:var(--gray-800);margin-bottom:.6rem;">Heatmap Aktivitas Belajar (90 hari terakhir)</div>
    <div class="heatmap-grid">${cells.join('')}</div>
    <div class="heatmap-legend">
        <span>Kurang</span>
        <div class="hm-leg" style="background:#f0ebff"></div>
        <div class="hm-leg" style="background:#d4c5ff"></div>
        <div class="hm-leg" style="background:#a98bff"></div>
        <div class="hm-leg" style="background:#7c5bfa"></div>
        <div class="hm-leg" style="background:#4f2fcc"></div>
        <span>Banyak</span>
    </div>`;
}

let activeCp = 'Semua';

function buildMateriContent() {
    const roadmapNames = ['Semua', ...new Set(completedStages.map(s => s.roadmap?.title ?? 'Lainnya'))];
    const filterBtns   = roadmapNames.map(c =>
        `<button class="cp-btn ${c === activeCp ? 'active' : ''}" onclick="filterCp('${c}')">${c}</button>`
    ).join('');
    const rows = completedStages.map((s, i) => `
    <div class="materi-item" data-cp="${s.roadmap?.title ?? 'Lainnya'}" data-title="${(s.stage?.title ?? '').toLowerCase()}">
        <div class="materi-num">${i + 1}</div>
        <div class="materi-info">
            <div class="materi-title">${s.stage?.title ?? '-'}</div>
            <div class="materi-meta">📂 ${s.roadmap?.title ?? '-'} &nbsp;·&nbsp; 🗓 ${s.completed_at ? s.completed_at.substring(0,10) : '-'} &nbsp;·&nbsp; ⏱ ${s.time_spent_minutes} mnt</div>
        </div>
        <span class="materi-cp-tag">${s.roadmap?.title ?? '-'}</span>
        <div class="materi-check">✅</div>
    </div>`).join('');
    return `
    <div class="cp-filter">${filterBtns}</div>
    <input class="materi-search" type="text" placeholder="🔍  Cari materi..." oninput="filterMateri(this.value)">
    <div style="font-size:.72rem;color:var(--gray-400);font-weight:600;margin-bottom:.8rem;">${completedStages.length} materi selesai</div>
    <div class="materi-list" id="materiList">${rows}</div>`;
}

function filterCp(cp) {
    activeCp = cp;
    document.getElementById('bmBody').innerHTML = buildMateriContent();
}

function filterMateri(q) {
    document.querySelectorAll('.materi-item').forEach(el => {
        const matchCp    = activeCp === 'Semua' || el.dataset.cp === activeCp;
        const matchQuery = el.dataset.title.includes(q.toLowerCase());
        el.style.display = (matchCp && matchQuery) ? '' : 'none';
    });
}

function buildJamContent() {
    const maxH = Math.max(...jamMingguIni.map(w => w.jam), 1);
    const bars  = jamMingguIni.map(w => `
    <div class="jam-day">
        <div class="jam-day-bar-wrap">
            <div class="jam-day-bar" style="height:${(w.jam / maxH) * 80}px"></div>
        </div>
        <div class="jam-day-name">${w.day}</div>
        <div class="jam-day-val">${w.jam}j</div>
    </div>`).join('');
    return `
    <div style="font-size:.78rem;font-weight:700;color:var(--gray-800);margin-bottom:.8rem;">Jam Belajar Minggu Ini</div>
    <div class="jam-week-grid">${bars}</div>
    <div class="jam-stat-row">
        <div class="jam-stat"><div class="jam-stat-num">${jamMingguTotal}j</div><div class="jam-stat-label">Minggu Ini</div></div>
        <div class="jam-stat"><div class="jam-stat-num">${jamRata}j</div><div class="jam-stat-label">Rata-rata/Hari</div></div>
        <div class="jam-stat"><div class="jam-stat-num">${totalJam}j</div><div class="jam-stat-label">Total Semua</div></div>
    </div>`;
}

function buildBadgeContent() {
    const earned  = badgesData.filter(b => b.unlocked).length;
    const totalXp = badgesData.filter(b => b.unlocked).reduce((s, b) => s + (b.xp || 0), 0);
    const cards   = badgesData.map(b => `
    <div class="badge-gal-card ${b.unlocked ? '' : 'locked-gal'}">
        <div class="badge-gal-icon">${b.icon}</div>
        <div class="badge-gal-name">${b.name}</div>
        <div class="badge-gal-xp">+${b.xp} XP</div>
        <div class="badge-gal-status ${b.unlocked ? 'status-done' : 'status-locked'}">${b.unlocked ? '✓ Diraih' : '🔒 Locked'}</div>
    </div>`).join('');
    return `
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <div style="font-size:.78rem;color:var(--gray-400);font-weight:600;">${earned} dari ${badgesData.length} badge diraih</div>
        <div style="font-size:.72rem;font-weight:700;background:#efe9ff;color:#6C4CF1;padding:.25rem .7rem;border-radius:20px;">Total: ${totalXp} XP</div>
    </div>
    <div class="badge-gallery">${cards}</div>`;
}

/* ══ OPEN / CLOSE BIG MODAL ══ */
const modalConfigs = {
    hari:  { icon:'📅', title:'Total Hari Belajar',   sub:'Streak & heatmap aktivitas belajarmu',            build: buildHariContent   },
    materi:{ icon:'📚', title:'Riwayat Materi',        sub:`${completedStages.length} materi telah selesai`,  build: buildMateriContent },
    jam:   { icon:'⏱️', title:'Statistik Jam Belajar', sub:'Breakdown waktu belajar per hari',                build: buildJamContent    },
    badge: { icon:'🏅', title:'Koleksi Badge',         sub:'Badge yang sudah & belum diraih',                 build: buildBadgeContent  },
};

function openStatsModal(type) {
    const cfg = modalConfigs[type];
    document.getElementById('bmIcon').innerText  = cfg.icon;
    document.getElementById('bmTitle').innerText = cfg.title;
    document.getElementById('bmSub').innerText   = cfg.sub;
    document.getElementById('bmBody').innerHTML  = cfg.build();
    document.getElementById('bigModal').classList.add('active');
}
function closeBigModal() { document.getElementById('bigModal').classList.remove('active'); }
function handleBigModalBg(e) { if (e.target === document.getElementById('bigModal')) closeBigModal(); }

/* ══ CONFETTI ══ */
let confettiAnim;
const COLORS = ['#FF4D00','#FF6A00','#FF8100','#FFB366','#FFD166','#FFECCC'];
function launchConfetti() {
    const canvas = document.getElementById('confettiCanvas');
    const box    = document.getElementById('modalBox');
    canvas.width = box.offsetWidth; canvas.height = box.offsetHeight;
    const c = canvas.getContext('2d');
    const pieces = Array.from({ length: 80 }, () => ({
        x: Math.random() * canvas.width, y: Math.random() * canvas.height - canvas.height,
        r: Math.random() * 6 + 3, d: Math.random() * 4 + 2,
        color: COLORS[Math.floor(Math.random() * COLORS.length)],
        tilt: 0, tiltAngle: 0, tiltSpeed: Math.random() * .1 + .05,
    }));
    let frame = 0;
    function draw() {
        c.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach(p => {
            p.tiltAngle += p.tiltSpeed; p.y += p.d; p.tilt = Math.sin(p.tiltAngle) * 12;
            if (p.y > canvas.height) { p.y = -10; p.x = Math.random() * canvas.width; }
            c.beginPath(); c.lineWidth = p.r; c.strokeStyle = p.color;
            c.moveTo(p.x + p.tilt + p.r / 2, p.y); c.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 2); c.stroke();
        });
        frame++;
        if (frame < 180) confettiAnim = requestAnimationFrame(draw);
        else c.clearRect(0, 0, canvas.width, canvas.height);
    }
    draw();
}

/* ══ ACHIEVEMENT MODAL ══ */
function openAchievement(icon, title, desc, reward, xp, xpMax) {
    document.getElementById('achievementModal').style.display = 'flex';
    document.getElementById('modalEmoji').innerText  = icon;
    document.getElementById('modalTitle').innerText  = title;
    document.getElementById('modalDesc').innerText   = desc;
    document.getElementById('modalReward').innerText = reward;
    document.getElementById('xpMax').innerText       = xpMax + ' XP';
    const bar = document.getElementById('xpBarFill');
    bar.style.width = '0%';
    setTimeout(() => { bar.style.width = Math.min((xp / xpMax) * 100, 100) + '%'; }, 300);
    cancelAnimationFrame(confettiAnim);
    setTimeout(launchConfetti, 200);
}
function closeAchievement() {
    cancelAnimationFrame(confettiAnim);
    document.getElementById('achievementModal').style.display = 'none';
}
function handleAchvModalBg(e) { if (e.target === document.getElementById('achievementModal')) closeAchievement(); }

</script>
@endpush