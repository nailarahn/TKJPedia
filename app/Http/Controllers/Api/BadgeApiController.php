<?php

namespace App\Http\Controllers\Api;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeApiController extends BaseApiController
{
    /**
     * GET /api/v1/badges
     * Semua badge yang tersedia
     */
    public function index(Request $request)
    {
        $userId    = $request->user()->id;
        $earnedIds = $request->user()->badges()->pluck('badges.id')->toArray();

        $badges = Badge::all()->map(fn($b) => [
            'id'              => $b->id,
            'name'            => $b->name,
            'description'     => $b->description,
            'icon'            => $b->icon,
            'color'           => $b->color,
            'condition_type'  => $b->condition_type,
            'condition_value' => $b->condition_value,
            'is_earned'       => in_array($b->id, $earnedIds),
        ]);

        return $this->success($badges);
    }

    /**
     * GET /api/v1/badges/my
     * Badge yang sudah dimiliki user
     */
    public function myBadges(Request $request)
    {
        $badges = $request->user()->badges()->get()->map(fn($b) => [
            'id'        => $b->id,
            'name'      => $b->name,
            'icon'      => $b->icon,
            'color'     => $b->color,
            'earned_at' => $b->pivot->earned_at,
        ]);

        return $this->success($badges);
    }
}
