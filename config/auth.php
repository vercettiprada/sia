<?php

return [
    'defaults' => [
        'guard' => 'api',
        // 'passwords' => 'users', // This relates to password resets, likely not needed for hardcoded auth
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt', // We still use JWT for handling the token itself
            'provider' => 'hardcoded_user_provider', // <--- CHANGE THIS: Point to our new provider
        ],
    ],

    'providers' => [
        // You can keep the original 'users' provider if you might switch back later
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class
        ],

        // --- ADD THIS NEW PROVIDER ---
        'hardcoded_user_provider' => [
            'driver' => 'custom_hardcoded', // We will define this custom driver logic next
            // We can add options here if needed, like the actual credentials
            'email' => 'bershka@gmail.com', // Example hardcoded email
            'password' => 'ily123456',     // Example hardcoded password (see security note below)
            'user_data' => [             // Example hardcoded user attributes
                'id' => 999,
                'name' => 'Nigga im so horny User',
                'username' => 's',       // From your screenshot
                'jobid' => 2,            // From your screenshot
                'email' => 'bershka@gmail.com',
                // Add any other fields your User model or application expects
            ]
        ]
        // --- END OF ADDITION ---
    ]
];