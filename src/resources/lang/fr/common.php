<?php

return [
    'menu' => [
        'extractors' => 'Extracteurs',
        'storage' => 'Stockage',
        'factories' => 'Usines',
        'projects' => 'Projets',
        'planets' => 'Planètes',
        'overview' => 'Résumé'
    ],
    'cycle' => [
        'quantity_header' => 'Qté/Cycle',
        'header' => 'Temps de Cycle',
        'time' => ':time Secondes',
        'quantity_per_hour' => 'Qté/Heure',
        'last_cycle_start' => 'Dernier Cycle',
        'active' => 'Actif',
        'not_active' => 'Non Actif',
        'state' => 'Status'
    ],
    'factory' => [
        'headers' => [
            'tier' => 'Tier',
            'consumes' => 'Consomme/Heure',
            'produces' => 'Produit/Heure',
            'factory' => 'Usine',
            'quantity' => 'Quantité'
        ]
    ],
    'planet' => [
        'headers' => [
            'assignedTo' => 'Assigné au Projet',
            'content' => 'Stocks'
        ],
        'assignedToCorp' => 'La planète est assignée au projet de la corporation :corp ":name" !',
        'assignedTo' => 'La planète est assignée à votre projet personnel ":name"'
    ],
    'storage' => [
        'headers' => [
            'storage' => 'Stockage',
            'capacity' => 'Capacité',
            'used_capacity' => 'Capacité Utilisée',
            'progress' => 'Progrès',
            'contents' => 'Contenu',
        ]
    ],
    'btns' => [
        'cancel' => 'Annuler',
        'submit' => 'Envoyer'
    ],
    'table' => [
        'actions' => 'Actions'
    ],
    'modals' => [
        'remove' => [
            'title' => 'Confirmer la suppression ?',
            'notice' => 'Supprimer cet objet ne peut pas être annulé, êtes-vous sûr ?'
        ],
        'unassign' => [
            'title' => 'Confirmer le retrait ?',
            'notice' => 'Retirer cette planète ne peut pas être annulé, êtes-vous sûr ?'
        ]
    ]
];