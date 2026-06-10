<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserStage;

class BadgeService
{
    public function checkAndAward(User $user): void
    {
        $stagesDone = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $roadmapsDone = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->distinct('roadmap_id')
            ->count('roadmap_id');

        $streak = $user->streak_days ?? 0;

        $badges = Badge::all();

        foreach ($badges as $badge) {
            if ($user->badges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }

            $earned = match ($badge->condition_type) {
                'stages_done'  => $stagesDone >= $badge->condition_value,
                'roadmap_done' => $roadmapsDone >= $badge->condition_value,
                'streak'       => $streak >= $badge->condition_value,
                'login'        => true,
                default        => false,
            };

            if ($earned) {
                $user->badges()->attach($badge->id, [
                    'earned_at' => now(),
                ]);

                $user->increment('total_xp', $badge->xp_reward);
            }
        }
    }

    public function updateStreak(User $user): void
    {
        $today      = now()->toDateString();
        $lastActive = $user->last_active_date?->toDateString();

        if ($lastActive === $today) return;

        if ($lastActive === now()->subDay()->toDateString()) {
            $user->increment('streak_days');
        } else {
            $user->streak_days = 1;
        }

        $user->last_active_date = $today;
        $user->save();
    }
}