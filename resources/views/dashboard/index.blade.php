@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('styles')
<style>
.page-header { margin-bottom: 1.75rem; }
.page-greeting { font-size: 1.75rem; font-weight: 800; color: var(--primary); }
.page-greeting span { color: var(--gray-800); }
.page-sub { font-size: 0.9rem; color: var(--gray-400); margin-top: 0.25rem; }

.continue-card {
    background: var(--white);
    border-radius: var(--radius);
    border: 1.5px solid var(--gray-200);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.continue-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
}

.continue-info { flex: 1; }

.continue-title { font-size: 1.1rem; font-weight: 700; color: var(--gray-800); }

.continue-stage { font-size: 0.82rem; color: var(--gray-400); margin: 0.25rem 0 0.75rem; }

.continue-progress { margin-bottom: 0.75rem; }

.rec-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    transition: background 0.2s;
}

.rec-item:last-child { border-bottom: none; }

.rec-item:hover { background: var(--gray-100); }

.rec-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.rec-info { flex: 1; }

.rec-title { font-size: 0.9rem; font-weight: 600; color: var(--gray-800); }

.rec-meta { font-size: 0.78rem; color: var(--gray-400); }

.rec-arrow { color: var(--gray-400); font-size: 1rem; }

.rec-arrow:hover { color: var(--primary); }

canvas { max-width: 100%; }

.stat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.stat-card-link .stat-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.stat-card-link:hover .stat-card {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px var(--accent-glow);
}

/* ===== PROGRESS CARD ===== */
.progress-card {
    width: 100%;
    border: none;
    overflow: hidden;
    border-radius: 20px;
    background: var(--white);
    box-shadow:
        0 10px 30px rgba(255,77,0,0.08),
        0 2px 8px rgba(255,77,0,0.05);
}

