<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTables extends Migration
{
    public function up(): void
    {
        Schema::create('pi_account_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->nullableTimestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::create('pi_project_objectives', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->integer('schematic_id');

            $table->integer('target_quantity');

            $table->primary(['project_id', 'schematic_id']);

            $table->foreign('project_id')
                ->references('id')
                ->on('pi_account_projects')
                ->cascadeOnDelete();

            $table->foreign('schematic_id')
                ->references('schematic_id')
                ->on('universe_schematics')
                ->cascadeOnDelete();
        });

        Schema::create('pi_corporation_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('corporation_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->nullableTimestamps();

            $table->foreign('corporation_id')
                ->references('corporation_id')
                ->on('corporation_infos')
                ->cascadeOnDelete();
        });

        Schema::create('pi_corporation_project_objectives', function (Blueprint $table) {
            $table->integer('corporation_project_id')->unsigned();
            $table->integer('schematic_id');

            $table->integer('target_quantity');

            $table->primary(['corporation_project_id', 'schematic_id']);

            $table->foreign('corporation_project_id')
                ->references('id')
                ->on('pi_corporation_projects')
                ->cascadeOnDelete();

            $table->foreign('schematic_id')
                ->references('schematic_id')
                ->on('universe_schematics')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pi_project_objectives', function (Blueprint $table) {
            $table->dropForeign('pi_project_objectives_project_id_foreign');
            $table->dropForeign('pi_project_objectives_schematic_id_foreign');
        });

        Schema::drop('pi_project_objectives');

        Schema::table('pi_account_projects', function (Blueprint $table) {
            $table->dropForeign('pi_account_projects_user_id_foreign');
        });

        Schema::drop('pi_account_projects');

        Schema::table('pi_corporation_project_objectives', function (Blueprint $table) {
            $table->dropForeign('pi_corporation_project_objectives_corporation_project_id_foreign');
            $table->dropForeign('pi_corporation_project_objectives_schematic_id_foreign');
        });

        Schema::drop('pi_corporation_project_objectives');

        Schema::table('pi_corporation_projects', function (Blueprint $table) {
            $table->dropForeign('pi_corporation_projects_corporation_id_foreign');
        });

        Schema::drop('pi_corporation_projects');
    }
}