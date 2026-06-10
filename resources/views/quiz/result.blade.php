@extends('layouts.dashboard')

@section('content')
<div class="result-container">

    {{-- Badge baru (muncul kalau dapat badge) --}}
    @if($newBadge)
    <div class="badge-toast" id="badge-toast">
        <span class="badge-toast-icon">{{ $newBadge->icon }}</span>
        <div>
            <div class="badge-toast-title">Badge Baru Didapat!</div>
            <div class="badge-toast-name">{{ $newBadge->name }}</div>
        </div>
        <button onclick="document.getElementById('badge-toast').remove()" class="badge-toast-close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    @endif

    {{-- Kartu skor utama --}}
    <div class="result-card {{ $attempt->is_passed ? 'result-pass' : 'result-fail' }}">
        <div class="result-icon">
            @if($attempt->is_passed)
                <i class="ti ti-rosette-discount-check"></i>
            @else
                <i class="ti ti-circle-x"></i>
            @endif
        </div>
        <div class="result-status">
            {{ $attempt->is_passed ? 'Selamat, Kamu Lulus!' : 'Belum Lulus' }}
        </div>
        <div class="result-score">{{ $attempt->score }}<span class="result-score-unit">%</span></div>
        <div class="result-score-detail">
            {{ $attempt->correct_count }} benar dari {{ $attempt->total_questions }} soal
            &nbsp;·&nbsp; Nilai lulus {{ $quiz->passing_score }}%
        </div>

        @if($attempt->is_passed)
        <div class="result-points">
            <i class="ti ti-coin"></i> +{{ $quiz->points_reward }} poin didapat
        </div>
        @endif
    </div>

    {{-- Review jawaban per soal --}}
    <h2 class="review-heading">Review Jawaban</h2>

    @foreach($quiz->questions as $index => $question)
        @php
            $detail     = $attempt->answers[$question->id] ?? null;
            $userAns    = $detail['user_answer']    ?? null;
            $correctAns = $detail['correct_answer'] ?? $question->correct_answer;
            $isCorrect  = $detail['is_correct']     ?? false;
            $explanation= $detail['explanation']    ?? $question->explanation;
            $options    = $question->getOptionsArray();
        @endphp

        <div class="review-card {{ $isCorrect ? 'review-correct' : 'review-wrong' }}">
            {{-- Nomor + status --}}
            <div class="review-card-header">
                <span class="review-number">Soal {{ $index + 1 }}</span>
                <span class="review-status-chip {{ $isCorrect ? 'chip-correct' : 'chip-wrong' }}">
                    @if($isCorrect)
                        <i class="ti ti-check"></i> Benar
                    @else
                        <i class="ti ti-x"></i> Salah
                    @endif
                </span>
            </div>

            {{-- Pertanyaan --}}
            <p class="review-question">{{ $question->question }}</p>

            {{-- Opsi jawaban --}}
            <div class="review-options">
                @foreach($options as $key => $option)
                    @php
                        $isUserAnswer    = $userAns === $key;
                        $isCorrectAnswer = $correctAns === $key;
                    @endphp
                    <div class="review-option
                        {{ $isCorrectAnswer ? 'option-correct' : '' }}
                        {{ $isUserAnswer && !$isCorrectAnswer ? 'option-wrong-pick' : '' }}
                    ">
                        <span class="review-option-key">{{ strtoupper($key) }}</span>
                        <span class="review-option-text">{{ $option }}</span>
                        @if($isCorrectAnswer)
                            <i class="ti ti-check review-option-icon icon-correct"></i>
                        @elseif($isUserAnswer && !$isCorrectAnswer)
                            <i class="ti ti-x review-option-icon icon-wrong"></i>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Penjelasan --}}
            @if($explanation)
            <div class="review-explanation">
                <i class="ti ti-bulb"></i>
                <span>{{ $explanation }}</span>
            </div>
            @endif
        </div>
    @endforeach

    {{-- Tombol aksi bawah --}}
    <div class="result-actions">
        @if(!$attempt->is_passed)
        <a href="{{ route('roadmap.quiz', [$roadmapId, $stage->id]) }}" class="btn-retry">
            <i class="ti ti-refresh"></i> Coba Lagi
        </a>
        @endif

        @if($nextStage && $attempt->is_passed)
        <a href="{{ route('roadmap.stage', [$roadmapId, $nextStage->id]) }}" class="btn-next">
            Materi Selanjutnya <i class="ti ti-arrow-right"></i>
        </a>
        @endif

        <a href="{{ route('roadmap') }}" class="btn-back-roadmap">
            <i class="ti ti-map"></i> Kembali ke Roadmap
        </a>
    </div>

</div>
@endsection

