<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry;

use HermesDj\Seat\SeatPlanetaryIndustry\Commands\Sde\PlanetarySdeCommand;
use HermesDj\Seat\SeatPlanetaryIndustry\database\seeds\ScheduleSeeder;
use HermesDj\Seat\SeatPlanetaryIndustry\database\seeds\TierInfoSeeder;
use HermesDj\Seat\SeatPlanetaryIndustry\Http\Composers\AccountPiMenu;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet\AccountAssignedPlanet;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Projects\Planet\CorporationAssignedPlanet;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Schematic;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\TierInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanet;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetContent;
use Seat\Eveapi\Models\PlanetaryInteraction\CharacterPlanetPin;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Services\AbstractSeatPlugin;

class SeatPlanetaryIndustryServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->add_routes();

        $this->add_view_composers();

        $this->add_views();

        $this->add_translations();

        $this->add_publications();

        $this->add_migrations();

        $this->add_commands();

        $this->add_relations_resolver();
    }

    public function register(): void
    {
        // Sidebar
        $this->mergeConfigFrom(__DIR__ . '/Config/package.sidebar.character.php', 'package.sidebar.character.entries');
        $this->mergeConfigFrom(__DIR__ . '/Config/package.sidebar.corporation.php', 'package.sidebar.corporation.entries');
        //$this->mergeConfigFrom(__DIR__ . '/Config/package.sidebar.tools.php', 'package.sidebar.tools.entries');

        // Menus
        $this->mergeConfigFrom(__DIR__ . '/Config/seat-pi.account.menu.php', 'seat-pi.account.menu');

        // Permissions
        Gate::define('pi.project.owner', 'HermesDj\Seat\SeatPlanetaryIndustry\Acl\AccountProjectPolicy@isOwner');
        $this->registerPermissions(__DIR__ . '/Config/Permissions/corporation.php', 'corporation');
        $this->registerPermissions(__DIR__ . '/Config/Permissions/planetary.php', 'planetary');

        $this->registerDatabaseSeeders([
            ScheduleSeeder::class,
            TierInfoSeeder::class
        ]);
    }

    private function add_routes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }

    private function add_views(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'seat-pi');
    }

    private function add_translations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'seat-pi');
    }

    private function add_publications(): void
    {
        /*
        $this->publishes([
            __DIR__ . '/resources/css' => public_path('web/css'),
            __DIR__ . '/resources/img' => public_path('web/img'),
            __DIR__ . '/resources/js' => public_path('web/js'),
        ], ['public', 'seat']);
        */
        $this->publishes([
            __DIR__ . '/resources/js' => public_path('web/js'),
        ], ['public', 'seat']);
    }

    private function add_migrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }

    private function add_view_composers(): void
    {
        $this->app['view']->composer([
            'seat-pi::account.includes.menu'
        ], AccountPiMenu::class);
    }

    private function add_commands(): void
    {
        $this->commands([
            PlanetarySdeCommand::class
        ]);
    }

    private function add_relations_resolver(): void
    {
        CharacterPlanet::resolveRelationUsing('contents', function (CharacterPlanet $model) {
            return $model->hasMany(CharacterPlanetContent::class, 'planet_id', 'planet_id')
                ->where('character_id', $model->character_id);
        });

        CharacterPlanet::resolveRelationUsing('character', function (CharacterPlanet $model) {
            return $model->belongsTo(CharacterInfo::class, 'character_id', 'character_id');
        });

        CharacterPlanetContent::resolveRelationUsing('pin', function (CharacterPlanetContent $model) {
            return $model->belongsTo(CharacterPlanetPin::class, 'pin_id', 'pin_id');
        });

        CharacterPlanetContent::resolveRelationUsing('product', function (CharacterPlanetContent $model) {
            return $model->hasOne(InvType::class, 'typeID', 'type_id')
                ->withDefault();
        });

        CharacterPlanetContent::resolveRelationUsing('type', function (CharacterPlanetContent $model) {
            return $model->hasOne(InvType::class, 'typeID', 'type_id')
                ->withDefault();
        });

        CharacterPlanetPin::resolveRelationUsing('schematic', function (CharacterPlanetPin $model) {
            return $model->hasOne(Schematic::class, 'schematic_id', 'schematic_id');
        });

        CharacterPlanetPin::resolveRelationUsing('character', function (CharacterPlanetPin $model) {
            return $model->hasOne(CharacterInfo::class, 'character_id', 'character_id');
        });

        CharacterPlanetPin::resolveRelationUsing('colony', function (CharacterPlanetPin $model) {
            return $model->hasOne(CharacterPlanet::class, 'planet_id', 'planet_id');
        });

        CharacterPlanetPin::resolveRelationUsing('contents', function (CharacterPlanetPin $model) {
            return $model->hasMany(CharacterPlanetContent::class, 'pin_id', 'pin_id');
        });

        CharacterPlanetPin::resolveRelationUsing('type', function (CharacterPlanetPin $model) {
            return $model->hasOne(InvType::class, 'typeID', 'type_id')
                ->withDefault();
        });

        CharacterPlanet::resolveRelationUsing('factories', function (CharacterPlanet $model) {
            return $model->hasMany(CharacterPlanetPin::class, 'planet_id', 'planet_id')
                ->where('character_id', $model->character_id)
                ->whereNotNull('schematic_id')
                ->select('schematic_id', 'character_id', 'planet_id', DB::raw('COUNT(pin_id) as nbFactories'), DB::raw("MAX(str_to_date(last_cycle_start, '%Y-%m-%d %H:%i:%s')) as maxLastCycleStart"))
                ->groupBy('schematic_id', 'character_id', 'planet_id');
        });

        InvType::resolveRelationUsing('pi_tier', function (InvType $model) {
            return $model->hasOne(TierInfo::class, 'market_group_id', 'marketGroupID');
        });

        InvType::resolveRelationUsing('schematic', function (InvType $model) {
            return $model->hasOne(Schematic::class, 'type_id', 'typeID');
        });

        CharacterPlanet::resolveRelationUsing('assignedTo', function (CharacterPlanet $model) {
            return $model->hasOne(AccountAssignedPlanet::class, 'character_planet_id', 'id');
        });

        CharacterPlanet::resolveRelationUsing('assignedToCorp', function (CharacterPlanet $model) {
            return $model->hasOne(CorporationAssignedPlanet::class, 'character_planet_id', 'id');
        });

        CharacterInfo::resolveRelationUsing('assignedPlanets', function (CharacterInfo $model) {
            return $model->through('colonies')->has('assignedTo');
        });

        CharacterInfo::resolveRelationUsing('corpAssignedPlanets', function (CharacterInfo $model) {
            return $model->through('colonies')->has('assignedToCorp');
        });
    }

    public function getName(): string
    {
        return "Seat Planetary Industry";
    }

    public function getPackageRepositoryUrl(): string
    {
        return "https://github.com/hermesdj/seat-planetary-industry";
    }

    public function getPackagistPackageName(): string
    {
        return "seat-planetary-industry";
    }

    public function getPackagistVendorName(): string
    {
        return "hermesdj";
    }
}