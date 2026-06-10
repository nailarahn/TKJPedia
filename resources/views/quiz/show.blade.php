@extends('layouts.dashboard')

@section('content')
<div class="quiz-container">

    {{-- Header --}}
    <div class="quiz-header">
        <a href="{{ url()->previous() }}" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali ke Materi
        </a>
        <div class="quiz-meta">
            <span class="quiz-badge-label">
                <i class="ti ti-help-circle"></i> Kuis
            </span>
            <h1 class="quiz-title">{{ $quiz->title }}</h1>
            <p class="quiz-subtitle">{{ $stage->title }}</p>
        </div>
        <div class="quiz-info-row">
            <div class="quiz-info-chip">
                <i class="ti ti-list-numbers"></i>
                {{ $quiz->questions->count() }} Soal
            </div>
            <div class="quiz-info-chip">
                <i class="ti ti-trophy"></i>
                Nilai lulus {{ $quiz->passing_score }}%
            </div>
            <div class="quiz-info-chip">
                <i class="ti ti-coin"></i>
                +{{ $quiz->points_reward }} poin
            </div>
            @if($lastAttempt)
            <div class="quiz-info-chip {{ $lastAttempt->is_passed ? 'chip-success' : 'chip-danger' }}">
                <i class="ti ti-history"></i>
                Percobaan terakhir: {{ $lastAttempt->score }}%
            </div>
            @endif
        </div>
    </div>

    {{-- Form Soal --}}
    <form action="{{ route('roadmap.quiz.submit', [$roadmapId, $stage->id]) }}" method="POST" id="quiz-form">
        @csrf

        @foreach($quiz->questions as $index => $question)
        <div class="question-card" id="question-{{ $question->id }}">
            <div class="question-number">Soal {{ $index + 1 }}</div>
            <p class="question-text">{{ $question->question }}</p>

            <div class="options-grid">
                @foreach($question->getOptionsArray() as $key => $option)
                <label class="option-label" for="ans_{{ $question->id }}_{{ $key }}">
                    <input
                        type="radio"
                        name="answers[{{ $question->id }}]"
                        id="ans_{{ $question->id }}_{{ $key }}"
                        value="{{ $key }}"
                        class="option-radio"
                        required
                    >
                    <span class="option-key">{{ strtoupper($key) }}</span>
                    <span class="option-text">{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- Submit --}}
        <div class="quiz-submit-area">
            <div class="submit-warning">
                <i class="ti ti-info-circle"></i>
                Pastikan semua soal sudah dijawab sebelum submit.
            </div>
            <button type="submit" class="btn-submit" id="btn-submit">
                <i class="ti ti-send"></i> Kumpulkan Jawaban
            </button>
        </div>
    </form>

</div>

{{-- Progress soal (floating) --}}
<div class="quiz-progress-bar" id="quiz-progress-bar">
    <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
    <span class="progress-label" id="progress-label">0 / {{ $quiz->questions->count() }} dijawab</span>
</div>
@endsection

