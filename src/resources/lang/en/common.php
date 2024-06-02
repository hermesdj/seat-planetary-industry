<?php

return [
    'menu' => [
        'extractors' => 'Extractors',
        'factories' => 'Factories',
        'projects' => 'Projects',
        'planets' => 'Planets',
        'overview' => 'Overview'
    ],
    'cycle' => [
        'quantity_header' => 'Qty/Cycle',
        'header' => 'Cycle Time',
        'time' => ':time Seconds',
        'quantity_per_hour' => 'Qty/Hour',
        'last_cycle_start' => 'Last Cycle',
        'active' => 'Active',
        'not_active' => 'Not Active',
        'state' => 'State'
    ],
    'factory' => [
        'headers' => [
            'tier' => 'Tier',
            'consumes' => 'Consumes/Hours',
            'produces' => 'Produces/Hours',
            'factory' => 'Factory',
            'quantity' => 'Quantity'
        ]
    ],
    'planet' => [
        'headers' => [
            'assignedTo' => 'Assigned To Project',
            'content' => 'Content'
        ],
        'assignedToCorp' => 'Planet is assigned to corporation :corp project :name !',
        'assignedTo' => 'This planet is assigned to your personal project :name'
    ],
    'btns' => [
        'cancel' => 'Cancel',
        'submit' => 'Submit'
    ],
    'table' => [
        'actions' => 'Actions'
    ],
    'modals' => [
        'remove' => [
            'title' => 'Confirm Remove ?',
            'notice' => 'Removing this object cannot be undone, do you confirm ?'
        ],
        'unassign' => [
            'title' => 'Unassign Planet',
            'notice' => 'Unassigning this planet cannot be undone, do you confirm ?'
        ]
    ]
];