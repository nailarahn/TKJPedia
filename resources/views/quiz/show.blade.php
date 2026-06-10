@extends('layouts.dashboard')
@section('title', 'Kuis - ' . $stage->title)

@push('styles')
<style>
.quiz-wrap {
    max-width: 680px;
    margin: 0 auto;
    padding: 1.5rem 1rem 4rem;
}

/* Header */
.quiz-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    gap: 1rem;
}
.quiz-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .85rem;
    font-weight: 500;
    color: var(--gray-500);
    text-decoration: none;
    transition: color .2s;
}
.quiz-back:hover { color: var(--primary); }

.quiz-counter {
    font-size: .85rem;
    font-weight: 700;
    color: var(--gray-500);
}
.quiz-counter span { color: var(--primary); }

/* Progress bar */
.quiz-progress-track {
    width: 100%;
    height: 6px;
    background: var(--gray-200);
    border-radius: 99px;
    margin-bottom: 2rem;
    overflow: hidden;
}
.quiz-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--accent)); /* FIX: was just var(--primary) — tambah gradient biar konsisten */
    border-radius: 99px;
    transition: width .4s cubic-bezier(.4,0,.2,1);
}

/* Card soal */
.question-slide { display: none; }
.question-slide.active {
    display: block;
    animation: fadeUp .35s ease;
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.q-card {
    background: var(--white);
    border-radius: 20px;
    border: 1.5px solid var(--gray-200);  /* FIX: was #e9e6f5 ungu */
    padding: 2rem 2rem 1.5rem;
    box-shadow: 0 4px 24px rgba(255,77,0,0.06); /* FIX: was rgba(55,36,102,.06) ungu */
}
.q-label {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--primary);
    background: var(--gray-100);          /* FIX: was #f4f1ff ungu */
    padding: .3rem .85rem;
    border-radius: 99px;
    margin-bottom: 1.25rem;
}
.q-text {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gray-800);               /* FIX: was #1a1a2e hardcoded */
    line-height: 1.6;
    margin-bottom: 1.75rem;
}

/* Opsi */
.options-list {
    display: flex;
    flex-direction: column;
    gap: .65rem;
}
.opt {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .9rem 1.1rem;
    border: 2px solid var(--gray-200);    /* FIX: was #ede9f8 ungu */
    border-radius: 12px;
    cursor: pointer;
    transition: border-color .18s, background .18s, transform .12s;
    user-select: none;
}
.opt:hover {
    border-color: var(--primary);
    background: var(--gray-100);          /* FIX: was #f7f5ff ungu */
    transform: translateX(3px);
}
.opt.selected {
    border-color: var(--primary);
    background: var(--gray-100);          /* FIX: was #f4f1ff ungu */
}
.opt input[type="radio"] { display: none; }

.opt-key {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--gray-100);          /* FIX: was #f0edfb ungu */
    border: 2px solid var(--gray-200);    /* FIX: was #d4cdf0 ungu */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 800;
    color: var(--primary);
    transition: background .18s, border-color .18s, color .18s;
}
.opt.selected .opt-key {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}
.opt-text {
    font-size: .95rem;
    color: var(--gray-700);               /* FIX: was #374151 hardcoded */
    line-height: 1.5;
    flex: 1;
}

/* Nav bawah */
.quiz-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.75rem;
    gap: 1rem;
}
.btn-prev, .btn-next, .btn-submit-quiz {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .75rem 1.6rem;
    border-radius: 12px;
    font-size: .9rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    overflow: hidden;
}
.btn-prev {
    background: var(--gray-100);
    color: var(--primary);
}
.btn-prev:hover { background: var(--gray-200); }
.btn-prev:disabled { opacity: .35; cursor: not-allowed; }

.btn-next {
    background: var(--primary);
    color: #fff;
    margin-left: auto;
}
.btn-next::before {
    content: '';
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left .5s;
}
.btn-next:hover::before { left: 100%; }
.btn-next:hover {
    background: var(--primary-light);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px var(--accent-glow);
}
.btn-next:disabled {
    background: var(--gray-300);
    cursor: not-allowed;
    transform: none;
}

/* submit tetap hijau — semantik "selesai/kirim" */
.btn-submit-quiz {
    background: var(--primary);
    color: #fff;
    margin-left: auto;
    position: relative;
    overflow: hidden;
}
.btn-submit-quiz::before {
    content: '';
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left .5s;
}
.btn-submit-quiz:hover::before { left: 100%; }
.btn-submit-quiz:hover {
    background: var(--primary-light);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px var(--accent-glow);
}
.btn-submit-quiz:disabled {
    background: var(--gray-300);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Dot navigasi */
.quiz-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    margin-top: 1.25rem;
}
.dot {
    width: 8px;
    height: 8px;
    border-radius: 99px;
    background: var(--gray-200);
    transition: all .3s;
    cursor: pointer;
}
.dot.answered { background: var(--accent-light); } 
.dot.current  { background: var(--primary); width: 22px; }
</style>
@endpush

