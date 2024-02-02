<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedPlanetsTable extends Migration
{
    public function up(): void
    {
        Schema::create('pi_account_assigned_planets', function (Blueprint $table) {
            $table->bigInteger('character_planet_id')->unsigned();
            $table->integer('account_project_id')->unsigned();

            $table->foreign('character_planet_id')
                ->references('id')
                ->on('character_planets')
                ->cascadeOnDelete();

            $table->foreign('account_project_id')
                ->references('id')
                ->on('pi_account_projects')
                ->cascadeOnDelete();

            $table->primary(['character_planet_id', 'account_project_id']);
        });

        Schema::create('pi_corporation_assigned_planets', function (Blueprint $table) {
            $table->bigInteger('character_planet_id')->unsigned();
            $table->integer('corporation_project_id')->unsigned();

            $table->foreign('character_planet_id')
                ->references('id')
                ->on('character_planets')
                ->cascadeOnDelete();

            $table->foreign('corporation_project_id')
                ->references('id')
                ->on('pi_corporation_projects')
                ->cascadeOnDelete();

            $table->primary(['character_planet_id', 'corporation_project_id']);
        });
    }

    public function down(): void
    {
        Schema::table('pi_account_assigned_planets', function (Blueprint $table) {
            $table->dropForeign('pi_account_assigned_planets_character_planet_id_foreign');
            $table->dropForeign('pi_account_assigned_planets_account_project_id_foreign');
        });

        Schema::drop('pi_account_assigned_planets');

        Schema::table('pi_corporation_assigned_planets', function (Blueprint $table) {
            $table->dropForeign('pi_corporation_assigned_planets_character_planet_id_foreign');
            $table->dropForeign('pi_corporation_assigned_planets_corporation_project_id_foreign');
        });

        Schema::drop('pi_corporation_assigned_planets');
    }
}