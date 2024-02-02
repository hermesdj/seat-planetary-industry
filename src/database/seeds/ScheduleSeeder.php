<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    protected array $schedules = [
        [
            'command' => 'eve:update:sde:planetary',
            // Sync schematics every month
            'expression' => '0 0 1 * *',
            'allow_overlap' => false,
            'allow_maintenance' => false,
            'ping_before' => null,
            'ping_after' => null
        ]
    ];

    public function run(): void
    {
        DB::table('schedules')->whereIn('command', [
            'esi:update:schematics'
        ])->delete();

        foreach ($this->schedules as $job) {
            if (DB::table('schedules')->where('command', $job['command'])->exists()) {
                DB::table('schedules')->where('command', $job['command'])->update([
                    'expression' => $job['expression']
                ]);
            } else {
                DB::table('schedules')->insert($job);
            }
        }
    }
}