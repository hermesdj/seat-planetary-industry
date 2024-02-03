<?php

return [
    'permissions' => [
        'read' => [
            'label' => 'Voir analyse planétaire',
            'desc' => 'Permet à un utilisateur de consulter les analyse planétaires stockées dans SeAT'
        ],
        'manage' => [
            'label' => 'Gérer les analyses planétaires',
            'desc' => 'Permet à un utilisateur de gérer les analyses planétaire (création/modification/suppression)'
        ]
    ],
    'menu' => [
        'name' => 'planetary-survey',
        'label' => 'Analyse Planétaire'
    ]
];