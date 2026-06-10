<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Stage;
use App\Models\UserStage;
use App\Models\Badge;

class QuizController extends Controller
{
    // ==========================================
    // Tampilkan halaman kuis
    // ==========================================
    public function show($stageId)
    {
        $stage = Stage::with('quiz.questions')->findOrFail($stageId);

        // Kalau stage ini tidak punya quiz, redirect balik ke stage
        if (!$stage->quiz) {
            return redirect()->route('stages.show', $stageId)
                ->with('info', 'Stage ini belum memiliki kuis.');
        }

        $quiz       = $stage->quiz;
        $user       = Auth::user();
        $lastAttempt = QuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->first();

        return view('quiz.show', compact('stage', 'quiz', 'lastAttempt'));
    }

    // ==========================================
    // Proses submit jawaban kuis
    // ==========================================
    public function submit(Request $request, $stageId)
    {
        $request->validate([
            'answers'  => 'required|array',
            'answers.*' => 'required|in:a,b,c,d',
        ]);

        $stage = Stage::with('quiz.questions')->findOrFail($stageId);
        $quiz  = $stage->quiz;
        $user  = Auth::user();

        if (!$quiz) {
            return redirect()->route('stages.show', $stageId);
        }

        // ---- Hitung skor ----
        $questions     = $quiz->questions;
        $userAnswers   = $request->input('answers'); // ['questionId' => 'a', ...]
        $correctCount  = 0;
        $totalQuestions = $questions->count();
        $answerDetails = [];

        foreach ($questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            $isCorrect  = $userAnswer && $question->isCorrect($userAnswer);

            if ($isCorrect) {
                $correctCount++;
            }

            $answerDetails[$question->id] = [
                'user_answer'    => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct'     => $isCorrect,
                'explanation'    => $question->explanation,
            ];
        }

        $score    = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        $isPassed = $score >= $quiz->passing_score;

        // ---- Simpan attempt ----
        $attempt = QuizAttempt::create([
            'user_id'         => $user->id,
            'quiz_id'         => $quiz->id,
            'stage_id'        => $stage->id,
            'score'           => $score,
            'correct_count'   => $correctCount,
            'total_questions' => $totalQuestions,
            'is_passed'       => $isPassed,
            'answers'         => $answerDetails,
            'completed_at'    => now(),
        ]);

        // ---- Kalau lulus: tandai stage selesai ----
        if ($isPassed) {
            $this->markStageCompleted($user, $stage);
        }

        // ---- Cek dan kasih badge ----
        $newBadge = null;
        if ($isPassed) {
            $newBadge = $this->checkAndAwardBadge($user);
        }

        return redirect()->route('quiz.result', [$stageId, $attempt->id])
            ->with('newBadge', $newBadge);
    }

    // ==========================================
    // Tampilkan halaman hasil kuis
    // ==========================================
    public function result($stageId, $attemptId)
    {
        $stage   = Stage::with('quiz', 'roadmap')->findOrFail($stageId);
        $attempt = QuizAttempt::with('quiz.questions')->findOrFail($attemptId);
        $quiz    = $stage->quiz;

        // Pastikan attempt ini milik user yang login
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil stage berikutnya di roadmap yang sama
        $nextStage = Stage::where('roadmap_id', $stage->roadmap_id)
            ->where('order', $stage->order + 1)
            ->first();

        $newBadge = session('newBadge');

        return view('quiz.result', compact('stage', 'quiz', 'attempt', 'nextStage', 'newBadge'));
    }

    // ==========================================
    // Private: tandai stage selesai
    // ==========================================
    private function markStageCompleted($user, $stage)
    {
        $userStage = UserStage::firstOrCreate(
            ['user_id' => $user->id, 'stage_id' => $stage->id],
            ['roadmap_id' => $stage->roadmap_id]
        );

        if (!$userStage->is_completed) {
            $userStage->update([
                'is_completed' => true,
                'completed_at' => now(),
            ]);

            // Update progress di UserRoadmap
            $this->updateRoadmapProgress($user, $stage->roadmap_id);
        }
    }

    // ==========================================
    // Private: update progress roadmap user
    // ==========================================
    private function updateRoadmapProgress($user, $roadmapId)
    {
        $userRoadmap = $user->userRoadmaps()
            ->where('roadmap_id', $roadmapId)
            ->first();

        if (!$userRoadmap) return;

        $totalStages = Stage::where('roadmap_id', $roadmapId)->count();
        $doneStages  = UserStage::where('user_id', $user->id)
            ->whereHas('stage', fn($q) => $q->where('roadmap_id', $roadmapId))
            ->where('is_completed', true)
            ->count();

        $progress = $totalStages > 0 ? round(($doneStages / $totalStages) * 100) : 0;

        $userRoadmap->update([
            'progress' => $progress,
            'status'   => $progress >= 100 ? 'completed' : 'active',
        ]);
    }

    // ==========================================
    // Private: cek dan beri badge
    // ==========================================
    private function checkAndAwardBadge($user)
    {
        $stagesDone  = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $earnedBadgeIds = $user->badges()->pluck('badges.id')->toArray();

        // Ambil semua badge bertipe stages_done yang belum diraih user
        $eligibleBadge = Badge::where('condition_type', 'stages_done')
            ->where('condition_value', '<=', $stagesDone)
            ->whereNotIn('id', $earnedBadgeIds)
            ->orderBy('condition_value', 'desc')
            ->first();

        if ($eligibleBadge) {
            $user->badges()->attach($eligibleBadge->id, ['earned_at' => now()]);
            return $eligibleBadge;
        }

        return null;
    }
}