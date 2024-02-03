<?php

return [
    'menu' => [
        'name' => 'Corporation PI',
        'label' => 'Indus. Planétaire Corpo',
    ],
    'permissions' => [
        'view_projects' => [
            'label' => 'Voir les projets d\'industrie planétaire',
            'desc' => 'Permet à un utilisateur de consulter les projets d\'industrie planétaire de la corporation'
        ],
        'manage_project' => [
            'label' => 'Gestion des Projets d\'industrie planétaire',
            'desc' => 'Permet à un utilisateur de créer/modifier/supprimer les projets d\'industrie planétaire de corporation.'
        ],
        'manage_objectives' => [
            'label' => 'Gestion des Objectifs de projets d\'industrie planétaire',
            'desc' => 'Permet à un utilisateur de créer/modifier/supprimer des objectifs de projet d\'industrie planétaire.'
        ],
        'assign_planet' => [
            'label' => 'Assigner une planète à un projet d\'industrie planétaire de corporation',
            'desc' => 'Permet à un utilisateur d\'assigner/désassigner une planète à un projet d\'industrie planétaire de corporation',
            'deny' => 'Vous n\'êtes pas autorisé à modifier l\'assignation de cette planète sur ce projet'
        ],
        'admin_planet' => [
            'label' => 'Administrateur de planètes assignées aux projets d\'industrie planétaire de corporation',
            'desc' => 'Permet à un utilisateur de désassigner une planète d\'un projet de corporation même si cette planète n\'est pas à lui.'
        ]
    ],
    'page' => [
        'title' => 'Industrie Planétaire de la corpo :name'
    ]
];