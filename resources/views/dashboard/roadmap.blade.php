@extends('layouts.dashboard')
@section('title', 'Roadmap Pembelajaran')

@push('styles')
<style>

.page-header { 
    margin-bottom: 2rem; 
}
.page-title { 
    font-size: 1.6rem; 
    font-weight: 800; 
    color: var(--gray-800); 
}
.page-sub { 
    font-size: 0.9rem; 
    color: var(--gray-400); 
    margin-top: 0.25rem; 
}

.level-tabs {
    display: flex;
    border-bottom: 2px solid var(--gray-200);
    margin-bottom: 2rem;
    gap: 0;
}
.level-tab {
    flex: 1;
    padding: 0.85rem 1rem;
    text-align: center;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--gray-400);
    cursor: pointer;
    border: none;
    background: none;
    font-family: var(--font);
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s;
}
.level-tab:hover { 
    color: var(--primary); 
}
.level-tab.active {
    color: var(--primary);
    border-bottom-color: var(--primary);
}

.stage-list {
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
}

.stage-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 23px;
    top: 46px;
    height: calc(100% + 0px);
    width: 2px;
    background: var(--gray-200);
    z-index: 0;
}

.stage-item {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1rem 1.25rem 1rem 0;
    cursor: pointer;
    transition: background 0.15s;
    border-radius: 12px;
    position: relative;
    z-index: 1;
    text-decoration: none;
}
.stage-item:hover { background: var(--gray-100); padding-left: 0.5rem; }
.stage-item.locked { cursor: not-allowed; opacity: 0.6; }
.stage-item.locked:hover { background: none; padding-left: 0; }

.stage-num {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    border: 2px solid var(--gray-300);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--gray-500);
    flex-shrink: 0;
    z-index: 2;
    transition: all 0.2s;
}
.stage-num.done {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}
.stage-num.current {
    background: white;
    border-color: var(--primary);
    color: var(--primary);
    box-shadow: 0 0 0 4px var(--accent-glow);
}

.stage-info { 
    flex: 1; 
}
.stage-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.2rem;
}
.stage-meta {
    font-size: 0.78rem;
    color: var(--gray-400);
}

.stage-action {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    flex-shrink: 0;
}
.stage-action.done-icon { 
    color: #22c55e; 
}
.stage-action.arrow-icon { 
    color: var(--gray-400); 
    font-size: 1.1rem; 
}
.stage-action.lock-icon { 
    color: var(--gray-300); 
}

.tab-content { 
    display: none; 
}
.tab-content.active { 
    display: block; 
}

.roadmap-pills {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.roadmap-pill {
    padding: 0.45rem 1.1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid var(--gray-200);
    background: var(--white);
    color: var(--gray-500);
    font-family: var(--font);
    transition: all 0.2s;
}
.roadmap-pill.active,
.roadmap-pill:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

.enrolled-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: #ecfdf5;
    color: #16a34a;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    margin-left: 0.75rem;
}

.roadmap-progress-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--white);
    border: 1.5px solid var(--gray-200);
    border-radius: 14px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.75rem;
}
.roadmap-progress-bar .label { 
    font-size: 0.82rem; 
    color: var(--gray-400); 
    font-weight: 500; 
    min-width: 90px; 
}
.roadmap-progress-bar .bar { 
    flex: 1; 
}
.roadmap-progress-bar .pct {
    font-size: 0.9rem; 
    font-weight: 700; 
    color: var(--primary); 
    min-width: 40px; 
    text-align: right; 
}

.enroll-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary);
    color: white;
    padding: 0.65rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    font-family: var(--font);
    transition: all 0.2s;
    position: relative;
    overflow: hidden;
}
.enroll-btn::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s;
}
.enroll-btn:hover::before { left: 100%; }
.enroll-btn:hover {
    background: var(--primary-light);
    box-shadow: 0 4px 15px var(--accent-glow);
    transform: translateY(-1px);
}

@media (max-width: 640px) {
    .stage-item:not(:last-child)::after { left: 19px; top: 38px; }
    .stage-num { width: 38px; height: 38px; font-size: 0.8rem; }
    .stage-title { font-size: 0.875rem; }
}

</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-title">Roadmap Pembelajaran</div>
    <div class="page-sub">Pilih roadmap yang ingin kamu pelajari dan mulai perjalananmu</div>
</div>

<!-- LEVEL TABS -->
<div class="level-tabs">
    <button class="level-tab active" onclick="switchLevel('dasar', this)">Dasar</button>
    <button class="level-tab" onclick="switchLevel('menengah', this)">Menengah</button>
    <button class="level-tab" onclick="switchLevel('lanjutan', this)">Lanjutan</button>
