<?php

// Pure data file — reads from $_ENV (populated by init.php before this file loads).
// Safe to re-execute multiple times; contains no function definitions.
return [
    'database' => [
        'host'     => $_ENV['DB_HOST']    ?? 'localhost',
        'database' => $_ENV['DB_NAME']    ?? 'brewtica__db',
        'username' => $_ENV['DB_USER']    ?? 'root',
        'password' => $_ENV['DB_PASS']    ?? '',
        'port'     => (int) ($_ENV['DB_PORT']    ?? 3306),
        'charset'  => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    ],
    'app' => [
        'base_url' => $_ENV['APP_URL']   ?? 'http://localhost/',
        'debug'    => ($_ENV['APP_DEBUG'] ?? 'false') === 'true',
    ],
];
