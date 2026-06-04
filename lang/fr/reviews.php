<?php

return [
    'title' => 'Avis clients',
    'average' => 'Note moyenne',
    'out_of' => ':rating / 5',
    'count' => ':count avis',
    'no_reviews' => 'Aucun avis pour le moment. Soyez le premier !',
    'write' => 'Écrire un avis',
    'submit' => 'Envoyer mon avis',
    'success' => 'Merci ! Votre avis a été soumis et sera publié après validation.',
    'approved' => 'Approuvé',
    'pending' => 'En attente',
    'validation' => [
        'rating' => [
            'required' => 'Veuillez choisir une note.',
            'between' => 'La note doit être comprise entre 1 et 5.',
        ],
        'comment' => [
            'max' => 'Le commentaire ne doit pas dépasser :max caractères.',
        ],
        'name' => [
            'required_without' => 'Veuillez indiquer votre nom.',
        ],
        'email' => [
            'required_without' => 'Veuillez indiquer votre email.',
            'email' => 'Veuillez entrer une adresse email valide.',
        ],
    ],
    'fields' => [
        'id' => 'ID',
        'product' => 'Produit',
        'name' => 'Nom',
        'email' => 'Email',
        'rating' => 'Note',
        'comment' => 'Commentaire',
        'is_approved' => 'Approuvé',
        'created_at' => 'Date',
    ],
    'filters' => [
        'is_approved' => 'Statut',
        'product' => 'Produit',
    ],
    'actions' => [
        'approve' => 'Approuver',
        'reject' => 'Rejeter',
    ],
];
