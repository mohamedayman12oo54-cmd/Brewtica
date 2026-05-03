<?php

    class RoleMiddleware {
        
        public static function requireRole($role) {

            if(!isset($_SESSION['role']) || $_SESSION['role'] !== $role){

                redirect('/', [
                    'openModal' => 'signinModal'
                ]);
            }
        }
    }



?>