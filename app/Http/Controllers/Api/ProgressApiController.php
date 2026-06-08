<?php

namespace App\Http\Controllers\Api;

use App\Models\LearningLog;
use App\Models\UserStage;
use App\Models\UserRoadmap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressApiController extends BaseApiController
{
    /**
     * GET /api/v1/progress
     * Semua data progress user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return $this->success([
            'summary' => $this->getSummary($user),
            'weekly'  => $this->getWeekly($user),
            'roadmaps'=> $this->getRoadmapProgress($user),
        ]);
    }

    /**
     * GET /api/v1/progress/summary
     */
    public function summary(Request $request)
    {
        return $this->success($this->getSummary($request->user()));
    }

    /**
     * GET /api/v1/progress/weekly
     */
    public function weekly(Request $request)
    {
        return $this->success($this->getWeekly($request->user()));
    }

    /**
     * GET /api/v1/progress/roadmaps
     */
    public function roadmaps(Request $request)
    {
        return $this->success($this->getRoadmapProgress($request->user()));
    }

    /**
     * POST /api/v1/progress/log
     * Catat sesi belajar manual
     * Body: { stage_id?, roadmap_id?, duration_minutes, activity? }
     */
    public function log(Request $request)
    {
        $validated = $request->validate([
            'stage_id'         => 'nullable|exists:stages,id',
            'roadmap_id'       => 'nullable|exists:roadmaps,id',
            'duration_minutes' => 'required|integer|min:1|max:600',
            'activity'         => 'in:study,review,quiz',
        ]);

        $log = LearningLog::create([
            'user_id'          => $request->user()->id,
            'stage_id'         => $validated['stage_id'] ?? null,
            'roadmap_id'       => $validated['roadmap_id'] ?? null,
            'duration_minutes' => $validated['duration_minutes'],
            'log_date'         => now()->toDateString(),
            'activity'         => $validated['activity'] ?? 'study',
        ]);

        return $this->success([
            'log_id'           => $log->id,
            'duration_minutes' => $log->duration_minutes,
            'log_date'         => $log->log_date->toDateString(),
        ], 'Sesi belajar berhasil dicatat!', 201);
    }

    // ── PRIVATE ──────────────────────────────────────
    private function getSummary($user): array
    {
        return [
            'total_materi'    => UserStage::where('user_id', $user->id)->where('is_completed', true)->count(),
            'total_roadmap'   => UserRoadmap::where('user_id', $user->id)->count(),
            'roadmap_selesai' => UserRoadmap::where('user_id', $user->id)->where('status', 'completed')->count(),
            'total_jam'       => round(LearningLog::where('user_id', $user->id)->sum('duration_minutes') / 60, 1),
            'badges'          => $user->badges()->count(),
            'streak_hari'     => $user->getStreakDays(),
            'total_progress'  => $user->getTotalProgressPercent(),
        ];
    }

    private function getWeekly($user): array
    {
        $weeks = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end   = now()->subWeeks($i)->endOfWeek();

            $minutes = LearningLog::where('user_id', $user->id)
                                  ->whereBetween('log_date', [$start->toDateString(), $end->toDateString()])
                                  ->sum('duration_minutes');

            $materi = UserStage::where('user_id', $user->id)
                               ->whereBetween('completed_at', [$start, $end])
                               ->where('is_completed', true)
                               ->count();

            $weeks[] = [
                'week'         => 'Minggu ' . ($i === 0 ? 'ini' : ($i === 1 ? 'lalu' : ($i . ' lalu'))),
                'start_date'   => $start->toDateString(),
                'end_date'     => $end->toDateString(),
                'jam_belajar'  => round($minutes / 60, 1),
                'materi_done'  => $materi,
            ];
        }
        return $weeks;
    }

    private function getRoadmapProgress($user): array
    {
        return UserRoadmap::with('roadmap')
                          ->where('user_id', $user->id)
                          ->get()
                          ->map(fn($ur) => [
                              'roadmap_id'    => $ur->roadmap_id,
                              'roadmap_title' => $ur->roadmap->title,
                              'progress'      => $ur->progress,
                              'status'        => $ur->status,
                              'started_at'    => $ur->started_at?->toDateString(),
                          ])
                          ->toArray();
    }
}
