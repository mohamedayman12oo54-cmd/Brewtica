<?php

    class AuthMiddleware {

        public static function requiredLogin() {
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                redirect('/', ['openModal' => 'signinModal']);
            }
        }
    }
