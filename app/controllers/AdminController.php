<?php

    class AdminController {

        public function __construct() {
            AuthMiddleware::requiredLogin();
            RoleMiddleware::requireRole('admin');
        }

        public function dashboard() {
            $data = ['current_page' => "dashboard_B"];
            render('admin/dashboard_B', $data, 'layouts/layout_admin_B');
        }

        public function admin_categories_B() {
            $data = ['current_page' => "admin_categories_B"];
            render('admin/admin_categories_B', $data, 'layouts/layout_admin_B');
        }

        public function category() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $addToMenu = new Add_To_Menu();
            $table     = $_POST['table'] ?? null;

            if ($table === 'main_categories') {

                $main_name = $_POST['main_name'];
                $cat_id    = $addToMenu->addMainCategory($main_name);

                if ($cat_id) {
                    echo json_encode([
                        'success'  => true,
                        'category' => ['id' => $cat_id, 'name' => $main_name, 'type' => 'main']
                    ]);
                }

            } elseif ($table === 'sub_categories') {

                $main_category_id = $_POST['main_category_id'];
                $sub_name         = $_POST['sub_name'];

                $image_name = null;
                if (isset($_FILES['sub_image']) && $_FILES['sub_image']['error'] === 0) {
                    $image_name = time() . "_" . $_FILES['sub_image']['name'];
                    $target     = "uploads/sub_categories/" . $image_name;
                    move_uploaded_file($_FILES['sub_image']['tmp_name'], $target);
                }

                $cat_id = $addToMenu->addSubCategory($main_category_id, $sub_name, $image_name);

                if ($cat_id) {
                    echo json_encode([
                        'success'  => true,
                        'category' => [
                            'id'               => $cat_id,
                            'main_category_id' => $main_category_id,
                            'name'             => $sub_name,
                            'type'             => 'sub'
                        ]
                    ]);
                }

            } elseif ($table === 'sub_sub_categories') {

                $sub_category_id = $_POST['sub_category_id'];
                $sub_sub_name    = $_POST['sub_sub_name'];
                $cat_id          = $addToMenu->addSubSubCategories($sub_category_id, $sub_sub_name);

                if ($cat_id) {
                    echo json_encode([
                        'success'  => true,
                        'category' => [
                            'id'              => $cat_id,
                            'sub_category_id' => $sub_category_id,
                            'name'            => $sub_sub_name,
                            'type'            => 'sub-sub'
                        ]
                    ]);
                }

            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid table']);
            }
        }

        public function category_api() {

            header('Content-Type: application/json');

            $cat = new Add_To_Menu();

            if (!isset($_GET['action'])) {
                echo json_encode(['success' => false, 'error' => 'No action specified']);
                exit;
            }

            $allowedTables = ['main_categories', 'sub_categories', 'sub_sub_categories'];

            if ($_GET['action'] === 'fetch' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                $id    = (int) ($_POST['id']    ?? 0);
                $table = $_POST['table'] ?? '';

                if (!in_array($table, $allowedTables, true)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid table name']);
                    exit;
                }

                if ($id <= 0) {
                    echo json_encode(['success' => false, 'error' => 'Invalid ID']);
                    exit;
                }

                try {
                    $result = $cat->fetchById($id, $table);

                    if (!$result || empty($result['data'])) {
                        echo json_encode(['success' => false, 'error' => 'Record not found']);
                        exit;
                    }

                    echo json_encode($result);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }

                exit;
            }

            if ($_GET['action'] === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                $id    = (int) ($_POST['main_id'] ?? $_POST['sub_id'] ?? $_POST['sub_sub_id'] ?? 0);
                $table = $_POST['table'] ?? '';

                $data = [
                    'main_name'   => $_POST['main_name'] ?? $_POST['sub_name'] ?? $_POST['sub_sub_name'] ?? '',
                    'description' => $_POST['description'] ?? ''
                ];

                if (isset($_FILES['sub_image']) && $_FILES['sub_image']['error'] === 0) {
                    $oldItem  = $cat->fetchById($id, $table);
                    $oldImage = $oldItem['data']['image'] ?? null;

                    $image_name = time() . "_" . basename($_FILES['image']['name']);
                    $uploadDir  = "uploads/{$table}/";

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $target = $uploadDir . $image_name;

                    if (move_uploaded_file($_FILES['sub_image']['tmp_name'], $target)) {
                        $data['image'] = $image_name;

                        if ($oldImage && file_exists($uploadDir . $oldImage)) {
                            unlink($uploadDir . $oldImage);
                        }
                    }
                }

                $result = $cat->updateCatById($id, $table, $data);
                echo json_encode($result);
                exit;
            }

            echo json_encode(['success' => false, 'error' => 'Unknown action']);
            exit;
        }

        public function delete_cat() {

            header("Content-Type: application/json");

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
                exit;
            }

            $id    = $_POST['id']    ?? null;
            $table = $_POST['table'] ?? null;

            if (!$id || !is_numeric($id)) {
                echo json_encode(['success' => false, 'message' => 'Invalid ID']);
                exit;
            }

            $allowedTables = ['main_categories', 'sub_categories', 'sub_sub_categories'];

            if (!in_array($table, $allowedTables, true)) {
                echo json_encode(['success' => false, 'message' => 'Invalid table']);
                exit;
            }

            $addToMenu = new Add_To_Menu();
            $result    = $addToMenu->deleteCatById((int) $id, $table);

            echo json_encode($result
                ? ['success' => true,  'message' => 'Deleted successfully']
                : ['success' => false, 'message' => 'Delete failed']
            );
        }

        public function admin_menu_B() {
            $data = ['current_page' => "admin_menu_B"];
            render('admin/admin_menu_B', $data, 'layouts/layout_admin_B');
        }

        public function menu() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $sub_sub_category_id = $_POST['sub_sub_category_id'];
            $name                = $_POST['name'];
            $description         = $_POST['description'];
            $ingredients         = $_POST['ingredients'];
            $sizes_prices        = [
                ["size" => "small",  "price" => $_POST['priceS']],
                ["size" => "medium", "price" => $_POST['priceM']],
                ["size" => "large",  "price" => $_POST['priceL']],
            ];

            $image_name = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image_name = time() . "_" . $_FILES['image']['name'];
                $target     = "uploads/products/" . $image_name;
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
            }

            $addToMenu    = new Add_To_Menu();
            $newProductId = $addToMenu->addMenuItem(
                $sub_sub_category_id, $name, $description, $ingredients, $image_name, $sizes_prices
            );

            if ($newProductId) {
                echo json_encode([
                    'success' => true,
                    'product' => [
                        'id'                  => $newProductId,
                        'name'                => $name,
                        'sub_sub_category_id' => $sub_sub_category_id,
                        'description'         => $description
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to add item']);
            }
        }

        public function menu_api() {

            header('Content-Type: application/json');

            $menu = new Add_To_Menu();

            if (!isset($_GET['action'])) {
                echo json_encode(['success' => false, 'error' => 'No action specified']);
                exit;
            }

            if ($_GET['action'] === 'fetch' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $id     = (int) ($_POST['id'] ?? 0);
                $result = $menu->fetchItemById($id);
                echo json_encode($result);
                exit;
            }

            if ($_GET['action'] === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $id   = (int) ($_POST['item_id'] ?? 0);
                $data = [
                    'name'        => $_POST['name']        ?? '',
                    'description' => $_POST['description'] ?? '',
                    'ingredients' => $_POST['ingredients'] ?? '',
                    'prices'      => [
                        'small'  => $_POST['priceS'] ?? null,
                        'medium' => $_POST['priceM'] ?? null,
                        'large'  => $_POST['priceL'] ?? null,
                    ]
                ];

                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $oldItem  = $menu->fetchItemById($id);
                    $oldImage = $oldItem['data']['image'] ?? null;

                    $image_name = time() . "_" . basename($_FILES['image']['name']);
                    $target     = "uploads/products/" . $image_name;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        $data['image'] = $image_name;

                        if ($oldImage && file_exists("uploads/products/" . $oldImage)) {
                            unlink("uploads/products/" . $oldImage);
                        }
                    }
                }

                $result = $menu->updateItemById($id, $data);
                echo json_encode($result);
                exit;
            }

            echo json_encode(['success' => false, 'error' => 'Unknown action']);
            exit;
        }

        public function delete_item() {

            header("Content-Type: application/json");

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
                exit;
            }

            $id = $_POST['item_id'] ?? null;

            if (!$id || !is_numeric($id)) {
                echo json_encode(['success' => false, 'message' => 'Invalid ID']);
                exit;
            }

            $addToMenu = new Add_To_Menu();
            $result    = $addToMenu->deleteItemById((int) $id);

            echo json_encode($result
                ? ['success' => true,  'message' => 'Item deleted successfully']
                : ['success' => false, 'message' => 'Delete failed']
            );
        }

        public function admin_staff_B() {
            $data = ['current_page' => "admin_staff_B"];
            render('admin/admin_staff_B', $data, 'layouts/layout_admin_B');
        }

        public function staff() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $full_name        = $_POST['fullname']         ?? '';
            $email            = $_POST['email']            ?? '';
            $password         = $_POST['password']         ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role             = $_POST['role']             ?? '';

            $user      = new User();
            $newUserId = $user->register($full_name, $email, $password, $confirm_password, $role);

            if ($newUserId) {
                echo json_encode([
                    'success' => true,
                    'user'    => [
                        'id'       => $newUserId,
                        'fullname' => $full_name,
                        'email'    => $email,
                        'role'     => $role
                    ]
                ]);
            } else {
                http_response_code(422);
                echo json_encode(['success' => false, 'message' => 'Failed to create user']);
            }
        }

        public function staff_api() {

            header('Content-Type: application/json');

            $user = new User();

            if (!isset($_GET['action'])) {
                echo json_encode(['success' => false, 'error' => 'No action specified']);
                exit;
            }

            if ($_GET['action'] === 'fetch' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $id     = (int) ($_POST['id'] ?? 0);
                $result = $user->fetchById($id);
                echo json_encode($result);
                exit;
            }

            if ($_GET['action'] === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $id   = (int) ($_POST['id'] ?? 0);
                $data = [
                    'fullname' => $_POST['fullname'] ?? '',
                    'email'    => $_POST['email']    ?? '',
                    'password' => $_POST['password'] ?? '',
                    'role'     => $_POST['role']     ?? ''
                ];

                $result = $user->updateById($id, $data);
                echo json_encode($result);
                exit;
            }

            echo json_encode(['success' => false, 'error' => 'Unknown action']);
            exit;
        }

        public function delete_user() {

            $user_id = $_POST['user_id'] ?? null;

            $delUser = new User();

            echo $delUser->deleteUser($user_id) ? 'success' : 'error';
            exit;
        }
    }
