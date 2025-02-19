<?php

return [
    'menu' => [
        'extractors' => 'Extractors',
        'storage' => 'Storage',
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
    'storage' => [
        'headers' => [
            'storage' => 'Storage',
            'capacity' => 'Capacity',
            'used_capacity' => 'Used Capacity',
            'progress' => 'Progress',
            'contents' => 'Contents',
        ],
        "messages" => [
            "warning" => "<strong>Be advised:</strong> Storage container updates are restricted by EVE Online's update intervals and ESI schedules, which may cause delays in reflecting the latest contents. Additionally, data retrieved regarding quantities may possibly be unreliable due to ESI."
        ]
    ],
    'btns' => [
        'cancel' => 'Cancel',
        'submit' => 'Submit',
        'close' => 'Close',
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