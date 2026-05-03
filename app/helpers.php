<?php

    function base_url($path = '') {
        if (defined('BASE_URL')) {
            return BASE_URL . ltrim($path, '/');
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST'];
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $base = str_replace('\\', '/', $base);
        $base = rtrim($base, '/');

        return $protocol . $host . $base . '/' . ltrim($path, '/');
    }

    function base_path($path = '') {
        return realpath(__DIR__ . '/../' . '/' . ltrim($path, '/'));
    }

    function views_path($path = '') {
        return base_path('app/views/' . ltrim($path, '/'));
    }

    function redirect($path = '', $queryParams = []) {
        $url = base_url($path);

        if (!empty($queryParams)) {
            $url .= "?" . http_build_query($queryParams);
        }

        header("Location: " . $url);
        exit();
    }

    function render($view = null, $data = [], $layout = 'layout') {
        extract($data);

        if ($view) {
            ob_start();
            require_once views_path($view . '.php');
            $content = ob_get_clean();
        }

        require_once views_path($layout . '.php');
    }

    function config($key) {
        $config = require base_path('config/config.php');
        $keys   = explode('.', $key);
        $value  = $config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                throw new Exception("Config key '{$k}' not found");
            }
            $value = $value[$k];
        }

        return $value;
    }

    function sanitize($value) {
        return htmlspecialchars(strip_tags($value));
    }

    function upload_path($filename = '') {
        return base_path('uploads' . DIRECTORY_SEPARATOR . $filename);
    }

    function uploads_url($filename = '') {
        return base_url('uploads/' . ltrim($filename, DIRECTORY_SEPARATOR));
    }

    function asset_url($path = '') {
        return base_url('assets/') . ltrim($path, DIRECTORY_SEPARATOR);
    }

    function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }

    function getPostData($field, $default = null) {
        return isset($_POST[$field]) ? trim($_POST[$field]) : $default;
    }

    function generateFileName($name) {
        $file = strtolower($name);
        $file = str_replace(' ', '_', $file);
        return $file . '_B';
    }

    function reverseFileName($fileName) {
        if (substr($fileName, -2) === '_B') {
            $fileName = substr($fileName, 0, -2);
        }
        $fileName = str_replace('_', ' ', $fileName);
        return ucwords($fileName);
    }

    function isUserLoggedIn() {
        return isset($_SESSION['user_id']) && $_SESSION['role'] === 'customer';
    }
