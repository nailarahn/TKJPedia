<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Roadmap;
use App\Models\UserRoadmap;
use App\Models\UserStage;
use App\Models\LearningLog;
use App\Services\BadgeService;


class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $activeEnrollment = UserRoadmap::with('roadmap')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        $recommendations = collect();

        $completedStageIds = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('stage_id')
            ->toArray();

        if ($activeEnrollment) {
            $roadmap = Roadmap::with(['stages' => fn($q) => $q->where('is_active', true)->orderBy('order')])
                ->find($activeEnrollment->roadmap_id);

            if ($roadmap) {
                $nextStages = $roadmap->stages
                    ->whereNotIn('id', $completedStageIds)
                    ->take(3);

                $typeIcons = [
                    'video'    => ['icon' => '🎬', 'color' => '#372466'],
                    'article'  => ['icon' => '📄', 'color' => '#0ea5e9'],
                    'quiz'     => ['icon' => '🧠', 'color' => '#f59e0b'],
                    'practice' => ['icon' => '⚙️', 'color' => '#22c55e'],
                ];

                $recommendations = $nextStages->map(function ($stage) use ($roadmap, $typeIcons) {
                    $meta = $typeIcons[$stage->type] ?? ['icon' => '📚', 'color' => '#372466'];
                    return [
                        'title'    => $stage->title,
                        'type'     => $stage->getTypeLabel(),
                        'duration' => $stage->estimated_minutes . ' menit',
                        'icon'     => $meta['icon'],
                        'color'    => $meta['color'],
                        'route'    => route('roadmap.stage', [
                            'roadmapId' => $roadmap->id,
                            'stageId'   => $stage->id,
                        ]),
                    ];
                });
            }
        }

        if ($recommendations->isEmpty()) {
            $roadmapsAvailable = Roadmap::with(['stages' => fn($q) => $q->where('is_active', true)->orderBy('order')])
                ->where('is_active', true)
                ->orderBy('order')
                ->limit(3)
                ->get();

            $recommendations = $roadmapsAvailable->map(function ($rm) {
                $firstStage = $rm->stages->first();
                return [
                    'title'    => $firstStage ? $rm->title . ' — ' . $firstStage->title : $rm->title,
                    'type'     => $firstStage ? $firstStage->getTypeLabel() : 'Roadmap',
                    'duration' => $firstStage ? $firstStage->estimated_minutes . ' menit' : $rm->estimated_hours . ' jam',
                    'icon'     => '🚀',
                    'color'    => '#372466',
                    'route'    => route('roadmap'),
                ];
            });
        }

        $materiSelesai = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $totalMateri = $activeEnrollment
            ? ($activeEnrollment->roadmap->total_stages ?? 0)
            : 0;

        $targetSelesai = $user->activeTargets()
            ->whereColumn('current_value', '>=', 'target_value')
            ->count();

        $totalTarget = $user->activeTargets()->count();

        $weeklyMinutes = LearningLog::where('user_id', $user->id)
            ->whereBetween('log_date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])
            ->sum('duration_minutes');

        $progressData = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek()->toDateString();
            $end   = now()->subWeeks($i)->endOfWeek()->toDateString();

            $mins = LearningLog::where('user_id', $user->id)
                ->whereBetween('log_date', [$start, $end])
                ->sum('duration_minutes');

            $progressData[] = [
                'minggu'   => 'Minggu ' . (4 - $i),
                'progress' => $mins > 0 ? min(100, (int) ($mins / 6)) : 0,
            ];
        }

        return view('dashboard.index', compact(
            'user',
            'progressData',
            'recommendations',
            'activeEnrollment',
            'weeklyMinutes',
            'materiSelesai',
            'totalMateri',
            'targetSelesai',
            'totalTarget',
        ));
    }

    public function roadmap()
    {
        $user = Auth::user();

        $completedStageIds = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('stage_id')
            ->toArray();

        $enrolledRoadmapIds = UserRoadmap::where('user_id', $user->id)
            ->pluck('roadmap_id')
            ->toArray();

        $roadmaps = Roadmap::with([
                'stages' => function ($q) {
                    $q->where('is_active', true)->orderBy('order');
                }
            ])
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($r) use ($enrolledRoadmapIds, $user) {
                $enrollment = UserRoadmap::where('user_id', $user->id)
                    ->where('roadmap_id', $r->id)
                    ->first();

                $r->is_enrolled   = in_array($r->id, $enrolledRoadmapIds);
                $r->user_progress = $enrollment?->progress ?? 0;

                return $r;
            });

        return view('dashboard.roadmap', compact('roadmaps', 'completedStageIds'));
    }

    public function stage($roadmapId, $stageId)
    {
        $user = Auth::user();

        $roadmap = Roadmap::with([
                'stages' => function ($q) {
                    $q->where('is_active', true)->orderBy('order');
                }
            ])
            ->findOrFail($roadmapId);

        $stage = $roadmap->stages->firstWhere('id', $stageId);

        if (!$stage) abort(404);

        $enrollment = UserRoadmap::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        if (!$enrollment) {
            return redirect()->route('roadmap')->with('error', 'Kamu belum terdaftar di roadmap ini.');
        }

        $completedStageIds = UserStage::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->where('is_completed', true)
            ->pluck('stage_id')
            ->toArray();

        $isCompleted     = in_array($stageId, $completedStageIds);
        $doneCount       = count($completedStageIds);
        $progressPercent = $roadmap->total_stages > 0
            ? min(100, (int) round(($doneCount / $roadmap->total_stages) * 100))
            : 0;

        $allStages         = $roadmap->stages;
        $currentGroupIndex = 0;
        $groupedStages     = $allStages->groupBy(function ($s) {
            return $s->group_label ?: $s->title;
        });

        foreach ($groupedStages as $idx => $grp) {
            if ($grp->contains('id', (int) $stageId)) {
                $currentGroupIndex = $idx;
                break;
            }
        }

        return view('dashboard.stage', compact(
            'roadmap',
            'stage',
            'allStages',
            'completedStageIds',
            'isCompleted',
            'doneCount',
            'progressPercent',
            'currentGroupIndex'
        ));
    }

    public function enroll($roadmapId)
    {
        $user    = Auth::user();
        $roadmap = Roadmap::findOrFail($roadmapId);

        $existing = UserRoadmap::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        if (!$existing) {
            UserRoadmap::create([
                'user_id'    => $user->id,
                'roadmap_id' => $roadmapId,
                'progress'   => 0,
                'status'     => 'active',
                'started_at' => now(),
            ]);
        }

        $firstStage = $roadmap->stages()->orderBy('order')->first();

        if ($firstStage) {
            return redirect()->route('roadmap.stage', [
                'roadmapId' => $roadmapId,
                'stageId'   => $firstStage->id,
            ])->with('success', 'Berhasil mendaftar! Selamat belajar 🎉');
        }

        return redirect()->route('roadmap')->with('success', 'Berhasil mendaftar ke roadmap!');
    }

    public function completeStage(Request $request, $roadmapId, $stageId)
    {
        $user = Auth::user();

        $enrollment = UserRoadmap::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->firstOrFail();

        // Tandai stage selesai
        UserStage::updateOrCreate(
            ['user_id' => $user->id, 'stage_id' => $stageId],
            [
                'roadmap_id'         => $roadmapId,
                'is_completed'       => true,
                'completed_at'       => now(),
                'time_spent_minutes' => $request->input('time_spent_minutes', 30),
            ]
        );

        // Update progress roadmap
        $totalStages = Roadmap::find($roadmapId)?->total_stages ?? 1;

        $completedStages = UserStage::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->where('is_completed', true)
            ->count();

        $progress = $totalStages > 0
            ? min(100, (int) round(($completedStages / $totalStages) * 100))
            : 0;

        $enrollment->update([
            'progress'     => $progress,
            'status'       => $progress >= 100 ? 'completed' : 'active',
            'completed_at' => $progress >= 100 ? now() : null,
        ]);

        // Learning log
        LearningLog::create([
            'user_id'          => $user->id,
            'stage_id'         => $stageId,
            'roadmap_id'       => $roadmapId,
            'duration_minutes' => $request->input('time_spent_minutes', 30),
            'log_date'         => now()->toDateString(),
            'activity'         => 'study',
        ]);

        // ── BADGE & STREAK ─────────────────────────────────────────
        $badgeService = new BadgeService();
        $badgeService->updateStreak($user);
        $badgeService->checkAndAward($user);

        // Auto update target
        $activeTarget = $user->targets()
            ->where('roadmap_id', $roadmapId)
            ->where('status', 'active')
            ->first();

        if ($activeTarget) {
            $activeTarget->increment('current_value');
            $activeTarget->checkAndUpdateStatus();
        }

        // Cari next stage
        $roadmap  = Roadmap::with(['stages' => fn($q) => $q->orderBy('order')])->find($roadmapId);
        $stageIds = $roadmap->stages->pluck('id')->toArray();

        $currentIdx = array_search((int) $stageId, $stageIds);
        $nextStage  = $stageIds[$currentIdx + 1] ?? null;

        if ($nextStage) {
            return redirect()->route('roadmap.stage', [
                'roadmapId' => $roadmapId,
                'stageId'   => $nextStage,
            ])->with('success', 'Tahap selesai! Lanjut ke materi berikutnya 🎉');
        }

        return redirect()->route('roadmap')->with('success', 'Selamat! Kamu telah menyelesaikan semua materi di roadmap ini 🏆');
    }

    // TARGET
    public function target()
    {
        $user    = Auth::user();
        $targets = $user->targets()->with('roadmap')->orderByDesc('created_at')->get();
        return view('dashboard.target', compact('user', 'targets'));
    }

    public function targetCreate()
    {
        $roadmaps = Roadmap::where('is_active', true)->orderBy('title')->get();
        return view('dashboard.targetform', compact('roadmaps'));
    }

    public function targetStore(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'target_value' => 'required|integer|min:1',
            'start_date'   => 'nullable|date',
            'deadline'     => 'nullable|date',
            'roadmap_id'   => 'nullable|exists:roadmaps,id',
        ]);

        Auth::user()->targets()->create([
            'name'          => $request->name,
            'description'   => $request->description,
            'roadmap_id'    => $request->roadmap_id,
            'target_value'  => $request->target_value,
            'current_value' => 0,
            'start_date'    => $request->start_date,
            'deadline'      => $request->deadline,
            'status'        => 'active',
        ]);

        return redirect()->route('target')->with('success', 'Target berhasil ditambahkan! 🎯');
    }

    public function targetEdit($id)
    {
        $target   = Auth::user()->targets()->findOrFail($id);
        $roadmaps = Roadmap::where('is_active', true)->orderBy('title')->get();
        return view('dashboard.targetform', compact('target', 'roadmaps'));
    }

    public function targetUpdate(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'target_value' => 'required|integer|min:1',
            'start_date'   => 'nullable|date',
            'deadline'     => 'nullable|date',
            'roadmap_id'   => 'nullable|exists:roadmaps,id',
        ]);

        $target = Auth::user()->targets()->findOrFail($id);
        $target->update([
            'name'         => $request->name,
            'description'  => $request->description,
            'roadmap_id'   => $request->roadmap_id,
            'target_value' => $request->target_value,
            'start_date'   => $request->start_date,
            'deadline'     => $request->deadline,
        ]);

        return redirect()->route('target')->with('success', 'Target berhasil diperbarui! ✅');
    }

    public function targetDestroy($id)
    {
        Auth::user()->targets()->findOrFail($id)->delete();
        return redirect()->route('target')->with('success', 'Target berhasil dihapus! 🗑️');
    }

    public function progress()
    {
        $user = Auth::user();

        $totalHariBelajar = LearningLog::where('user_id', $user->id)
            ->selectRaw('COUNT(DISTINCT DATE(log_date)) as total')
            ->value('total') ?? 0;

        $materiSelesai = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $totalJam = round(LearningLog::where('user_id', $user->id)->sum('duration_minutes') / 60);

        $badgeEarned = \DB::table('user_badges')->where('user_id', $user->id)->count();
        $totalBadge  = \DB::table('badges')->count();

        $chartData = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth()->toDateString();
            $end   = now()->subMonths($i)->endOfMonth()->toDateString();

            $mins = LearningLog::where('user_id', $user->id)
                ->whereBetween('log_date', [$start, $end])
                ->sum('duration_minutes');

            $chartData[] = [
                'label'  => now()->subMonths($i)->translatedFormat('M Y'),
                'materi' => UserStage::where('user_id', $user->id)
                    ->where('is_completed', true)
                    ->whereBetween('completed_at', [$start, $end])
                    ->count(),
                'jam' => round($mins / 60),
            ];
        }

        $allLogDates = LearningLog::where('user_id', $user->id)
            ->selectRaw('DISTINCT DATE(log_date) as d')
            ->orderByDesc('d')
            ->pluck('d')
            ->toArray();

        $logDateSet = array_flip($allLogDates);
        $streakMax  = 0;
        $cur        = 0;
        $prevDate   = null;
        foreach (array_reverse($allLogDates) as $d) {
            if ($prevDate === null || \Carbon\Carbon::parse($d)->diffInDays(\Carbon\Carbon::parse($prevDate)) === 1) {
                $cur++;
            } else {
                $cur = 1;
            }
            $streakMax = max($streakMax, $cur);
            $prevDate  = $d;
        }

        $streakNow = 0;
        $check     = now()->toDateString();
        while (isset($logDateSet[$check])) {
            $streakNow++;
            $check = \Carbon\Carbon::parse($check)->subDay()->toDateString();
        }

        $completedStages = UserStage::with(['stage', 'roadmap'])
            ->where('user_id', $user->id)
            ->where('is_completed', true)
            ->orderBy('completed_at')
            ->get();

        $heatmapData = LearningLog::where('user_id', $user->id)
            ->where('log_date', '>=', now()->subDays(89)->toDateString())
            ->selectRaw('DATE(log_date) as d, SUM(duration_minutes) as total_mins')
            ->groupBy('d')
            ->pluck('total_mins', 'd')
            ->toArray();

        $jamMingguIni = [];
        for ($i = 0; $i < 7; $i++) {
            $d    = now()->startOfWeek()->addDays($i)->toDateString();
            $mins = LearningLog::where('user_id', $user->id)
                ->where('log_date', $d)
                ->sum('duration_minutes');
            $jamMingguIni[] = [
                'day' => now()->startOfWeek()->addDays($i)->translatedFormat('D'),
                'jam' => round($mins / 60, 1),
            ];
        }

        $jamMingguIniTotal = round(array_sum(array_column($jamMingguIni, 'jam')), 1);
        $jamRataHarian     = $totalHariBelajar > 0 ? round($totalJam / $totalHariBelajar, 1) : 0;

        $unlockedIds = \DB::table('user_badges')->where('user_id', $user->id)->pluck('badge_id')->toArray();
        $badges = \App\Models\Badge::all()->map(fn($b) => [
            'id'       => $b->id,
            'name'     => $b->name,
            'desc'     => $b->description,
            'icon'     => $b->icon ?? '🏅',
            'xp'       => $b->xp_reward ?? 0,
            'unlocked' => in_array($b->id, $unlockedIds),
        ])->toArray();

        return view('dashboard.progress', compact(
            'totalHariBelajar',
            'materiSelesai',
            'totalJam',
            'badgeEarned',
            'totalBadge',
            'chartData',
            'streakNow',
            'streakMax',
            'completedStages',
            'heatmapData',
            'jamMingguIni',
            'jamMingguIniTotal',
            'jamRataHarian',
            'badges'
        ));
    }
}