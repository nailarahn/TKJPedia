<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Stage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // ── 1. STATISTIK UTAMA ─────────────────────────────────────
        $totalDays      = $this->getTotalActiveDays($user);
        $totalMaterials = $user->completedStages()->count();
        $totalHours     = $user->getTotalLearningHours();
        $badgesEarned   = $user->badges()->count();

        $progressData = [
            'total_days'      => $totalDays,
            'total_materials' => $totalMaterials,
            'total_hours'     => $totalHours,
            'badges_earned'   => $badgesEarned,
        ];

        // ── 2. STREAK ──────────────────────────────────────────────
        $streakDays = $user->getStreakDays();

        // ── 3. PROGRESS PER ROADMAP ────────────────────────────────
        $roadmapProgress = $user->enrolledRoadmaps()
            ->withPivot('progress', 'status', 'started_at', 'completed_at')
            ->get()
            ->map(function ($roadmap) {
                return [
                    'id'           => $roadmap->id,
                    'title'        => $roadmap->title ?? $roadmap->name,
                    'progress'     => $roadmap->pivot->progress ?? 0,
                    'status'       => $roadmap->pivot->status ?? 'in_progress',
                    'started_at'   => $roadmap->pivot->started_at,
                    'completed_at' => $roadmap->pivot->completed_at,
                ];
            });

        // ── 4. BADGE LIST ──────────────────────────────────────────
        $earnedBadgeIds = $user->badges()->pluck('badges.id')->toArray();
        $stagesDone     = $user->completedStages()->count();

        $allBadges = Badge::all()->map(function ($badge) use ($earnedBadgeIds, $stagesDone) {
            $earnedPivot = in_array($badge->id, $earnedBadgeIds)
                ? $user->badges()->where('badges.id', $badge->id)->first()?->pivot
                : null;

        return [
            'id'              => $badge->id,
            'name'            => $badge->name,
            'description'     => $badge->description,
            'icon'            => $badge->icon,
            'color'           => $badge->color,
            'xp_reward'       => $badge->xp_reward,
            'condition_type'  => $badge->condition_type,
            'condition_value' => $badge->condition_value,
            'earned'          => in_array($badge->id, $earnedBadgeIds),
            'earned_at'       => $earnedPivot?->earned_at,
            // Progress bar untuk stages_done
            'progress'        => $badge->condition_type === 'stages_done'
                    ? min($stagesDone, $badge->condition_value)
                    : null,
            ];
        });

        // ── 5. LEARNING TREND (7 HARI TERAKHIR) ───────────────────
        $learningTrend = $this->getLearningTrend($user, 7);

        // ── 6. AKTIVITAS TERBARU ───────────────────────────────────
        $recentActivities = $user->learningLogs()
            ->with('stage')
            ->latest('log_date')
            ->take(10)
            ->get()
            ->map(function ($log) {
                return [
                    'date'             => Carbon::parse($log->log_date)->format('d M Y'),
                    'duration_minutes' => $log->duration_minutes,
                    'stage_name'       => optional($log->stage)->title ?? optional($log->stage)->name ?? '-',
                    'notes'            => $log->notes ?? '',
                ];
            });

        // ── 7. TARGET AKTIF ───────────────────────────────────────
        $activeTargets = $user->activeTargets()
            ->get()
            ->map(function ($target) {
                return [
                    'id'          => $target->id,
                    'title'       => $target->title,
                    'description' => $target->description ?? '',
                    'deadline'    => $target->deadline
                        ? Carbon::parse($target->deadline)->format('d M Y')
                        : null,
                    'progress'    => $target->progress ?? 0,
                ];
            });

        // ── 8. OVERALL PROGRESS ────────────────────────────────────
        $overallProgress = $user->getTotalProgressPercent();

        return view('pages.progress.index', compact(
            'progressData',
            'streakDays',
            'roadmapProgress',
            'allBadges',
            'learningTrend',
            'recentActivities',
            'activeTargets',
            'overallProgress'
        ));
    }

    // ── PRIVATE HELPERS ────────────────────────────────────────────

    /**
     * Hitung total hari user pernah belajar (berdasarkan learning logs).
     */
    private function getTotalActiveDays(User $user): int
    {
        return $user->learningLogs()
            ->selectRaw('DATE(log_date) as date')
            ->distinct()
            ->count();
    }

    /**
     * Ambil tren belajar N hari terakhir.
     * Return: array of ['day' => 'Sen', 'date' => '2024-01-15', 'hours' => 1.5]
     */
    private function getLearningTrend(User $user, int $days = 7): array
    {
        $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $trend    = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();

            $minutes = $user->learningLogs()
                ->whereDate('log_date', $date)
                ->sum('duration_minutes');

            $trend[] = [
                'day'   => $dayNames[now()->subDays($i)->dayOfWeek],
                'date'  => $date,
                'hours' => round($minutes / 60, 1),
            ];
        }

        return $trend;
    }
}