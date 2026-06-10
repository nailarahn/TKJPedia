@extends('layouts.dashboard')

@section('title', 'Hasil Kuis')

@push('styles')
<style>
.result-wrap { max-width: 760px; margin: 0 auto; }
.result-card {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--gray-200);
    padding: 2.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}
.result-score { font-size: 4rem; font-weight: 800; line-height: 1; margin-bottom: 0.25rem; }
.result-label { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; }
.result-sub { font-size: 0.85rem; color: var(--gray-400); }
.result-passed .result-score { color: var(--success); }
.result-failed .result-score { color: var(--danger); }
.review-card { background: var(--white); border-radius: var(--radius); border: 1px solid var(--gray-200); overflow: hidden; margin-bottom: 1.5rem; }
.review-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-weight: 700; font-size: 1rem; }
.question-item { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--gray-100); }
.question-item:last-child { border-bottom: none; }
.question-label { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem; }
.question-label.correct { color: var(--success); }
.question-label.wrong { color: var(--danger); }
.question-text { font-size: 0.9rem; font-weight: 600; color: var(--gray-800); margin-bottom: 0.75rem; }
.answer-row { display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.83rem; margin-bottom: 0.3rem; }
.answer-badge { width: 22px; height: 22px; border-radius: 6px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; }
.badge-correct { background: #dcfce7; color: #16a34a; }
.badge-wrong { background: #fee2e2; color: #dc2626; }
.badge-neutral { background: var(--gray-100); color: var(--gray-500); }
.explanation-box { margin-top: 0.75rem; padding: 0.65rem 0.9rem; background: #fffbeb; border-left: 3px solid #f59e0b; border-radius: 0 8px 8px 0; font-size: 0.8rem; color: #92400e; }
.action-bar { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
</style>
@endpush

@section('content')
<div class="result-wrap">
    <div class="result-card {{ $attempt->is_passed ? 'result-passed' : 'result-failed' }}">
        <div class="result-score">{{ $attempt->score }}%</div>
        <div class="result-label">{{ $attempt->is_passed ? '🎉 Lulus!' : '😔 Belum Lulus' }}</div>
        <div class="result-sub">{{ $attempt->correct_count }} benar dari {{ $attempt->total_questions }} soal &middot; Nilai lulus {{ $quiz->passing_score }}%</div>
    </div>

    <div class="review-card">
        <div class="review-header">Review Jawaban</div>
        @foreach($quiz->questions as $i => $question)
            @php
                $detail = is_array($attempt->answers)
                    ? ($attempt->answers[$question->id] ?? null)
                    : (json_decode($attempt->answers, true)[$question->id] ?? null);
                $userAns     = $detail['user_answer'] ?? null;
                $correctAns  = $detail['correct_answer'] ?? $question->correct_answer;
                $isCorrect   = $detail['is_correct'] ?? false;
                $explanation = $detail['explanation'] ?? $question->explanation ?? null;
                $opts = ['a' => $question->option_a, 'b' => $question->option_b, 'c' => $question->option_c, 'd' => $question->option_d];
            @endphp
            <div class="question-item">
                <div class="question-label {{ $isCorrect ? 'correct' : 'wrong' }}">
                    Soal {{ $i + 1 }} &mdash; {{ $isCorrect ? '✔ Benar' : '✘ Salah' }}
                </div>
                <div class="question-text">{{ $question->question }}</div>
                @foreach($opts as $key => $val)
                    @if($val)
                    <div class="answer-row">
                        @if($key === $correctAns)
                            <span class="answer-badge badge-correct">✓</span>
                        @elseif($key === $userAns && !$isCorrect)
                            <span class="answer-badge badge-wrong">✗</span>
                        @else
                            <span class="answer-badge badge-neutral">{{ strtoupper($key) }}</span>
                        @endif
                        <span style="color:{{ $key===$correctAns?'var(--success)':($key===$userAns&&!$isCorrect?'var(--danger)':'var(--gray-600)') }};font-weight:{{ $key===$correctAns?'600':'400' }}">{{ $val }}</span>
                    </div>
                    @endif
                @endforeach
                @if($explanation)
                    <div class="explanation-box">💡 {{ $explanation }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="action-bar">
        @if($attempt->is_passed && $nextStage)
            <a href="{{ route('roadmap.stage', ['roadmapId' => $roadmapId, 'stageId' => $nextStage->id]) }}" class="btn btn-primary">Lanjut ke Materi Berikutnya →</a>
        @endif
        @if(!$attempt->is_passed)
            <a href="{{ route('roadmap.quiz', ['roadmapId' => $roadmapId, 'stageId' => $stage->id]) }}" class="btn btn-primary">🔄 Coba Lagi</a>
        @endif
        <a href="{{ route('roadmap.stage', ['roadmapId' => $roadmapId, 'stageId' => $stage->id]) }}" class="btn btn-outline">← Kembali ke Materi</a>
    </div>
</div>

{{-- POPUP LANGSUNG DI SINI, tidak pakai @push --}}
@if($attempt->is_passed && ($xpEarned ?? 0) > 0)
<script>
window.addEventListener('load', function() {
    setTimeout(function() {
        var xp = {{ $xpEarned ?? 0 }};
        var badge = @json($newBadge ?? null);
        if (typeof showTKJReward === 'function') {
            showTKJReward({
                type:    badge ? 'Badge Baru Diraih! 🏆' : 'Kuis Selesai! 🎯',
                title:   badge ? badge : 'Kuis Lulus!',
                desc:    badge ? 'Kamu mendapatkan badge baru! Terus tingkatkan prestasimu.' : 'Selamat, kamu berhasil menyelesaikan kuis ini!',
                xp:      xp,
                emoji:   badge ? '🏆' : '🎯',
                badge:   badge || null,
                bgColor: badge ? '#ffe7ef' : '#e0f2fe',
            });
        }
    }, 800);
});
</script>
@endif
@endsection