.progress-card .card-header {
    background: linear-gradient(
        135deg,
        var(--primary) 0%,
        var(--accent) 100%
    );
    color: white;
    font-size: 1rem;
    font-weight: 700;
    padding: 1rem 1.5rem;
    border: none;

    .current-title{
    font-size:1rem;
    font-weight:700;
    line-height:1.3;
    min-height:50px;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

/* ===== GAMIFICATION STATS ===== */
.gamification-bar{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:1rem;
    margin-bottom:1.5rem;
}

.game-box{
    background:linear-gradient(135deg,#fff,#fff7ed);
    border:1.5px solid #ffe0bf;
    border-radius:18px;
    padding:1rem 1.2rem;
    display:flex;
    align-items:center;
    gap:.9rem;
    transition:.3s;
}

.game-box:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 25px rgba(255,77,0,.12);
}

.game-icon{
    width:55px;
    height:55px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.5rem;
    background:#fff3e6;
}

.game-title{
    font-size:.75rem;
    color:var(--gray-400);
}

.game-value{
    font-size:1.2rem;
    font-weight:700;
    color:var(--gray-800);
}

.badge-progress{
    background:linear-gradient(135deg,#ff6a00,#ff9b3d);
    color:white;
    padding:.4rem 1rem;
    border-radius:99px;
    font-size:.85rem;
    font-weight:700;
}

.progress-chart{
    position:relative;
}

}
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-greeting">
        Halo, <span>{{ explode(' ', Auth::user()->name)[0] }}!</span> 👋
    </div>
    <div class="page-sub">Semangat belajar hari ini!</div>
</div>

@if(!$activeEnrollment)
    <div class="alert alert-info mb-4">
        🎉 Selamat datang di TKJPedia! Kamu belum memilih roadmap belajar.
        Yuk mulai dengan memilih roadmap yang tersedia.
    </div>
@endif

<!-- STAT CARDS -->
<div class="stat-cards">

    {{-- TOTAL PROGRESS --}}
    <a href="{{ route('progress') }}" class="stat-card-link">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-label">Total Progress</span>
                <div class="stat-icon" style="background:var(--gray-100);">📊</div> {{-- FIX: was #ede9ff ungu --}}
            </div>
            <div class="stat-value">
                {{ $activeEnrollment?->progress ?? 0 }}%
            </div>
            <div class="stat-progress">
                <div class="progress-bar">
                    <div class="progress-fill"
                         style="width:{{ $activeEnrollment?->progress ?? 0 }}%">
                    </div>
                </div>
            </div>
        </div>
    </a>

    {{-- TAHAP SAAT INI --}}
    <a href="{{ route('roadmap') }}" class="stat-card-link">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-label">Tahap saat ini</span>
                <div class="stat-icon" style="background:#fff7ed;">📖</div>
            </div>
            <div class="stat-value current-title">
    {{ $activeEnrollment?->roadmap?->title ?? 'Belum Memilih Roadmap' }}
</div>
            <div class="stat-progress">
                <div class="progress-bar">
                    <div class="progress-fill"
                         style="width:{{ $activeEnrollment?->progress ?? 0 }}%">
                    </div>
                </div>
            </div>
        </div>
    </a>

    {{-- MATERI SELESAI --}}
    <a href="{{ route('roadmap') }}" class="stat-card-link">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-label">Materi Selesai</span>
                <div class="stat-icon" style="background:#ecfdf5;">📚</div>
            </div>
            <div class="stat-value">
                {{ $materiSelesai ?? 0 }}
                <span style="font-size:1rem;color:var(--gray-400);font-weight:500;">
                    /{{ $totalMateri ?? 0 }}
                </span>
            </div>
            <div class="stat-progress">
                <div class="progress-bar">
                    <div class="progress-fill"
                         style="width:{{ ($totalMateri ?? 0) > 0 ? ($materiSelesai / $totalMateri) * 100 : 0 }}%">
                    </div>
                </div>
            </div>
        </div>
    </a>

    {{-- KUIS SELESAI --}}
<a href="{{ route('progress') }}" class="stat-card-link">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Kuis Selesai</span>
            <div class="stat-icon" style="background:#eef2ff;">🧠</div>
        </div>

        <div class="stat-value">
            {{ $kuisSelesai ?? 0 }}
            <span style="font-size:1rem;color:var(--gray-400);font-weight:500;">
                /{{ $totalKuis ?? 0 }}
            </span>
        </div>

        <div class="stat-progress">
            <div class="progress-bar">
                <div class="progress-fill"
                     style="width:{{ ($totalKuis ?? 0) > 0 ? ($kuisSelesai / $totalKuis) * 100 : 0 }}%">
                </div>
            </div>
        </div>
    </div>
</a>

    {{-- TARGET MINGGU --}}
    <a href="{{ route('target') }}" class="stat-card-link">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-label">Target Minggu</span>
                <div class="stat-icon" style="background:#f0fdf4;">🎯</div>
            </div>
            <div class="stat-value">
                {{ $targetSelesai ?? 0 }}
                <span style="font-size:1rem;color:var(--gray-400);font-weight:500;">
                    /{{ $totalTarget ?? 0 }}
                </span>
            </div>
            <div class="stat-progress">
                <div class="progress-bar">
                    <div class="progress-fill"
                         style="width:{{ ($totalTarget ?? 0) > 0 ? ($targetSelesai / $totalTarget) * 100 : 0 }}%">
                    </div>
                </div>
            </div>
        </div>
    </a>

</div>

<!-- LANJUTKAN & REKOMENDASI -->
<div class="grid-2" style="margin-bottom:1.5rem;">

    <!-- Lanjutkan Belajar -->
    <div class="card">
        <div class="card-header">Lanjutkan Belajar</div>
        <div class="card-body">
            <div class="continue-card" style="border:none;padding:0;">
                <div class="continue-icon">🔗</div>
                <div class="continue-info">
                    @if($activeEnrollment)
                        <div class="continue-title">
                            {{ $activeEnrollment->roadmap->title }}
                        </div>
                        <div class="continue-stage">
                            Progress {{ $activeEnrollment->progress }}%
                        </div>
                        <div class="continue-progress">
                            <div class="progress-bar">
                                <div class="progress-fill"
                                     style="width:{{ $activeEnrollment->progress }}%">
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('roadmap') }}" class="btn btn-primary btn-sm">
                            Lanjutkan →
                        </a>
                    @else
                        <div class="continue-title">Belum ada roadmap aktif</div>
                        <div class="continue-stage">Pilih roadmap untuk mulai belajar</div>
                        <a href="{{ route('roadmap') }}" class="btn btn-primary btn-sm">
                            Pilih Roadmap
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    <div class="card">
        <div class="card-header">Rekomendasi Materi Untukmu</div>
        @foreach($recommendations as $rec)
            <a href="{{ $rec['route'] }}" class="rec-item">
                <div class="rec-icon" style="background:{{ $rec['color'] }}22;">
                    {{ $rec['icon'] }}
                </div>
                <div class="rec-info">
                    <div class="rec-title">{{ $rec['title'] }}</div>
                    <div class="rec-meta">{{ $rec['type'] }} · {{ $rec['duration'] }}</div>
                </div>
                <span class="rec-arrow">›</span>
            </a>
        @endforeach
    </div>

</div>


<!-- GRAFIK PROGRESS -->
<div class="card progress-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📈 Ringkasan Progress Belajar</span>
        <span class="badge-progress">
            {{ end($progressData)['progress'] ?? 75 }}%
        </span>
    </div>
    <div class="card-body">
        <div class="progress-chart">
            <canvas id="progressChart" height="90"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('progressChart').getContext('2d');
const progressData = @json($progressData);

const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(255, 77, 0, 0.25)');
gradient.addColorStop(1, 'rgba(255, 77, 0, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: progressData.map(d => d.minggu),
        datasets: [{
            label: 'Progress',
            data: progressData.map(d => d.progress),
            borderColor: '#FF4D00',
            backgroundColor: gradient,
            borderWidth: 2.5,
            pointBackgroundColor: '#FF4D00',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: { family: 'Poppins', size: 12 },
                    color: '#9a6a4a',
                    usePointStyle: true,
                    pointStyleWidth: 8,
                }
            }
        },
        scales: {
            y: {
                min: 0, max: 100,
                grid: { color: 'rgba(255,77,0,0.07)' },
                ticks: {
                    font: { family: 'Poppins', size: 11 },
                    color: '#c28d6d'
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { family: 'Poppins', size: 11 },
                    color: '#c28d6d'
                }
            }
        }
    }
});
</script>
@endpush