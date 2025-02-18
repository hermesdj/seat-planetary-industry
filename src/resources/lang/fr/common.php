<?php

return [
    'menu' => [
        'extractors' => 'Extracteurs',
        'storage' => 'Stockage',
        'factories' => 'Usines',
        'projects' => 'Projets',
        'planets' => 'Planètes',
        'templates' => 'Modèles',
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
            'factory_pins' => 'Épingles',
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
        ],
        "messages" => [
            "warning" => "<strong>Attention:</strong> Le a mise à jour des contenus des planètes sont restreints par les intervalles de mise à jours avec l'API de EVE ce qui peut entraîner un délai entre les données en jeu et les données représentées içi. De plus, les données de quantité sur les planètes d'Industrie Planétaire récupérées par cette API  ne sont pas connue pour être fiable, ce qui peut expliquer des anomalies observées avec les données en jeu et sur SeAT."
        ]
    ],
    'btns' => [
        'cancel' => 'Annuler',
        'submit' => 'Envoyer',
        'close' => 'Fermer',
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