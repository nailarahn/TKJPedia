<?php

namespace App\Http\Controllers\Api;

use App\Models\UserRoadmap;
use App\Models\UserStage;
use App\Models\LearningLog;
use App\Models\Roadmap;
use Illuminate\Http\Request;

class DashboardApiController extends BaseApiController
{
    /**
     * GET /api/v1/dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Active roadmap (sedang belajar)
        $activeEnrollment = UserRoadmap::with('roadmap')
                                       ->where('user_id', $user->id)
                                       ->where('status', 'active')
                                       ->latest()
                                       ->first();

        // Rekomendasi (roadmap yang belum diikuti)
        $enrolledIds   = UserRoadmap::where('user_id', $user->id)->pluck('roadmap_id');
        $recommended   = Roadmap::active()
                                ->whereNotIn('id', $enrolledIds)
                                ->limit(3)
                                ->get()
                                ->map(fn($r) => [
                                    'id'       => $r->id,
                                    'title'    => $r->title,
                                    'level'    => $r->getLevelLabel(),
                                    'category' => $r->getCategoryLabel(),
                                    'hours'    => $r->estimated_hours,
                                ]);

        // Weekly log
        $weeklyMinutes = LearningLog::where('user_id', $user->id)
                                    ->whereBetween('log_date', [
                                        now()->startOfWeek()->toDateString(),
                                        now()->endOfWeek()->toDateString(),
                                    ])
                                    ->sum('duration_minutes');

        return $this->success([
            'user' => [
                'name'     => $user->name,
                'username' => $user->username,
                'role'     => $user->getRoleLabel(),
            ],
            'stats' => [
                'total_progress'  => $user->getTotalProgressPercent(),
                'materi_selesai'  => $user->completedStages()->count(),
                'jam_minggu_ini'  => round($weeklyMinutes / 60, 1),
                'badges'          => $user->badges()->count(),
                'streak'          => $user->getStreakDays(),
                'target_minggu'   => [
                    'done'  => $user->activeTargets()->whereColumn('current_value', '>=', 'target_value')->count(),
                    'total' => $user->activeTargets()->count(),
                ],
            ],
            'continue_learning' => $activeEnrollment ? [
                'roadmap_id'    => $activeEnrollment->roadmap_id,
                'roadmap_title' => $activeEnrollment->roadmap->title,
                'progress'      => $activeEnrollment->progress,
                'status'        => $activeEnrollment->status,
            ] : null,
            'recommended' => $recommended,
        ]);
    }

    /**
     * GET /api/v1/dashboard/stats
     */
    public function stats(Request $request)
    {
        $user = $request->user();
        return $this->success([
            'total_progress'  => $user->getTotalProgressPercent(),
            'materi_selesai'  => $user->completedStages()->count(),
            'total_jam'       => $user->getTotalLearningHours(),
            'badges'          => $user->badges()->count(),
            'streak'          => $user->getStreakDays(),
            'roadmap_aktif'   => UserRoadmap::where('user_id', $user->id)->where('status', 'active')->count(),
            'roadmap_selesai' => UserRoadmap::where('user_id', $user->id)->where('status', 'completed')->count(),
        ]);
    }

    /**
     * GET /api/v1/dashboard/progress
     */
    public function progress(Request $request)
    {
        $user  = $request->user();
        $weeks = [];

        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek()->toDateString();
            $end   = now()->subWeeks($i)->endOfWeek()->toDateString();

            $weeks[] = [
                'label'   => $i === 0 ? 'Minggu ini' : ($i === 1 ? 'Minggu lalu' : "Minggu -{$i}"),
                'minutes' => LearningLog::where('user_id', $user->id)
                                        ->whereBetween('log_date', [$start, $end])
                                        ->sum('duration_minutes'),
                'materi'  => UserStage::where('user_id', $user->id)
                                      ->whereBetween('completed_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
                                      ->where('is_completed', true)
                                      ->count(),
            ];
        }

        return $this->success($weeks);
    }

    /**
     * GET /api/v1/dashboard/recommended
     */
    public function recommended(Request $request)
    {
        $enrolledIds = UserRoadmap::where('user_id', $request->user()->id)->pluck('roadmap_id');
        $roadmaps    = Roadmap::active()->whereNotIn('id', $enrolledIds)->limit(5)->get()
                              ->map(fn($r) => [
                                  'id'       => $r->id,
                                  'title'    => $r->title,
                                  'level'    => $r->getLevelLabel(),
                                  'category' => $r->getCategoryLabel(),
                                  'hours'    => $r->estimated_hours,
                              ]);

        return $this->success($roadmaps);
    }
}
