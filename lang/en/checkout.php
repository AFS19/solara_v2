<?php

return [
    'title' => 'Checkout',
    'cart_empty' => 'Your cart is empty.',
    'success' => 'Order #:order confirmed.',
    'success_title' => 'Thank you!',
    'success_message' => 'Your order has been placed successfully. We will contact you very soon.',
    'order_number' => 'Order #:order',
    'cod_helper' => 'Only cash on delivery is available at the moment.',
    'back_to_home' => 'Back to home',
    'email' => 'Email address',
    'first_name' => 'First name',
    'last_name' => 'Last name',
    'address' => 'Address',
    'city' => 'City',
    'postal_code' => 'Postal code',
    'phone' => 'Phone',
    'payment_method' => 'Payment method',
    'cod' => 'Cash on delivery',
    'place_order' => 'Place order',
    'summary' => 'Summary',
    'validation' => [
        'email' => [
            'required' => 'Email address is required.',
        ],
        'first_name' => [
            'required' => 'First name is required.',
        ],
        'last_name' => [
            'required' => 'Last name is required.',
        ],
        'address' => [
            'required' => 'Address is required.',
        ],
        'city' => [
            'required' => 'City is required.',
        ],
        'postal_code' => [
            'required' => 'Postal code is required.',
        ],
        'phone' => [
            'required' => 'Phone number is required.',
            'regex' => 'The phone number must be a valid Moroccan mobile number (10 digits starting with 06 or 07).',
        ],
    ],
];
