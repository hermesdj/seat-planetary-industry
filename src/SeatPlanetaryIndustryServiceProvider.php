<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry;

use Seat\Services\AbstractSeatPlugin;

class SeatPlanetaryIndustryServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->add_routes();

        $this->add_views();

        $this->add_translations();

        $this->add_publications();

        $this->add_migrations();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/package.sidebar.character.php', 'package.sidebar.character.entries');
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
    }

    private function add_migrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
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