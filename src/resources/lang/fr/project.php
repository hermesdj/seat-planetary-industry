<?php

return [
    'no_description' => 'Aucune description de projet',
    'permissions' => [
        'deny' => 'Vous n\'êtes pas autorisé à consulter la page de ce projet !'
    ],
    'fields' => [
        'name' => [
            'label' => 'Nom du Projet',
            'placeholder' => 'Donnez à votre projet d\'industrie planétaire un nom !'
        ],
        'description' => [
            'label' => 'Description du Projet',
            'placeholder' => 'Décrivez ce que vous avez l\'intention de faire avec ce projet.'
        ]
    ],
    'list' => [
        'empty' => 'Aucun Projet trouvé, créez en un !'
    ],
    'assigned_planets' => [
        'title' => 'Planètes Assignées',
        'modals' => [
            'assign' => [
                'title' => 'Assigner une Planète'
            ],
            'unassign' => [
                'title' => 'Désassigner une Planète',
                'notice' => 'Cela va désassigner cette planète du projet',
                'tooltip' => 'Désassigner le Planète'
            ]
        ],
        'fields' => [
            'planet' => [
                'label' => 'Planète à Assigner'
            ]
        ]
    ],
    'objectives' => [
        'title' => 'Objectifs de Production',
        'modals' => [
            'create' => [
                'title' => 'Ajouter nouvel Objectif'
            ],
            'delete' => [
                'btn' => 'Supprimer cet objectif',
                'title' => 'Confirmer la suppression de l\'objectif'
            ],
            'edit' => [
                'title' => 'Modifier objectif de production',
                'tooltip' => 'Modifier cet objectif'
            ]
        ],
        'fields' => [
            'schematic' => [
                'label' => 'Schéma de production'
            ],
            'target_quantity' => [
                'label' => 'Quantité Cible (/h)'
            ]
        ]
    ],
    'fabrication' => [
        'title' => 'Fabrication',
        'columns' => [
            'schematic' => 'Schéma',
            'tier' => 'Tier',
            'factoriesNeeded' => 'Usines Requises',
            'actualFactories' => 'Usines Installées',
            'deltaFactories' => 'Usines Manquantes',
            'productionNeeded' => 'Production Requise (/h)',
            'actualProduction' => 'Production Réelle (/h)',
            'deltaProduction' => 'Production Manquante'
        ]
    ],
    'extraction' => [
        'title' => 'Extraction',
        'columns' => [
            'resource' => 'Ressource',
            'extractionNeeded' => 'Extraction Requise (/h)',
            'actualExtraction' => 'Extraction Réelle (/h)',
            'deltaExtraction' => 'Extraction Manquante'
        ]
    ],
    'modals' => [
        'delete' => [
            'tooltip' => 'Supprimer ce Projet',
            'title' => 'Supprimer le Project',
            'notice' => 'Cette action va supprimer ce projet, en êtes vous sûr ?'
        ]
    ]
];