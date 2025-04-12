<?php

return [

    'default' => env('DB_CONNECTION', 'mysql'), // This will now default to 'external_db'

    'connections' => [

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_OLD', '127.0.0.1'),
            'port'      => env('DB_PORT_OLD', '3306'),
            'database'  => env('DB_DATABASE_OLD', 'forge'),
            'username'  => env('DB_USERNAME_OLD', 'forge'),
            'password'  => env('DB_PASSWORD_OLD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ],

        'external_db' => [
            'driver'    => env('DB_CONNECTION_EXTERNAL', 'mysql'),
            'host'      => env('DB_HOST_EXTERNAL', 'mysql.railway.internal'),
            'port'      => env('DB_PORT_EXTERNAL', '3306'),
            'database'  => env('DB_DATABASE_EXTERNAL', 'railway'),
            'username'  => env('DB_USERNAME_EXTERNAL', 'root'),
            'password'  => env('DB_PASSWORD_EXTERNAL', 'yhoAaJSWviJCZaKdLcxrOHZBUNENxQHL'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ],

    ],

    // ... other configurations ...
];