@section('content')

<div class="quiz-wrap">

    {{-- Header --}}
    <div class="quiz-top">
        <a href="{{ route('roadmap.stage', [$roadmapId, $stage->id]) }}" class="quiz-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
            Kembali ke Materi
        </a>
        <div class="quiz-counter">
            Soal <span id="cur-num">1</span> / {{ $quiz->questions->count() }}
        </div>
    </div>

    {{-- Progress bar --}}
    <div class="quiz-progress-track">
        <div class="quiz-progress-fill" id="prog-fill" style="width: {{ round(1 / $quiz->questions->count() * 100) }}%"></div>
    </div>

    {{-- Form --}}
    <form action="{{ route('roadmap.quiz.submit', [$roadmapId, $stage->id]) }}" method="POST" id="quiz-form">
        @csrf

        @foreach($quiz->questions as $index => $question)
        <div class="question-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
            <div class="q-card">
                <div class="q-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    Pertanyaan {{ $index + 1 }}
                </div>
                <p class="q-text">{{ $question->question }}</p>

                <div class="options-list">
                    @foreach($question->getOptionsArray() as $key => $option)
                    <label class="opt" id="opt-{{ $question->id }}-{{ $key }}">
                        <input
                            type="radio"
                            name="answers[{{ $question->id }}]"
                            value="{{ $key }}"
                            class="opt-radio"
                            data-qid="{{ $question->id }}"
                            onchange="selectOpt(this)"
                        >
                        <span class="opt-key">{{ strtoupper($key) }}</span>
                        <span class="opt-text">{{ $option }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Navigasi --}}
            <div class="quiz-nav">
                <button type="button" class="btn-prev" onclick="goTo({{ $index - 1 }})" {{ $index === 0 ? 'disabled' : '' }}>
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
                    Sebelumnya
                </button>

                @if($index < $quiz->questions->count() - 1)
                <button type="button" class="btn-next" id="next-{{ $index }}" onclick="goTo({{ $index + 1 }})">
                    Selanjutnya
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                @else
                <button type="submit" class="btn-submit-quiz" id="btn-submit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    Kumpulkan Jawaban
                </button>
                @endif
            </div>
        </div>
        @endforeach

    </form>

    {{-- Dot navigasi --}}
    <div class="quiz-dots" id="quiz-dots">
        @foreach($quiz->questions as $index => $question)
        <div class="dot {{ $index === 0 ? 'current' : '' }}"
             id="dot-{{ $index }}"
             onclick="goTo({{ $index }})"
             title="Soal {{ $index + 1 }}">
        </div>
        @endforeach
    </div>

</div>
@endsection

@push('scripts')
<script>
const total     = {{ $quiz->questions->count() }};
const answered  = {};
let   current   = 0;

function goTo(idx) {
    if (idx < 0 || idx >= total) return;

    // Sembunyikan slide aktif
    document.querySelectorAll('.question-slide').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.dot').forEach((d, i) => {
        d.classList.remove('current');
        d.classList.toggle('answered', !!answered[i] && i !== idx);
    });

    // Tampilkan slide baru
    document.querySelector(`.question-slide[data-index="${idx}"]`).classList.add('active');
    document.getElementById(`dot-${idx}`).classList.add('current');
    document.getElementById(`dot-${idx}`).classList.remove('answered');

    // Update counter & progress
    current = idx;
    document.getElementById('cur-num').textContent = idx + 1;
    const pct = Math.round(((idx + 1) / total) * 100);
    document.getElementById('prog-fill').style.width = pct + '%';
}

function selectOpt(radio) {
    const qid = radio.dataset.qid;

    // Reset semua opsi di soal ini
    document.querySelectorAll(`input[name="answers[${qid}]"]`).forEach(r => {
        document.getElementById(`opt-${qid}-${r.value}`).classList.remove('selected');
    });

    // Tandai yang dipilih
    document.getElementById(`opt-${qid}-${radio.value}`).classList.add('selected');

    // Catat jawaban
    answered[current] = radio.value;

    // Update dot
    document.getElementById(`dot-${current}`).classList.add('answered');

    // Aktifkan tombol submit kalau soal terakhir
    const submitBtn = document.getElementById('btn-submit');
    if (submitBtn) {
        const allAnswered = Object.keys(answered).length === total;
        submitBtn.disabled = !allAnswered;
        if (allAnswered) {
            submitBtn.style.background = '#16a34a';
        }
    }
}

// Submit guard — pastikan semua soal dijawab
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    if (Object.keys(answered).length < total) {
        e.preventDefault();
        const unanswered = total - Object.keys(answered).length;
        alert(`Masih ada ${unanswered} soal yang belum dijawab. Cek kembali semua soal ya!`);
        // Arahkan ke soal pertama yang belum dijawab
        for (let i = 0; i < total; i++) {
            if (!answered[i]) { goTo(i); break; }
        }
    }
});
</script>
@endpush