<?php
// database/seeders/BadgeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name'            => 'First Step',
                'description'     => 'Selesaikan materi pertama',
                'icon'            => '⭐',
                'color'           => '#7C3AED',
                'condition_type'  => 'stages_done',
                'condition_value' => 1,
                'xp_reward'       => 100,
            ],
            [
                'name'            => 'Consistent',
                'description'     => 'Belajar 7 hari berturut-turut',
                'icon'            => '🔥',
                'color'           => '#EC4899',
                'condition_type'  => 'streak',
                'condition_value' => 7,
                'xp_reward'       => 250,
            ],
            [
                'name'            => 'Bronze Medal',
                'description'     => 'Selesaikan 5 modul',
                'icon'            => '🥉',
                'color'           => '#B45309',
                'condition_type'  => 'stages_done',
                'condition_value' => 5,
                'xp_reward'       => 500,
            ],
            [
                'name'            => 'Silver Medal',
                'description'     => 'Selesaikan 10 modul',
                'icon'            => '🥈',
                'color'           => '#6B7280',
                'condition_type'  => 'stages_done',
                'condition_value' => 10,
                'xp_reward'       => 1000,
            ],
            [
                'name'            => 'Gold Medal',
                'description'     => 'Selesaikan 20 modul',
                'icon'            => '🥇',
                'color'           => '#D97706',
                'condition_type'  => 'stages_done',
                'condition_value' => 20,
                'xp_reward'       => 2000,
            ],
            [
                'name'            => 'Winner',
                'description'     => 'Selesaikan semua roadmap',
                'icon'            => '🏆',
                'color'           => '#7C3AED',
                'condition_type'  => 'roadmap_done',
                'condition_value' => 20,
                'xp_reward'       => 5000,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(['name' => $badge['name']], $badge);
        }
    }
}