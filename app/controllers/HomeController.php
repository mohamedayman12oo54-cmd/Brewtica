<?php

    class HomeController {

        public function index() {
            render('home/index', []);
        }

        public function showMenu_B() {
            $data = ['page_type' => "menu_B"];
            render('home/menu_B', $data);
        }

        public function drinks_B() {
            $data = ['page_type' => "menu_B"];
            render('home/drinks_B', $data);
        }

    }