@push('styles')
<style>
    .quiz-container {
        max-width: 760px;
        margin: 0 auto;
        padding: 2rem 1.5rem 6rem;
    }

    /* Header */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .875rem;
        color: var(--color-text-secondary);
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: color .2s;
    }
    .btn-back:hover { color: var(--color-text-primary); }

    .quiz-header {
        margin-bottom: 2rem;
    }
    .quiz-badge-label {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .75rem;
        font-weight: 500;
        color: #185FA5;
        background: #E6F1FB;
        padding: .25rem .75rem;
        border-radius: 99px;
        margin-bottom: .75rem;
    }
    .quiz-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin: 0 0 .25rem;
    }
    .quiz-subtitle {
        font-size: .9rem;
        color: var(--color-text-secondary);
        margin: 0 0 1rem;
    }
    .quiz-info-row {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
    }
    .quiz-info-chip {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .8rem;
        color: var(--color-text-secondary);
        background: var(--color-background-secondary);
        border: 1px solid var(--color-border-tertiary);
        padding: .3rem .75rem;
        border-radius: 99px;
    }
    .chip-success { color: #0F6E56; background: #E1F5EE; border-color: #9FE1CB; }
    .chip-danger  { color: #993C1D; background: #FAECE7; border-color: #F5C4B3; }

    /* Question card */
    .question-card {
        background: var(--color-background-primary);
        border: 1px solid var(--color-border-tertiary);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        transition: border-color .2s, box-shadow .2s;
    }
    .question-card.answered {
        border-color: #9FE1CB;
    }
    .question-number {
        font-size: .75rem;
        font-weight: 600;
        color: #185FA5;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: .75rem;
    }
    .question-text {
        font-size: 1rem;
        color: var(--color-text-primary);
        line-height: 1.6;
        margin: 0 0 1.25rem;
    }

    /* Options */
    .options-grid {
        display: flex;
        flex-direction: column;
        gap: .6rem;
    }
    .option-label {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        border: 1.5px solid var(--color-border-tertiary);
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }
    .option-label:hover {
        border-color: #378ADD;
        background: #E6F1FB;
    }
    .option-radio { display: none; }
    .option-radio:checked + .option-key {
        background: #185FA5;
        color: #fff;
    }
    .option-label:has(.option-radio:checked) {
        border-color: #185FA5;
        background: #E6F1FB;
    }
    .option-key {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--color-background-secondary);
        border: 1.5px solid var(--color-border-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        font-weight: 700;
        color: var(--color-text-secondary);
        transition: background .15s, color .15s;
    }
    .option-text {
        font-size: .9rem;
        color: var(--color-text-primary);
        line-height: 1.5;
    }

    /* Submit area */
    .quiz-submit-area {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--color-background-secondary);
        border-radius: 16px;
        border: 1px solid var(--color-border-tertiary);
    }
    .submit-warning {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .85rem;
        color: var(--color-text-secondary);
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .75rem 2rem;
        background: #185FA5;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: .95rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, transform .1s;
    }
    .btn-submit:hover    { background: #0C447C; }
    .btn-submit:active   { transform: scale(.98); }
    .btn-submit:disabled { background: #B5D4F4; cursor: not-allowed; }

    /* Floating progress bar */
    .quiz-progress-bar {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        height: 48px;
        background: var(--color-background-primary);
        border-top: 1px solid var(--color-border-tertiary);
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
        gap: 1rem;
        z-index: 50;
    }
    .progress-fill {
        height: 6px;
        background: #185FA5;
        border-radius: 99px;
        transition: width .3s ease;
        flex: 1;
    }
    .quiz-progress-bar { flex-direction: row; }
    .progress-label {
        font-size: .8rem;
        color: var(--color-text-secondary);
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
<script>
    const totalQuestions = {{ $quiz->questions->count() }};
    const radios = document.querySelectorAll('.option-radio');
    const progressFill  = document.getElementById('progress-fill');
    const progressLabel = document.getElementById('progress-label');

    function updateProgress() {
        const answered = new Set();
        document.querySelectorAll('.option-radio:checked').forEach(r => {
            const name = r.getAttribute('name');
            answered.add(name);
        });

        const count = answered.size;
        const pct   = Math.round((count / totalQuestions) * 100);
        progressFill.style.width  = pct + '%';
        progressLabel.textContent = count + ' / ' + totalQuestions + ' dijawab';

        // Tandai card yang sudah dijawab
        document.querySelectorAll('.question-card').forEach(card => {
            const id      = card.id.replace('question-', '');
            const checked = document.querySelector(`input[name="answers[${id}]"]:checked`);
            card.classList.toggle('answered', !!checked);
        });
    }

    radios.forEach(r => r.addEventListener('change', updateProgress));
</script>
@endpush