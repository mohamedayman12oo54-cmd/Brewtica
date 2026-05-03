<?php

    class ProfileController {

        public function fav_list_B() {
            $data = ['page_type' => "fav_list_B"];
            render('home/fav_list_B', $data, 'layouts/layout_fav_B');
        }

        public function my_account_B() {
            $data = ['page_type' => "my_account_B"];
            render('home/my_account_B', $data, 'layouts/layout_fav_B');
        }

        public function Bag_B() {
            $data = ['page_type' => "Bag_B"];
            render('home/Bag_B', $data, 'layouts/layout_fav_B');
        }

        public function favourites_handler() {

            header('Content-Type: application/json');

            if (!isset($_SESSION['user_id'])) {
                echo json_encode([
                    'success'       => false,
                    'requires_login' => true,
                    'message'       => 'Please log in to add items to your favorites.'
                ]);
                exit;
            }

            $input      = json_decode(file_get_contents('php://input'), true);
            $product_id = $input['product_id'] ?? null;
            $user_id    = $_SESSION['user_id'];

            if (!$product_id) {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
                exit;
            }

            $fav    = new Add_To_Menu();
            $result = $fav->toggleFavorite($user_id, $product_id);

            echo json_encode($result);
            exit;
        }

        public function delete_favorite() {

            $userId    = $_SESSION['user_id'] ?? null;
            $productId = $_POST['product_id'] ?? null;

            if (!$userId || !$productId) {
                echo 'error';
                exit;
            }

            $delFav = new Add_To_Menu();

            echo $delFav->removeFavorite($userId, $productId) ? 'success' : 'error';
            exit;
        }

        public function bag_handler() {

            header('Content-Type: application/json');

            if (!isset($_SESSION['user_id'])) {
                echo json_encode([
                    'success'        => false,
                    'requires_login' => true,
                    'message'        => 'Please log in to add items to your cart.'
                ]);
                exit;
            }

            $input        = json_decode(file_get_contents('php://input'), true);
            $product_id   = $input['product_id']   ?? null;
            $product_size = $input['product_size']  ?? null;
            $user_id      = $_SESSION['user_id'];

            if (!$product_id || !$product_size) {
                echo json_encode(['success' => false, 'message' => 'Invalid product or size']);
                exit;
            }

            $sizeMap = ['S' => 'small', 'M' => 'medium', 'L' => 'large'];

            if (!isset($sizeMap[$product_size])) {
                echo json_encode(['success' => false, 'message' => 'Invalid size value']);
                exit;
            }

            $cart   = new Add_To_Menu();
            $result = $cart->addToCart($user_id, $product_id, $sizeMap[$product_size]);

            echo json_encode($result);
            exit;
        }

        public function update_size() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $user_id    = $_SESSION['user_id'];
            $product_id = $_POST['product_id'] ?? null;
            $old_size   = $_POST['old_size']   ?? null;
            $new_size   = $_POST['new_size']   ?? null;

            if (!$product_id || !$old_size || !$new_size) {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID, old size, or new size']);
                exit;
            }

            $update_cart = new Add_To_Menu();

            if ($update_cart->updateSizeInCart($user_id, $product_id, $old_size, $new_size)) {
                echo json_encode(['success' => true, 'message' => 'Size updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Size update failed']);
            }
            exit;
        }

        public function update_quantity() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $user_id         = $_SESSION['user_id'];
            $product_id      = $_POST['product_id']      ?? null;
            $quantity_action = $_POST['quantity_action'] ?? null;
            $size            = $_POST['size']            ?? null;

            if (!$product_id || !$quantity_action || !$size) {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID, size, or action']);
                exit;
            }

            $update_cart = new Add_To_Menu();

            if ($update_cart->updateQuantity($user_id, $product_id, $size, $quantity_action)) {
                echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Quantity update failed']);
            }
            exit;
        }

        public function remove_from_bag() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $user_id    = $_SESSION['user_id'];
            $product_id = $_POST['product_id'] ?? null;
            $size       = $_POST['size']       ?? null;

            if (!$product_id || !$size) {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID or size']);
                exit;
            }

            $cart = new Add_To_Menu();

            if ($cart->removeFromBag($user_id, $product_id, $size)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Remove failed']);
            }
            exit;
        }

        public function toggle_cart_item_check() {

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

            $product_id = $_POST['product_id'];
            $size       = $_POST['size'];
            $checked    = $_POST['checked'];

            $_SESSION['cart_checked'][$product_id][$size] = $checked;
        }
    }
