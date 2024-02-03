<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustryInputsTable extends Migration
{
    public function up(): void
    {
        Schema::create('pi_factory_inputs', function (Blueprint $table) {
            $table->integer('schematic_id');
            $table->integer('input_type_id');
            $table->integer('quantity_consumed');

            $table->foreign('schematic_id')
                ->references('schematic_id')
                ->on('universe_schematics')
                ->cascadeOnDelete();

            $table->foreign('input_type_id')
                ->references('typeID')
                ->on('invTypes')
                ->cascadeOnDelete();

            $table->primary(['schematic_id', 'input_type_id']);
        });
    }

    public function down(): void
    {
        Schema::table('pi_factory_inputs', function (Blueprint $table) {
            $table->dropForeign('pi_factory_inputs_schematic_id_foreign');
            $table->dropForeign('pi_factory_inputs_input_type_id_foreign');
        });

        Schema::drop('pi_factory_inputs');
    }
}