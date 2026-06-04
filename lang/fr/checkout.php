<?php

return [
    'title' => 'Commande',
    'cart_empty' => 'Votre panier est vide.',
    'success' => 'Commande #:order confirmée.',
    'success_title' => 'Merci !',
    'success_message' => 'Votre commande a bien été passée. Nous vous contacterons très prochainement.',
    'order_number' => 'Commande n°:order',
    'cod_helper' => 'Seul le paiement à la livraison est disponible pour le moment.',
    'back_to_home' => "Retour à l'accueil",
    'email' => 'Adresse email',
    'first_name' => 'Prénom',
    'last_name' => 'Nom',
    'address' => 'Adresse',
    'city' => 'Ville',
    'postal_code' => 'Code postal',
    'phone' => 'Téléphone',
    'payment_method' => 'Mode de paiement',
    'cod' => 'Paiement à la livraison',
    'place_order' => 'Confirmer la commande',
    'summary' => 'Récapitulatif',
    'validation' => [
        'email' => [
            'required' => "L'adresse email est obligatoire.",
        ],
        'first_name' => [
            'required' => 'Le prénom est obligatoire.',
        ],
        'last_name' => [
            'required' => 'Le nom est obligatoire.',
        ],
        'address' => [
            'required' => "L'adresse est obligatoire.",
        ],
        'city' => [
            'required' => 'La ville est obligatoire.',
        ],
        'postal_code' => [
            'required' => 'Le code postal est obligatoire.',
        ],
        'phone' => [
            'required' => 'Le numéro de téléphone est obligatoire.',
            'regex' => 'Le numéro doit être un mobile marocain valide (10 chiffres commençant par 06 ou 07).',
        ],
    ],
];
