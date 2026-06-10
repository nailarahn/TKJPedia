@extends('layouts.dashboard')
@section('title', $stage->title . ' - ' . $roadmap->title)

@push('styles')
<style>
.back-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    color: var(--gray-500); font-size: .875rem; font-weight: 500;
    text-decoration: none; margin-bottom: 1.25rem; transition: color .2s;
}
.back-btn:hover { color: var(--primary); }

.stage-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;
}
.stage-main-title { font-size: 1.3rem; font-weight: 800; color: var(--gray-800); }
.stage-sub { font-size: .82rem; color: var(--gray-400); margin-top: .2rem; }
.stage-progress-row { display: flex; align-items: center; gap: 1rem; min-width: 220px; }
.stage-progress-row .bar { flex: 1; }
.stage-progress-pct { font-size: .875rem; font-weight: 700; color: var(--primary); white-space: nowrap; }

.stage-grid { display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; align-items: start; }

.video-card { background: var(--white); border-radius: 16px; overflow: hidden; border: 1.5px solid var(--gray-200); }

.yt-wrapper {
    position: relative; width: 100%; aspect-ratio: 16/9;
    background: #000; overflow: hidden;
}
.yt-wrapper iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: none; }

.yt-thumb {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #1a0a3c 0%, #372466 50%, #7c5cbf 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    cursor: pointer; z-index: 2; transition: opacity .3s;
}
.yt-thumb:hover .play-circle { 
    transform: scale(1.1); 
}
.yt-thumb .badge-top {
    position: absolute; top: 1rem; left: 1rem;
    background: rgba(55,36,102,.85); color: white; font-size: .7rem; font-weight: 700;
    padding: .3rem .8rem; border-radius: 50px; backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.2);
}
.yt-thumb .thumb-title {
    font-size: clamp(.95rem, 2.5vw, 1.5rem); font-weight: 800;
    color: #c4a8f0; text-align: center; padding: 0 1.5rem; line-height: 1.3; margin-bottom: .75rem;
    text-shadow: 0 2px 12px rgba(0,0,0,.4);
}
.yt-thumb .thumb-sub { 
    font-size: .78rem; 
    color: rgba(255,255,255,.6); 
    text-align: center; 
    padding: 0 2rem; 
}
.play-circle {
    width: 68px; height: 68px; background: rgba(255,255,255,.92);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.25rem; transition: transform .2s; box-shadow: 0 8px 30px rgba(0,0,0,.35);
}
.play-circle svg { 
    margin-left: 5px; 
}
.yt-thumb::before {
    content: ''; position: absolute; width: 300px; height: 300px;
    border-radius: 50%; border: 1px solid rgba(255,255,255,.08);
    top: -100px; right: -80px;
}
.yt-thumb::after {
    content: ''; position: absolute; width: 200px; height: 200px;
    border-radius: 50%; border: 1px solid rgba(255,255,255,.06);
    bottom: -60px; left: -40px;
}

.video-info { 
    padding: 1.5rem; 
}
.video-info-title { 
    font-size: 1.05rem; 
    font-weight: 700; 
    color: var(--gray-800); margin-bottom: .4rem; 
}
.video-info-desc { 
    font-size: .875rem; 
    color: var(--gray-500); 
    line-height: 1.65; 
    margin-bottom: 1rem; 
}
.video-meta-row {
    display: flex; align-items: center; gap: 1.25rem;
    font-size: .8rem; color: var(--gray-400); margin-bottom: 1.25rem; flex-wrap: wrap;
}
.video-meta-row span { display: flex; align-items: center; gap: .35rem; }

.learning-box {
    background: #f4f1ff; border-radius: 12px; padding: 1.1rem 1.25rem; margin-bottom: 1.25rem;
}
.learning-box-title {
    font-size: .875rem; font-weight: 700; color: var(--primary);
    margin-bottom: .65rem; display: flex; align-items: center; gap: .4rem;
}
.learning-box ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .35rem; }
.learning-box ul li { font-size: .82rem; color: var(--gray-600); display: flex; align-items: flex-start; gap: .5rem; }
.learning-box ul li::before { content: '•'; color: var(--primary); font-weight: 700; flex-shrink: 0; margin-top: 1px; }

.alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a;
    border-radius: 10px; padding: .85rem 1rem; font-size: .875rem;
    margin-bottom: 1.25rem; display: flex; align-items: center; gap: .5rem;
}

