<?php

return [
    'api_keys' => [
        'secret_key' => env('STRIPE_SECRET_KEY', null),
        'currency' => env('STRIPE_CURRENCY', null),
        'amount' => env('STRIPE_AMOUNT', null),
    ]
];