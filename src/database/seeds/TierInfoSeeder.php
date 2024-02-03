<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TierInfoSeeder extends Seeder
{
    private array $tiers = [
        [
            'tier_id' => 0,
            'market_group_id' => 1333,
            'quantity_produced' => 0
        ],
        [
            'tier_id' => 1,
            'market_group_id' => 1334,
            'quantity_produced' => 20
        ],
        [
            'tier_id' => 2,
            'market_group_id' => 1335,
            'quantity_produced' => 5
        ],
        [
            'tier_id' => 3,
            'market_group_id' => 1336,
            'quantity_produced' => 6
        ],
        [
            'tier_id' => 4,
            'market_group_id' => 1337,
            'quantity_produced' => 1
        ]
    ];

    public function run(): void
    {
        if (!DB::table('pi_tier_infos')->exists()) {
            DB::table('pi_tier_infos')->insert($this->tiers);
        }
    }
}