</div>

{{-- ==================== TAB DASAR ==================== --}}
<div class="tab-content active" id="tab-dasar">
    @php $dasarRoadmaps = collect($roadmaps)->where('level', 'beginner'); @endphp

    @if($dasarRoadmaps->isEmpty())
        <div style="text-align:center;padding:3rem;color:var(--gray-400);">Belum ada roadmap level dasar.</div>
    @else

    <div class="roadmap-pills" id="pills-dasar">
        @foreach($dasarRoadmaps as $i => $rm)
        <button class="roadmap-pill {{ $i === 0 ? 'active' : '' }}"
                onclick="switchRoadmap('dasar', {{ $rm->id }}, this)">
            {{ $rm->title }}
            @if($rm->is_enrolled)
                <span style="opacity:.7">✓</span>
            @endif
        </button>
        @endforeach
    </div>

    @foreach($dasarRoadmaps as $i => $rm)
    <div class="roadmap-stages {{ $i === 0 ? '' : 'd-none' }}" id="stages-dasar-{{ $rm->id }}">

        @if($rm->is_enrolled)
        <div class="roadmap-progress-bar">
            <span class="label">Progress kamu</span>
            <div class="bar">
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $rm->user_progress }}%"></div>
                </div>
            </div>
            <span class="pct">{{ $rm->user_progress }}%</span>
        </div>
        @else
        <div style="margin-bottom:1.5rem;">
            <form method="POST" action="{{ route('roadmap.enroll', $rm->id) }}" style="display:inline;">
                @csrf
                <button type="submit" class="enroll-btn">
                    + Mulai Roadmap Ini
                </button>
            </form>
        </div>
        @endif

        <div class="stage-list">
            @foreach($rm->stages as $stage)
            @php
                $isDone    = in_array($stage->id, $completedStageIds);
                $isCurrent = !$isDone && $rm->is_enrolled && $loop->index === $rm->stages->where('id', collect($completedStageIds)->last())->keys()->first() + 1;
                $isLocked  = !$rm->is_enrolled && !$isDone;
                $isFirst   = $loop->first;
                $canAccess = $rm->is_enrolled || $isFirst;
            @endphp

            @if($canAccess && !$isLocked)
            <a href="{{ route('roadmap.stage', ['roadmapId' => $rm->id, 'stageId' => $stage->id]) }}"
               class="stage-item {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">
            @else
            <div class="stage-item locked">
            @endif
                <div class="stage-num {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">
                    @if($isDone)
                        ✓
                    @else
                        {{ $loop->iteration }}
                    @endif
                </div>
                <div class="stage-info">
                    <div class="stage-title">{{ $stage->title }}</div>
                    <div class="stage-meta">{{ $stage->getTypeLabel() }} · {{ $stage->estimated_minutes }} menit</div>
                </div>
                <div class="stage-action {{ $isDone ? 'done-icon' : ($isLocked ? 'lock-icon' : 'arrow-icon') }}">
                    @if($isDone)
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <circle cx="13" cy="13" r="13" fill="#22c55e"/>
                            <path d="M7 13l4 4 8-8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @elseif($isLocked)
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                    @else
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    @endif
                </div>
            @if($canAccess && !$isLocked)
            </a>
            @else
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
    @endif
</div>