.complete-btn {
    width: 100%; padding: .9rem;
    background: var(--primary); color: white; border: none; border-radius: 12px;
    font-family: var(--font); font-size: .95rem; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    transition: all .25s; text-decoration: none;
}
.complete-btn:hover { background: var(--primary-light); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(55,36,102,.3); }
.complete-btn.done { background: #ecfdf5; color: #16a34a; cursor: default; }
.complete-btn.done:hover { transform: none; box-shadow: none; }

.materi-sidebar {
    background: var(--white); border-radius: 16px; border: 1.5px solid var(--gray-200);
    overflow: hidden; position: sticky; top: 80px; max-height: calc(100vh - 120px); overflow-y: auto;
}
.materi-sidebar-header {
    padding: 1rem 1.25rem; font-size: 1rem; font-weight: 700;
    color: var(--gray-800); border-bottom: 1px solid var(--gray-200);
    position: sticky; top: 0; background: var(--white); z-index: 1;
}

.acc-group { 
    border-bottom: 1px solid var(--gray-200); 
}
.acc-group:last-child { 
    border-bottom: none; 
}
.acc-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: .9rem 1.25rem; cursor: pointer; font-size: .85rem; font-weight: 700;
    color: var(--gray-700); transition: background .15s; gap: .5rem; user-select: none;
}
.acc-header:hover { 
    background: var(--gray-100); 
}
.acc-header.is-active { 
    color: var(--primary); 
}
.acc-chevron { 
    width: 16px; 
    height: 16px; 
    flex-shrink: 0; 
    transition: transform .2s; 
    color: var(--gray-400); 
}
.acc-header.is-open .acc-chevron { 
    transform: rotate(180deg); 
}

.acc-body { 
    display: none; 
}
.acc-body.is-open { 
    display: block; 
}

