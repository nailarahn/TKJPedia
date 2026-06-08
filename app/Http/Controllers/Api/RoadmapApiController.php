<?php

namespace App\Http\Controllers\Api;

use App\Models\Roadmap;
use App\Models\UserRoadmap;
use App\Models\UserStage;
use Illuminate\Http\Request;

class RoadmapApiController extends BaseApiController
{

    public function index(Request $request)
    {
        $roadmaps = Roadmap::active()
            ->orderBy('order')
            ->get()
            ->map(fn($r) => $this->formatRoadmap($r, $request->user()->id));

        return $this->success($roadmaps);
    }

 
    public function show(Request $request, $id)
    {
        $roadmap = Roadmap::with('stages')->find($id);
        if (!$roadmap) return $this->notFound('Roadmap tidak ditemukan.');

        $userId = $request->user()->id;
        $enrollment = UserRoadmap::where('user_id', $userId)
                                 ->where('roadmap_id', $id)
                                 ->first();

        $completedStageIds = UserStage::where('user_id', $userId)
                                      ->where('roadmap_id', $id)
                                      ->where('is_completed', true)
                                      ->pluck('stage_id')
                                      ->toArray();

        $stages = $roadmap->stages->map(fn($s) => [
            'id'                 => $s->id,
            'title'              => $s->title,
            'description'        => $s->description,
            'order'              => $s->order,
            'type'               => $s->type,
            'type_label'         => $s->getTypeLabel(),
            'estimated_minutes'  => $s->estimated_minutes,
            'content_url'        => $s->content_url,
            'is_completed'       => in_array($s->id, $completedStageIds),
        ]);

        return $this->success([
            'roadmap'    => $this->formatRoadmap($roadmap, $userId),
            'enrollment' => $enrollment ? [
                'status'       => $enrollment->status,
                'progress'     => $enrollment->progress,
                'started_at'   => $enrollment->started_at?->toDateString(),
                'completed_at' => $enrollment->completed_at?->toDateString(),
            ] : null,
            'stages'     => $stages,
        ]);
    }


    public function enroll(Request $request, $id)
    {
        $roadmap = Roadmap::find($id);
        if (!$roadmap) return $this->notFound('Roadmap tidak ditemukan.');

        $userId = $request->user()->id;
        $existing = UserRoadmap::where('user_id', $userId)->where('roadmap_id', $id)->first();

        if ($existing) {
            return $this->error('Kamu sudah terdaftar di roadmap ini.', 409);
        }

        UserRoadmap::create([
            'user_id'    => $userId,
            'roadmap_id' => $id,
            'progress'   => 0,
            'status'     => 'active',
            'started_at' => now(),
        ]);

        return $this->success(null, 'Berhasil mendaftar ke roadmap!', 201);
    }

    /**
     * POST /api/v1/roadmap/{roadmapId}/stages/{stageId}/complete
     * Tandai stage selesai + update progress roadmap
     */
    public function completeStage(Request $request, $roadmapId, $stageId)
    {
        $userId    = $request->user()->id;
        $enrollment = UserRoadmap::where('user_id', $userId)->where('roadmap_id', $roadmapId)->first();

        if (!$enrollment) return $this->error('Kamu belum terdaftar di roadmap ini.', 403);

        $userStage = UserStage::updateOrCreate(
            ['user_id' => $userId, 'stage_id' => $stageId],
            [
                'roadmap_id'        => $roadmapId,
                'is_completed'      => true,
                'completed_at'      => now(),
                'time_spent_minutes'=> $request->input('time_spent_minutes', 0),
            ]
        );

        $totalStages     = Roadmap::find($roadmapId)?->total_stages ?? 1;
        $completedStages = UserStage::where('user_id', $userId)
                                    ->where('roadmap_id', $roadmapId)
                                    ->where('is_completed', true)
                                    ->count();

        $progress = $totalStages > 0 ? min(100, (int) round(($completedStages / $totalStages) * 100)) : 0;
        $enrollment->update([
            'progress'     => $progress,
            'status'       => $progress >= 100 ? 'completed' : 'active',
            'completed_at' => $progress >= 100 ? now() : null,
        ]);

        \App\Models\LearningLog::create([
            'user_id'          => $userId,
            'stage_id'         => $stageId,
            'roadmap_id'       => $roadmapId,
            'duration_minutes' => $request->input('time_spent_minutes', 30),
            'log_date'         => now()->toDateString(),
            'activity'         => 'study',
        ]);

        return $this->success([
            'stage_completed'  => true,
            'roadmap_progress' => $progress,
            'roadmap_status'   => $enrollment->status,
        ], 'Tahap berhasil diselesaikan! 🎉');
    }


    public function myRoadmaps(Request $request)
    {
        $userId   = $request->user()->id;
        $enrolled = UserRoadmap::with('roadmap')
                               ->where('user_id', $userId)
                               ->get()
                               ->map(fn($ur) => [
                                   'roadmap'      => $this->formatRoadmap($ur->roadmap, $userId),
                                   'progress'     => $ur->progress,
                                   'status'       => $ur->status,
                                   'started_at'   => $ur->started_at?->toDateString(),
                                   'completed_at' => $ur->completed_at?->toDateString(),
                               ]);

        return $this->success($enrolled);
    }

    private function formatRoadmap(Roadmap $r, int $userId): array
    {
        $enrollment = UserRoadmap::where('user_id', $userId)->where('roadmap_id', $r->id)->first();
        return [
            'id'              => $r->id,
            'title'           => $r->title,
            'description'     => $r->description,
            'slug'            => $r->slug,
            'level'           => $r->level,
            'level_label'     => $r->getLevelLabel(),
            'category'        => $r->category,
            'category_label'  => $r->getCategoryLabel(),
            'thumbnail'       => $r->thumbnail,
            'total_stages'    => $r->total_stages,
            'estimated_hours' => $r->estimated_hours,
            'is_enrolled'     => $enrollment !== null,
            'user_progress'   => $enrollment?->progress ?? 0,
            'user_status'     => $enrollment?->status ?? 'not_enrolled',
        ];
    }
}
