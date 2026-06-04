<?php

return [
    'title' => 'Newsletter',
    'fields' => [
        'id' => 'ID',
        'email' => 'Email',
        'created_at' => 'Date d\'inscription',
    ],
    'validation' => [
        'email' => [
            'required' => 'L\'adresse email est requise.',
            'email' => 'Veuillez entrer une adresse email valide.',
            'unique' => 'Cette adresse email est déjà inscrite.',
        ],
    ],
    'success' => 'Inscription réussie ! Merci.',
    'actions' => [
        'export' => 'Exporter CSV',
    ],
];
