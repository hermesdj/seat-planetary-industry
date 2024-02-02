<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Seat\Web\Exceptions\PackageMenuBuilderException;
use Seat\Web\Http\Composers\AbstractMenu;

class AccountPiMenu extends AbstractMenu
{

    /**
     * @throws PackageMenuBuilderException
     */
    public function compose(View $view): void
    {
        $menu = [];

        if (!empty(config('seat-pi.account.menu'))) {
            foreach (config('seat-pi.account.menu') as $menu_data) {
                $prepared_menu = $this->load_plugin_menu('seat-pi', $menu_data, false);

                if (!is_null($prepared_menu)) {
                    $menu[] = $prepared_menu;
                }
            }
        }

        $menu = array_values(Arr::sort($menu, function ($value) {
            return $value['name'];
        }));

        $view->with('menu', $menu);
    }

    public function getRequiredKeys(): array
    {
        return [
            'name', 'permission', 'highlight_view', 'route'
        ];
    }

    protected function userHasPermission(array $permissions): bool
    {
        return true;
    }
}