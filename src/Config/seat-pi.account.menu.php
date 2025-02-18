<?php

return [
    [
        'name' => 'extractors',
        'label' => 'seat-pi::common.menu.extractors',
        'route' => 'seat-pi::account-pi-extractors',
        'permission' => 'character.planetary',
        'highlight_view' => 'extractors'
    ],
    [
        'name' => 'factories',
        'label' => 'seat-pi::common.menu.factories',
        'route' => 'seat-pi::account-pi-factories',
        'permission' => 'character.planetary',
        'highlight_view' => 'factories'
    ],
    [
        'name' => 'planets',
        'label' => 'seat-pi::common.menu.planets',
        'route' => 'seat-pi::account-pi-planets',
        'permission' => 'character.planetary',
        'highlight_view' => 'planets'
    ],
    [
        'name' => 'projects',
        'label' => 'seat-pi::common.menu.projects',
        'route' => 'seat-pi::account-pi-projects',
        'permission' => 'character.planetary',
        'highlight_view' => 'projects'
    ],
    [
        'name' => 'storage',
        'label' => 'seat-pi::common.menu.storage',
        'route' => 'seat-pi::account-pi-storage',
        'permission' => 'character.planetary',
        'highlight_view' => 'storage'
    ],
];