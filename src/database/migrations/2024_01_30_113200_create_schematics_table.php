<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchematicsTable extends Migration
{
    public function up(): void
    {
        Schema::create('universe_schematics', function (Blueprint $table) {
            $table->integer('schematic_id');

            $table->integer('cycle_time');
            $table->string('schematic_name');
            $table->integer('type_id')->nullable();

            $table->foreign('type_id')
                ->references('typeID')
                ->on('invTypes')
                ->onDelete('cascade');

            $table->primary('schematic_id');
        });
    }

    public function down(): void
    {
        Schema::table('universe_schematics', function (Blueprint $table) {
            $table->dropForeign('universe_schematics_type_id_foreign');
        });

        Schema::drop('universe_schematics');
    }
}