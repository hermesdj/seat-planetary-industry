<?php

use HermesDj\Seat\SeatPlanetaryIndustry\Commands\Sde\PlanetarySdeCommand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchematicForeignToPin extends Migration
{
    public function up(): void
    {
        $command = new PlanetarySdeCommand();

        // Need to populate the schematics table before creating the foreign constraint
        $command->handle();

        Schema::table('character_planet_pins', function (Blueprint $table) {
            $table->foreign('schematic_id')
                ->references('schematic_id')
                ->on('universe_schematics')
                ->noActionOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('character_planet_pins', function (Blueprint $table) {
            $table->dropForeign('character_planet_pins_schematic_id_foreign');
        });
    }
}