{{-- ==================== TAB MENENGAH ==================== --}}
<div class="tab-content" id="tab-menengah">
    @php $menengahRoadmaps = collect($roadmaps)->where('level','intermediate'); @endphp
    @if($menengahRoadmaps->isEmpty())
        <div style="text-align:center;padding:3rem;color:var(--gray-400);">Belum ada roadmap level menengah.</div>
    @else
        <div class="roadmap-pills" id="pills-menengah">
            @foreach($menengahRoadmaps as $rm)
            <button class="roadmap-pill {{ $loop->first ? 'active' : '' }}"
                    onclick="switchRoadmap('menengah', {{ $rm->id }}, this)">
                {{ $rm->title }}
            </button>
            @endforeach
        </div>
        @foreach($menengahRoadmaps as $rm)
        <div class="roadmap-stages {{ $loop->first ? '' : 'd-none' }}" id="stages-menengah-{{ $rm->id }}">
            @if($rm->is_enrolled)
            <div class="roadmap-progress-bar">
                <span class="label">Progress kamu</span>
                <div class="bar">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $rm->user_progress }}%"></div>
                    </div>
                </div>
                <span class="pct">{{ $rm->user_progress }}%</span>
            </div>
            @else
            <div style="margin-bottom:1.5rem;">
                <form method="POST" action="{{ route('roadmap.enroll', $rm->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="enroll-btn">
                        + Mulai Roadmap Ini
                    </button>
                </form>
            </div>
            @endif
            <div class="stage-list">
                @foreach($rm->stages as $stage)
                @php $isDone = in_array($stage->id, $completedStageIds); @endphp
                @if($rm->is_enrolled)
                <a href="{{ route('roadmap.stage', ['roadmapId' => $rm->id, 'stageId' => $stage->id]) }}" class="stage-item">
                @else
                <div class="stage-item locked">
                @endif
                    <div class="stage-num {{ $isDone ? 'done' : '' }}">{{ $isDone ? '✓' : $loop->iteration }}</div>
                    <div class="stage-info">
                        <div class="stage-title">{{ $stage->title }}</div>
                        <div class="stage-meta">{{ $stage->getTypeLabel() }} · {{ $stage->estimated_minutes }} menit</div>
                    </div>
                    <div class="stage-action {{ $isDone ? 'done-icon' : ($rm->is_enrolled ? 'arrow-icon' : 'lock-icon') }}">
                        @if($isDone)
                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"><circle cx="13" cy="13" r="13" fill="#22c55e"/><path d="M7 13l4 4 8-8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @elseif(!$rm->is_enrolled)
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        @else
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                        @endif
                    </div>
                @if($rm->is_enrolled)</a>@else</div>@endif
                @endforeach
            </div>
        </div>
        @endforeach
    @endif
</div>

{{-- ==================== TAB LANJUTAN ==================== --}}
<div class="tab-content" id="tab-lanjutan">
    @php $lanjutanRoadmaps = collect($roadmaps)->where('level','advanced'); @endphp
    @if($lanjutanRoadmaps->isEmpty())
        <div style="text-align:center;padding:3rem;color:var(--gray-400);">Belum ada roadmap level lanjutan.</div>
    @else
        <div class="roadmap-pills" id="pills-lanjutan">
            @foreach($lanjutanRoadmaps as $rm)
            <button class="roadmap-pill {{ $loop->first ? 'active' : '' }}"
                    onclick="switchRoadmap('lanjutan', {{ $rm->id }}, this)">{{ $rm->title }}</button>
            @endforeach
        </div>
        @foreach($lanjutanRoadmaps as $rm)
        <div class="roadmap-stages {{ $loop->first ? '' : 'd-none' }}" id="stages-lanjutan-{{ $rm->id }}">
            @if(!$rm->is_enrolled)
            <div style="margin-bottom:1.5rem;">
                <form method="POST" action="{{ route('roadmap.enroll', $rm->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="enroll-btn">
                        + Mulai Roadmap Ini
                    </button>
                </form>
            </div>
            @endif
            <div class="stage-list">
                @foreach($rm->stages as $stage)
                @php $isDone = in_array($stage->id, $completedStageIds); @endphp
                @if($rm->is_enrolled)
                <a href="{{ route('roadmap.stage', ['roadmapId' => $rm->id, 'stageId' => $stage->id]) }}" class="stage-item">
                @else
                <div class="stage-item locked">
                @endif
                    <div class="stage-num {{ $isDone ? 'done' : '' }}">{{ $isDone ? '✓' : $loop->iteration }}</div>
                    <div class="stage-info">
                        <div class="stage-title">{{ $stage->title }}</div>
                        <div class="stage-meta">{{ $stage->getTypeLabel() }} · {{ $stage->estimated_minutes }} menit</div>
                    </div>
                    <div class="stage-action {{ $isDone ? 'done-icon' : ($rm->is_enrolled ? 'arrow-icon' : 'lock-icon') }}">
                        @if($isDone)
                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"><circle cx="13" cy="13" r="13" fill="#22c55e"/><path d="M7 13l4 4 8-8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @elseif(!$rm->is_enrolled)
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        @else
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                        @endif
                    </div>
                @if($rm->is_enrolled)</a>@else</div>@endif
                @endforeach
            </div>
        </div>
        @endforeach
    @endif
</div>

@endsection

@push('scripts')
<script>
function switchLevel(level, btn) {
    document.querySelectorAll('.level-tab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + level).classList.add('active');
}

function switchRoadmap(level, roadmapId, btn) {
    document.querySelectorAll(`[id^="stages-${level}-"]`).forEach(el => el.classList.add('d-none'));
    document.querySelectorAll(`#pills-${level} .roadmap-pill`).forEach(b => b.classList.remove('active'));
    document.getElementById(`stages-${level}-${roadmapId}`)?.classList.remove('d-none');
    btn.classList.add('active');
}
</script>
@endpush