<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    function hasForeignKey(string $table, string $column): bool
    {
        $fkColumns = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys($table);
        return collect($fkColumns)->map(function ($fkColumn) {
            return $fkColumn->getColumns();
        })->flatten()->contains($column);
    }

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('pi_tier_infos', function (Blueprint $table) {
            if ($this->hasForeignKey('pi_tier_infos', 'market_group_id')) {
                $table->dropForeign('pi_tier_infos_market_group_id_foreign');
            }
        });
        Schema::enableForeignKeyConstraints();
    }
};