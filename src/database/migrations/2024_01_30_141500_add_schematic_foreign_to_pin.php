<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddSchematicForeignToPin extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        // Need to populate the schematics table before creating the foreign key
        $exitCode = Artisan::call('eve:update:sde:planetary');

        if ($exitCode == 0) {
            Schema::table('character_planet_pins', function (Blueprint $table) {
                $table->foreign('schematic_id')
                    ->references('schematic_id')
                    ->on('universe_schematics')
                    ->noActionOnDelete();
            });
        } else {
            throw new Exception("Could not sync schematics table");
        }
    }

    public function down(): void
    {
        Schema::table('character_planet_pins', function (Blueprint $table) {
            $table->dropForeign('character_planet_pins_schematic_id_foreign');
        });
    }
}