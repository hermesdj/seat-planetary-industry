<?php

return [
    'permissions' => [
        'read' => [
            'label' => 'View Planetary Surveys',
            'desc' => 'Allow a user to consult the planetary surveys stored in SeAT'
        ],
        'manage' => [
            'label' => 'Write Planetary Survey',
            'desc' => 'Allow a user to manage a planetary survey (create, edit, delete)'
        ]
    ],
    'menu' => [
        'name' => 'planetary-survey',
        'label' => 'Planetary Survey'
    ]
];