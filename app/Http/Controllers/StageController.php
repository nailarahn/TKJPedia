<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\StageCompletion;
use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function complete(Request $request, Stage $stage)
    {
        $user = Auth::user();

        // Simpan stage completion
        StageCompletion::firstOrCreate(
            [
                'user_id'  => $user->id,
                'stage_id' => $stage->id,
            ],
            [
                'duration_minutes' => $request->duration_minutes ?? 0,
                'completed_at'     => now(),
            ]
        );

        // Update streak & cek badge
        $badgeService = new BadgeService();
        $badgeService->updateStreak($user);
        $badgeService->checkAndAward($user);

        return response()->json([
            'message' => 'Stage completed!',
            'xp'      => $user->fresh()->xp,
        ]);
    }
}