<?php

return [
    'fields' => [
        'id' => 'N° commande',
        'customer' => 'Client',
        'email' => 'Email',
        'first_name' => 'Prénom',
        'last_name' => 'Nom',
        'address' => 'Adresse',
        'city' => 'Ville',
        'postal_code' => 'Code postal',
        'phone' => 'Téléphone',
        'status' => 'Statut',
        'payment_method' => 'Mode de paiement',
        'payment_status' => 'Statut paiement',
        'total' => 'Total',
        'created_at' => 'Date',
        'items' => 'Articles',
        'quantity' => 'Quantité',
        'subtotal' => 'Sous-total',
    ],
    'status' => [
        'pending' => 'En attente',
        'processing' => 'En traitement',
        'shipped' => 'Expédiée',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée',
    ],
    'payment_status' => [
        'pending' => 'En attente',
        'paid' => 'Payée',
    ],
    'payment_method' => [
        'cod' => 'Paiement à la livraison',
        'online' => 'En ligne',
    ],
    'actions' => [
        'ship' => 'Marquer expédiée',
        'deliver' => 'Marquer livrée + payée',
        'cancel' => 'Annuler commande',
    ],
    'filters' => [
        'status' => 'Statut',
        'payment_method' => 'Mode de paiement',
        'date_range' => 'Période',
        'from' => 'Du',
        'to' => 'Au',
    ],
];