@push('styles')
<style>
    .result-container {
        max-width: 760px;
        margin: 0 auto;
        padding: 2rem 1.5rem 4rem;
    }

    /* Badge toast */
    .badge-toast {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #EEEDFE;
        border: 1.5px solid #AFA9EC;
        border-radius: 14px;
        margin-bottom: 1.5rem;
        animation: slideDown .4s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .badge-toast-icon   { font-size: 2rem; }
    .badge-toast-title  { font-size: .75rem; font-weight: 600; color: #534AB7; }
    .badge-toast-name   { font-size: 1rem; font-weight: 700; color: #3C3489; }
    .badge-toast-close  {
        margin-left: auto;
        background: none;
        border: none;
        color: #534AB7;
        cursor: pointer;
        font-size: 1rem;
    }

    /* Kartu skor */
    .result-card {
        text-align: center;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        border: 1.5px solid var(--color-border-tertiary);
        margin-bottom: 2rem;
    }
    .result-pass { background: #E1F5EE; border-color: #9FE1CB; }
    .result-fail { background: #FAECE7; border-color: #F5C4B3; }

    .result-icon { font-size: 3.5rem; margin-bottom: .5rem; }
    .result-pass .result-icon { color: #0F6E56; }
    .result-fail .result-icon { color: #993C1D; }

    .result-status {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: .5rem;
    }
    .result-pass .result-status { color: #085041; }
    .result-fail .result-status { color: #712B13; }

    .result-score {
        font-size: 4rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: .25rem;
    }
    .result-pass .result-score { color: #0F6E56; }
    .result-fail .result-score { color: #993C1D; }
    .result-score-unit  { font-size: 2rem; }
    .result-score-detail {
        font-size: .875rem;
        margin-bottom: 1rem;
    }
    .result-pass .result-score-detail { color: #0F6E56; }
    .result-fail .result-score-detail { color: #993C1D; }

    .result-points {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .4rem 1rem;
        background: #fff;
        border-radius: 99px;
        font-size: .875rem;
        font-weight: 600;
        color: #854F0B;
        border: 1px solid #FAC775;
    }

    /* Review heading */
    .review-heading {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin: 0 0 1rem;
    }

    /* Review card */
    .review-card {
        background: var(--color-background-primary);
        border: 1.5px solid var(--color-border-tertiary);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
    }
    .review-correct { border-left: 4px solid #1D9E75; }
    .review-wrong   { border-left: 4px solid #D85A30; }

    .review-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .75rem;
    }
    .review-number { font-size: .8rem; font-weight: 600; color: var(--color-text-secondary); }
    .review-status-chip {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        font-size: .75rem;
        font-weight: 600;
        padding: .2rem .65rem;
        border-radius: 99px;
    }
    .chip-correct { background: #E1F5EE; color: #0F6E56; }
    .chip-wrong   { background: #FAECE7; color: #993C1D; }

    .review-question {
        font-size: .95rem;
        color: var(--color-text-primary);
        line-height: 1.6;
        margin: 0 0 1rem;
    }

    /* Review options */
    .review-options { display: flex; flex-direction: column; gap: .5rem; margin-bottom: .75rem; }
    .review-option {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .6rem .9rem;
        border: 1.5px solid var(--color-border-tertiary);
        border-radius: 10px;
        background: var(--color-background-secondary);
    }
    .option-correct    { border-color: #1D9E75; background: #E1F5EE; }
    .option-wrong-pick { border-color: #D85A30; background: #FAECE7; }

    .review-option-key {
        flex-shrink: 0;
        width: 26px; height: 26px;
        border-radius: 50%;
        background: var(--color-background-primary);
        border: 1.5px solid var(--color-border-secondary);
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; font-weight: 700;
        color: var(--color-text-secondary);
    }
    .option-correct .review-option-key    { background: #1D9E75; color: #fff; border-color: #1D9E75; }
    .option-wrong-pick .review-option-key { background: #D85A30; color: #fff; border-color: #D85A30; }
    .review-option-text { font-size: .875rem; color: var(--color-text-primary); flex: 1; }
    .review-option-icon { margin-left: auto; font-size: 1rem; }
    .icon-correct { color: #1D9E75; }
    .icon-wrong   { color: #D85A30; }

    /* Penjelasan */
    .review-explanation {
        display: flex;
        align-items: flex-start;
        gap: .5rem;
        padding: .75rem 1rem;
        background: #FAEEDA;
        border-radius: 10px;
        font-size: .85rem;
        color: #633806;
        border: 1px solid #FAC775;
    }
    .review-explanation i { flex-shrink: 0; margin-top: .1rem; }

    /* Tombol aksi */
    .result-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        margin-top: 2rem;
    }
    .btn-retry, .btn-next, .btn-back-roadmap {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .7rem 1.5rem;
        border-radius: 10px;
        font-size: .9rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity .2s, transform .1s;
    }
    .btn-retry:active, .btn-next:active, .btn-back-roadmap:active { transform: scale(.98); }
    .btn-retry       { background: #FAECE7; color: #993C1D; border: 1.5px solid #F5C4B3; }
    .btn-next        { background: #185FA5; color: #fff; border: none; }
    .btn-back-roadmap{ background: var(--color-background-secondary); color: var(--color-text-secondary); border: 1.5px solid var(--color-border-tertiary); }
    .btn-retry:hover        { opacity: .85; }
    .btn-next:hover         { background: #0C447C; }
    .btn-back-roadmap:hover { color: var(--color-text-primary); }
</style>
@endpush