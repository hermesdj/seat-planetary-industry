<?php

return [
    'view_pi_projects' => [
        'label' => 'seat-pi::corporation.permissions.view_projects.label',
        'description' => 'seat-pi::corporation.permissions.view_projects.desc',
        'division' => 'industrial',
    ],
    'manage_pi_projects' => [
        'label' => 'seat-pi::corporation.permissions.manage_project.label',
        'description' => 'seat-pi::corporation.permissions.manage_project.desc',
        'division' => 'industrial'
    ],
    'manage_pi_objectives' => [
        'label' => 'seat-pi::corporation.permissions.manage_objectives.label',
        'description' => 'seat-pi::corporation.permissions.manage_objectives.desc',
        'division' => 'industrial'
    ],
    'assign_pi_planet' => [
        'label' => 'seat-pi::corporation.permissions.assign_planet.label',
        'description' => 'seat-pi::corporation.permissions.assign_planet.desc',
        'division' => 'industrial',
        'gate' => 'HermesDj\Seat\SeatPlanetaryIndustry\Acl\AssignedPlanetPolicy'
    ],
    'admin_pi_planet' => [
        'label' => 'seat-pi::corporation.permissions.admin_planet.label',
        'description' => 'seat-pi::corporation.permissions.admin_planet.desc',
        'division' => 'industrial',
        'gate' => 'HermesDj\Seat\SeatPlanetaryIndustry\Acl\AssignedPlanetPolicy'
    ]
];