<?php

return [
    'no_description' => 'No project description',
    'permissions' => [
        'deny' => 'You are not allowed to view this project !'
    ],
    'fields' => [
        'name' => [
            'label' => 'Project Name',
            'placeholder' => 'Give your PI project a name'
        ],
        'description' => [
            'label' => 'Project Description',
            'placeholder' => 'Describe what you intend to do with this PI Project'
        ]
    ],
    'list' => [
        'empty' => 'Empty Project list, create one !'
    ],
    'assigned_planets' => [
        'title' => 'Assigned Planets',
        'table' => [
          'headers' => [
              'is_active' => 'Is Active'
          ]
        ],
        'modals' => [
            'assign' => [
                'title' => 'Assign a Planet'
            ],
            'unassign' => [
                'title' => 'Unassign Planet',
                'notice' => 'This will unassign the planet from this project',
                'tooltip' => 'Unassign planet'
            ]
        ],
        'fields' => [
            'planet' => [
                'label' => 'Assign Planet'
            ]
        ]
    ],
    'objectives' => [
        'title' => 'Objectives',
        'modals' => [
            'create' => [
                'title' => 'Add new Objective'
            ],
            'delete' => [
                'btn' => 'Delete this objective',
                'title' => 'Confirm objective deletion'
            ],
            'edit' => [
                'title' => 'Edit Project Objective',
                'tooltip' => 'Edit Objective'
            ]
        ],
        'fields' => [
            'schematic' => [
                'label' => 'Schematic'
            ],
            'target_quantity' => [
                'label' => 'Target Quantity (/h)'
            ]
        ]
    ],
    'fabrication' => [
        'title' => 'Fabrication',
        'columns' => [
            'schematic' => 'Schematic',
            'tier' => 'Tier',
            'factoriesNeeded' => 'Factories Needed',
            'actualFactories' => 'Actual Factories',
            'deltaFactories' => 'Missing Factories',
            'productionNeeded' => 'Production Needed (/h)',
            'actualProduction' => 'Actual Production (/h)',
            'deltaProduction' => 'Missing Production'
        ]
    ],
    'extraction' => [
        'title' => 'Extraction',
        'columns' => [
            'resource' => 'Resource',
            'extractionNeeded' => 'Extraction Needed (/h)',
            'actualExtraction' => 'Actual Extraction (/h)',
            'deltaExtraction' => 'Missing Extraction'
        ]
    ],
    'modals' => [
        'delete' => [
            'tooltip' => 'Delete this project',
            'title' => 'Delete Project',
            'notice' => 'This action will delete this project, are you sure ?'
        ]
    ]
];