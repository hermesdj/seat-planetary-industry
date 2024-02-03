<?php

return [
    'menu' => [
        'name' => 'Corporation PI',
        'label' => 'Corporation PI',
    ],
    'permissions' => [
        'view_projects' => [
            'label' => 'View Corp PI Projects',
            'desc' => 'Allow a user to view a corporation PI Projects'
        ],
        'manage_project' => [
            'label' => 'Manage Corp PI Project',
            'desc' => 'Allow a user to manage the corporation PI Projects'
        ],
        'manage_objectives' => [
            'label' => 'Manage Corp PI Project Objectives',
            'desc' => 'Allow a user to manage the objectives of a Corp PI Project'
        ],
        'assign_planet' => [
            'label' => 'Assign planet to PI Project',
            'desc' => 'Allow a user to assign/unassign his own planets to a Corp PI Project',
            'deny' => 'You are not allowed to manage this planet to this project'
        ],
        'admin_planet' => [
            'label' => 'PI Planet Admin',
            'desc' => 'Allow a user to unassign any planets from a PI project'
        ]
    ],
    'page' => [
        'title' => ':name corp PI'
    ]
];