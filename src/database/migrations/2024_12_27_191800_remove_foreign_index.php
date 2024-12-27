<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pi_tier_infos', function (Blueprint $table) {
            $table->dropForeign('pi_tier_infos_market_group_id_foreign');
        });
    }
};