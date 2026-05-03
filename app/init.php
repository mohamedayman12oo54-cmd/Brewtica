<?php

    session_start();

    // Parse .env into $_ENV once, before anything else loads
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim(trim($value), '"\'');
            if ($key !== '' && !array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
            }
        }
    }

    $config = require_once __DIR__ . "/../config/config.php";

    if (!defined('BASE_URL')) {
        define('BASE_URL', $config['app']['base_url']);
    }

    require_once __DIR__ . '/helpers.php';

    spl_autoload_register(function ($class_name) {
        $paths = [
            __DIR__ . '/controllers/',
            __DIR__ . '/models/',
            __DIR__ . '/middlewares/',
        ];

        foreach ($paths as $path) {
            $file = $path . $class_name . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    });