.materi-item {
    display: flex; align-items: center; gap: .7rem;
    padding: .55rem 1.25rem; cursor: pointer; transition: background .15s;
    text-decoration: none; border-left: 3px solid transparent;
}
.materi-item:hover { background: var(--gray-100); }
.materi-item.is-active { background: #f4f1ff; border-left-color: var(--primary); }
.materi-icon { width: 18px; height: 18px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.materi-icon.c-done    { color: #22c55e; }
.materi-icon.c-active  { color: var(--primary); }
.materi-icon.c-default { color: var(--gray-300); }
.materi-info { flex: 1; min-width: 0; }
.materi-title { font-size: .78rem; font-weight: 600; color: var(--gray-700); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.materi-title.t-active { color: var(--primary); }
.materi-dur { font-size: .68rem; color: var(--gray-400); display: flex; align-items: center; gap: .2rem; margin-top: 1px; }

.next-group-link {
    display: flex; align-items: center; justify-content: space-between;
    padding: .9rem 1.25rem; text-decoration: none; font-size: .85rem; font-weight: 600;
    color: var(--gray-500); transition: all .15s;
}
.next-group-link:hover { background: var(--gray-100); color: var(--primary); }

.quiz-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: #E6F1FB;
    border: 1.5px solid #B5D4F4;
    border-radius: 16px;
    margin-top: 1.5rem;
}
.quiz-cta-info { display: flex; align-items: center; gap: .75rem; font-size: 1.25rem; color: #185FA5; }
.quiz-cta-title { font-size: .95rem; font-weight: 600; color: #0C447C; }
.quiz-cta-sub   { font-size: .8rem; color: #185FA5; }
.btn-start-quiz {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .65rem 1.5rem;
    background: #185FA5;
    color: #fff;
    border-radius: 10px;
    font-size: .9rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s;
}
.btn-start-quiz:hover { background: #0C447C; }
@media (max-width: 900px) {
    .stage-grid { grid-template-columns: 1fr; }
    .materi-sidebar { position: static; max-height: 400px; }
}
@media (max-width: 640px) {
    .stage-main-title { font-size: 1.05rem; }
    .stage-header { flex-direction: column; align-items: flex-start; }
    .stage-progress-row { width: 100%; }
}
</style>
@endpush

@section('content')

@php
    $completedStageIds = $completedStageIds ?? [];
@endphp

<a href="{{ route('roadmap') }}" class="back-btn">
    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    Kembali ke Roadmap
</a>

@if(session('success'))
<div class="alert-success">✅ {{ session('success') }}</div>
@endif

<div class="stage-header">
    <div>
        <div class="stage-main-title">{{ $stage->title }}</div>
        <div class="stage-sub">{{ $doneCount }} dari {{ $roadmap->total_stages }} materi selesai</div>
    </div>
    <div class="stage-progress-row">
        <div class="bar">
            <div class="progress-bar"><div class="progress-fill" style="width:{{ $progressPercent }}%"></div></div>
        </div>
        <span class="stage-progress-pct">{{ $progressPercent }}%</span>
    </div>
</div>

<div class="stage-grid">

    <div>
        <div class="video-card">

            <div class="yt-wrapper" id="ytWrapper">
                @php $ytId = $stage->getYoutubeId(); @endphp

                @if($ytId)

                <div class="yt-thumb" id="ytThumb" onclick="loadYoutube('{{ $ytId }}')">
                    <div class="badge-top">🎬 {{ $stage->getTypeLabel() }}</div>
                    <div class="play-circle">
                        <svg width="28" height="28" fill="#372466" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                    <div class="thumb-title">{{ $stage->title }}</div>
                    <div class="thumb-sub">{{ $stage->description }}</div>
                </div>
                @else

                <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a0a3c,#372466);display:flex;flex-direction:column;align-items:center;justify-content:center;color:rgba(255,255,255,.6);gap:.75rem;">
                    <div style="font-size:2.5rem;">📄</div>
                    <div style="font-size:.875rem;">Konten berupa {{ $stage->getTypeLabel() }}</div>
                </div>
                @endif
            </div>


            <div class="video-info">
                <div class="video-info-title">{{ $stage->title }}</div>
                <div class="video-info-desc">
                    {{ $stage->description ?? 'Pelajari materi ini untuk menguasai konsep dasar dan meningkatkan kemampuanmu.' }}
                </div>
                <div class="video-meta-row">
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Durasi: {{ $stage->estimated_minutes }} menit
                    </span>
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        {{ $stage->getTypeLabel() }}
                    </span>
                    <span>🎯 {{ $roadmap->title }}</span>
                </div>


                @if($stage->learning_points)
                <div class="learning-box">
                    <div class="learning-box-title">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        Yang akan kamu pelajari
                    </div>
                    <ul>
                        @foreach(explode("\n", $stage->learning_points) as $pt)
                            @if(trim($pt))<li>{{ trim($pt) }}</li>@endif
                        @endforeach
                    </ul>
                </div>
                @endif


                @if($isCompleted)
                <div class="complete-btn done">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    Materi Sudah Diselesaikan ✓
                </div>
                @else
                <button type="button" class="complete-btn" id="completeBtn" onclick="handleCompleteVideo()">
                    🎬 Tandai Selesai & Lanjut →
                </button>
                @endif
            </div>
        </div>

        {{-- Tombol mulai kuis --}}
        @if($stage->quiz)
        <div class="quiz-cta">
            <div class="quiz-cta-info">
                <i class="ti ti-help-circle"></i>
                <div>
                    <div class="quiz-cta-title">Uji Pemahamanmu!</div>
                    <div class="quiz-cta-sub">{{ $stage->quiz->questions->count() }} soal · Nilai lulus {{ $stage->quiz->passing_score }}%</div>
                </div>
            </div>
            <a href="{{ route('roadmap.quiz', [$roadmapId, $stage->id]) }}" class="btn-start-quiz">
                <i class="ti ti-arrow-right"></i> Mulai Kuis
            </a>
        </div>
        @endif
    </div>

    <div>
        <div class="materi-sidebar">
            <div class="materi-sidebar-header">Daftar Materi</div>

            @php
                $grouped = $allStages->groupBy('group_label');
            @endphp

            @foreach($grouped as $groupName => $groupStages)
            @php
                $hasActive = $groupStages->contains('id', $stage->id);
                $allDone   = $groupStages->every(fn($s) => in_array($s->id, $completedStageIds));
            @endphp

            @if($hasActive)

            <div class="acc-group">
                <div class="acc-header is-open is-active" onclick="toggleAcc(this)">
                    <span>{{ $groupName }}</span>
                    <svg class="acc-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </div>
                <div class="acc-body is-open">
                    @foreach($groupStages as $gs)
                    @php
                        $gsDone   = in_array($gs->id, $completedStageIds);
                        $gsActive = $gs->id === $stage->id;
                        $dur      = sprintf('%02d:%02d', intdiv($gs->estimated_minutes, 60), $gs->estimated_minutes % 60);
                    @endphp
                    <a href="{{ route('roadmap.stage', ['roadmapId' => $roadmap->id, 'stageId' => $gs->id]) }}"
                       class="materi-item {{ $gsActive ? 'is-active' : '' }}">
                        <div class="materi-icon {{ $gsDone ? 'c-done' : ($gsActive ? 'c-active' : 'c-default') }}">
                            @if($gsDone)
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            @elseif($gsActive)
                                <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><polygon points="10 8 16 12 10 16" fill="currentColor"/></svg>
                            @else
                                <svg width="13" height="13" viewBox="0 0 13 13"><circle cx="6.5" cy="6.5" r="5.5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
                            @endif
                        </div>
                        <div class="materi-info">
                            <div class="materi-title {{ $gsActive ? 't-active' : '' }}">{{ $gs->title }}</div>
                            <div class="materi-dur">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $dur }}:00
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @else

            <div class="acc-group">
                <div class="acc-header {{ $allDone ? 'is-active' : '' }}" onclick="toggleAcc(this)">
                    <span>
                        {{ $groupName }}
                        @if($allDone) <span style="font-size:.7rem;font-weight:600;color:#22c55e;margin-left:.35rem;">✓ Selesai</span>@endif
                    </span>
                    <svg class="acc-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </div>
                <div class="acc-body">
                    @foreach($groupStages as $gs)
                    @php
                        $gsDone = in_array($gs->id, $completedStageIds);
                        $dur    = sprintf('%02d:%02d', intdiv($gs->estimated_minutes, 60), $gs->estimated_minutes % 60);
                    @endphp
                    <a href="{{ route('roadmap.stage', ['roadmapId' => $roadmap->id, 'stageId' => $gs->id]) }}"
                       class="materi-item">
                        <div class="materi-icon {{ $gsDone ? 'c-done' : 'c-default' }}">
                            @if($gsDone)
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            @else
                                <svg width="13" height="13" viewBox="0 0 13 13"><circle cx="6.5" cy="6.5" r="5.5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
                            @endif
                        </div>
                        <div class="materi-info">
                            <div class="materi-title">{{ $gs->title }}</div>
                            <div class="materi-dur">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $dur }}:00
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const COMPLETE_URL = '{{ route("roadmap.complete", ["roadmapId" => $roadmap->id, "stageId" => $stage->id]) }}';
const CSRF_TOKEN   = '{{ csrf_token() }}';
const STAGE_TITLE  = '{{ addslashes($stage->title) }}';
@if($nextStage ?? false)
const NEXT_URL = '{{ route("roadmap.stage", ["roadmapId" => $roadmap->id, "stageId" => $nextStage->id]) }}';
@else
const NEXT_URL = '{{ route("roadmap") }}';
@endif

async function handleCompleteVideo() {
    const btn = document.getElementById('completeBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Menyimpan...';

    try {
        const res = await fetch(COMPLETE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ duration_minutes: {{ $stage->estimated_minutes }} })
        });

        const data = await res.json();
        const xpEarned = data.xp_earned ?? 50;

        // Update XP di topbar langsung
        const xpEl = document.querySelector('.topbar-right div span:last-child');
        if (xpEl && data.xp !== undefined) {
            xpEl.textContent = data.xp + ' XP';
        }

        // Ubah tombol jadi "selesai"
        btn.className = 'complete-btn done';
        btn.disabled  = true;
        btn.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> Materi Sudah Diselesaikan ✓';

        // Tampilkan popup reward
        showTKJReward({
            type:    data.new_badge ? 'Badge Baru Diraih! 🏆' : 'Video Selesai! 🎬',
            title:   data.new_badge ? data.new_badge : 'Materi Ditandai Selesai!',
            desc:    STAGE_TITLE + ' berhasil kamu selesaikan. Terus semangat!',
            xp:      xpEarned,
            emoji:   data.new_badge ? '🏅' : '🎬',
            badge:   data.new_badge ?? null,
            bgColor: data.new_badge ? '#ffe7ef' : '#efe9ff',
        });

        // Tombol popup lanjut ke materi berikutnya
        const popupBtn = document.querySelector('#tkj-reward-popup button');
        popupBtn.textContent = '{{ $nextStage ?? false ? "Lanjut ke Materi Berikutnya 🚀" : "Kembali ke Roadmap 🗺️" }}';
        popupBtn.onclick = function() {
            closeTKJReward();
            window.location.href = NEXT_URL;
        };

    } catch (err) {
        btn.disabled = false;
        btn.textContent = '🎬 Tandai Selesai & Lanjut →';
        alert('Gagal menyimpan, coba lagi.');
    }
}

function loadYoutube(videoId) {
    const thumb = document.getElementById('ytThumb');
    if (!thumb) return;
    thumb.style.opacity = '0';
    thumb.style.pointerEvents = 'none';
    const iframe = document.createElement('iframe');
    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
    iframe.allowFullscreen = true;
    iframe.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:none;z-index:3;';
    document.getElementById('ytWrapper').appendChild(iframe);
    setTimeout(() => thumb.remove(), 400);
}

function toggleAcc(header) {
    const body = header.nextElementSibling;
    header.classList.toggle('is-open');
    body.classList.toggle('is-open');
}
</script>
@endpush