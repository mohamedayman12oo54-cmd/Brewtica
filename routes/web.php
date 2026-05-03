<?php 

    $routes = [
        'GET' => [
            //------ Home Pages ------
            '/' => 'HomeController@index',
            '/menu_B' => 'HomeController@showMenu_B',
            '/drinks_B' => 'HomeController@drinks_B',

            //------ Profile Pages ------
            '/fav_list_B' => 'ProfileController@fav_list_B',
            '/my_account_B' => 'ProfileController@my_account_B',
            '/bag_B' => 'ProfileController@Bag_B',

            //------ User Pages ------
            '/user/join_B' => 'UserController@showJoinForm',

            //------ Admin Pages ------
            '/dashboard_B' => 'AdminController@dashboard',
            '/admin/categories_B' => 'AdminController@admin_categories_B',
            '/admin/menu_B' => 'AdminController@admin_menu_B',
            '/admin/staff_B' => 'AdminController@admin_staff_B',

        ],

        'POST' => [
            //------ User Actions ------
            '/join_B' => 'UserController@join',
            '/sign_in_B' => 'UserController@sign_in',
            '/logout' => 'UserController@logout',

            //------ Profile Actions ------
            '/favourites_handler' => 'ProfileController@favourites_handler',
            '/delete_favorite' => 'ProfileController@delete_favorite',
            '/bag_handler' => 'ProfileController@bag_handler',
            '/update_size' => 'ProfileController@update_size',
            '/update_quantity' => 'ProfileController@update_quantity',
            '/remove_from_bag' => 'ProfileController@remove_from_bag',
            '/toggle_cart_item_check' => 'ProfileController@toggle_cart_item_check',

            //------ User Methods ------
            '/my_account_B' => 'UserController@UpdateUserInfo',

            //------ Admin Methods ------
            '/categories' => 'AdminController@category',
            '/category_api' => 'AdminController@category_api',
            '/delete_category' => 'AdminController@delete_cat',
            '/admin_menu' => 'AdminController@menu',
            '/menu_api' => 'AdminController@menu_api',
            '/delete_item' => 'AdminController@delete_item',
            '/staff' => 'AdminController@staff',
            '/staff_api' => 'AdminController@staff_api',
            '/delete_user' => 'AdminController@delete_user',

        ]

    ];

?>