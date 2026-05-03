<?php

    class Add_To_Menu {

        private $conn;
        private $table_main_categories      = 'main_categories';
        private $table_sub_categories       = 'sub_categories';
        private $table_sub_sub_categories   = 'sub_sub_categories';
        private $table_menu_items           = 'menu_items';
        private $table_menu_item_size_price = 'menu_item_size_price';
        private $table_favorites            = 'favorites';
        private $table_cart                 = 'cart';

        public function __construct() {
            $database   = new Database();
            $this->conn = $database->getConnection();
        }

        // ─── Category CRUD ────────────────────────────────────────────────────────

        public function addMainCategory($name, $description = '') {
            try {
                $query = "INSERT INTO " . $this->table_main_categories .
                         " (name, description) VALUES (:name, :description)";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':name',        $name);
                $stmt->bindParam(':description', $description);
                $stmt->execute();
                return $this->conn->lastInsertId();
            } catch (PDOException $e) {
                error_log("Add Main Category Error: " . $e->getMessage());
                return false;
            }
        }

        public function addSubCategory($main_category_id, $name, $image, $description = '') {
            try {
                $query = "INSERT INTO " . $this->table_sub_categories .
                         " (main_category_id, name, description, image)
                           VALUES (:main_category_id, :name, :description, :image)";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':main_category_id', $main_category_id);
                $stmt->bindParam(':name',             $name);
                $stmt->bindParam(':description',      $description);
                $stmt->bindParam(':image',            $image);
                $stmt->execute();
                return $this->conn->lastInsertId();
            } catch (PDOException $e) {
                error_log("Add Sub Category Error: " . $e->getMessage());
                return false;
            }
        }

        public function addSubSubCategories($sub_category_id, $name, $description = null) {
            try {
                $query = "INSERT INTO " . $this->table_sub_sub_categories .
                         " (sub_category_id, name, description)
                           VALUES (:sub_category_id, :name, :description)";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':sub_category_id', $sub_category_id);
                $stmt->bindParam(':name',            $name);
                $stmt->bindParam(':description',     $description);
                $stmt->execute();
                return $this->conn->lastInsertId();
            } catch (PDOException $e) {
                error_log("Add Sub-Sub Category Error: " . $e->getMessage());
                return false;
            }
        }

        public function fetchById($id, $table) {
            try {
                $id = (int) $id;
                if ($id <= 0) {
                    return ['success' => false, 'error' => 'Invalid ID'];
                }

                $query = "SELECT * FROM " . $table . " WHERE id = :id LIMIT 1";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$item) {
                    return ['success' => false, 'error' => 'Item not found'];
                }

                return ['success' => true, 'data' => $item];

            } catch (Exception $e) {
                error_log("Fetch By ID Error: " . $e->getMessage());
                return ['success' => false, 'error' => 'Server error'];
            }
        }

        public function updateCatById($id, $table, $data) {
            try {
                if ($id <= 0) {
                    return ['success' => false, 'error' => 'Invalid ID'];
                }

                $name = trim($data['main_name'] ?? '');
                if ($name === '') {
                    return ['success' => false, 'error' => 'Name is required'];
                }

                $image_name = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $image_name = time() . "_" . basename($_FILES['image']['name']);
                    $uploadDir  = "uploads/{$table}/";

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image_name);
                }

                if ($image_name !== null) {
                    $query = "UPDATE " . $table . " SET name = :name, image = :image WHERE id = :id";
                    $stmt  = $this->conn->prepare($query);
                    $stmt->execute(['name' => $name, 'image' => $image_name, 'id' => $id]);
                } else {
                    $query = "UPDATE " . $table . " SET name = :name WHERE id = :id";
                    $stmt  = $this->conn->prepare($query);
                    $stmt->execute(['name' => $name, 'id' => $id]);
                }

                return ['success' => true, 'message' => 'Category updated successfully'];

            } catch (Exception $e) {
                error_log("UpdateCatById Error: " . $e->getMessage());
                return ['success' => false, 'error' => $e->getMessage()];
            }
        }

        public function deleteCatById($id, $table) {
            $record = $this->fetchById($id, $table);

            if (!$record || !$record['success']) {
                return false;
            }

            $checkColumnQuery = "SHOW COLUMNS FROM " . $table . " LIKE 'image'";
            $checkStmt        = $this->conn->prepare($checkColumnQuery);
            $checkStmt->execute();
            $hasImageColumn   = $checkStmt->rowCount() > 0;

            if ($hasImageColumn && !empty($record['data']['image'])) {
                $imagePath = "uploads/{$table}/" . $record['data']['image'];
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            $query = "DELETE FROM " . $table . " WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        // ─── Menu Queries ─────────────────────────────────────────────────────────

        public function getMainCategories() {
            $query = "SELECT * FROM " . $this->table_main_categories;
            $stmt  = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getSubCategories($main_category_id) {
            $query = "SELECT * FROM " . $this->table_sub_categories .
                     " WHERE main_category_id = :main_category_id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':main_category_id', $main_category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getMenuItems($sub_category_id) {
            $query = "SELECT * FROM " . $this->table_menu_items .
                     " WHERE sub_category_id = :sub_category_id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':sub_category_id', $sub_category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getSizesAndPrices($menu_item_id) {
            $query = "SELECT * FROM " . $this->table_menu_item_size_price .
                     " WHERE menu_item_id = :menu_item_id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':menu_item_id', $menu_item_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Returns the full 3-level menu tree with prices attached to each item.
         * Structure: main_category → sub_categories → sub_sub_categories → items
         */
        public function getFullMenuStructure() {
            $queryMain     = "SELECT * FROM " . $this->table_main_categories . " ORDER BY created_at ASC";
            $stmtMain      = $this->conn->prepare($queryMain);
            $stmtMain->execute();
            $mainCategories = $stmtMain->fetchAll(PDO::FETCH_ASSOC);

            foreach ($mainCategories as &$main) {
                $querySub  = "SELECT * FROM " . $this->table_sub_categories .
                             " WHERE main_category_id = :main_category_id ORDER BY created_at ASC";
                $stmtSub   = $this->conn->prepare($querySub);
                $stmtSub->bindParam(':main_category_id', $main['id'], PDO::PARAM_INT);
                $stmtSub->execute();
                $subCategories = $stmtSub->fetchAll(PDO::FETCH_ASSOC);

                foreach ($subCategories as &$sub) {
                    $querySubSub  = "SELECT * FROM " . $this->table_sub_sub_categories .
                                    " WHERE sub_category_id = ? ORDER BY created_at ASC";
                    $stmtSubSub   = $this->conn->prepare($querySubSub);
                    $stmtSubSub->execute([$sub['id']]);
                    $subSubCategories = $stmtSubSub->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($subSubCategories as &$subSub) {
                        $queryItems  = "SELECT * FROM " . $this->table_menu_items .
                                       " WHERE sub_sub_category_id = ? ORDER BY created_at ASC";
                        $stmtItems   = $this->conn->prepare($queryItems);
                        $stmtItems->execute([$subSub['id']]);
                        $menuItems   = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($menuItems as &$item) {
                            $stmtSp = $this->conn->prepare(
                                "SELECT * FROM " . $this->table_menu_item_size_price . " WHERE menu_item_id = ?"
                            );
                            $stmtSp->execute([$item['id']]);
                            $sizesPrices = $stmtSp->fetchAll(PDO::FETCH_ASSOC);

                            $item['price_s'] = null;
                            $item['price_m'] = null;
                            $item['price_l'] = null;

                            foreach ($sizesPrices as $sp) {
                                $sizeCode = strtolower($sp['size']);
                                if     (strpos($sizeCode, 'small')  !== false) $item['price_s'] = $sp['price'];
                                elseif (strpos($sizeCode, 'medium') !== false) $item['price_m'] = $sp['price'];
                                elseif (strpos($sizeCode, 'large')  !== false) $item['price_l'] = $sp['price'];
                            }
                        }

                        $subSub['items'] = $menuItems;
                    }

                    $sub['sub_sub_categories'] = $subSubCategories;
                }

                $main['sub_categories'] = $subCategories;
            }

            return $mainCategories;
        }

        // ─── Menu Item CRUD ───────────────────────────────────────────────────────

        public function addMenuItem($sub_sub_category_id, $name, $description, $ingredients, $image, $sizes_prices = []) {
            try {
                $query = "INSERT INTO " . $this->table_menu_items .
                         " (sub_sub_category_id, name, description, ingredients, image)
                           VALUES (:sub_sub_category_id, :name, :description, :ingredients, :image)";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':sub_sub_category_id', $sub_sub_category_id);
                $stmt->bindParam(':name',                $name);
                $stmt->bindParam(':description',         $description);
                $stmt->bindParam(':ingredients',         $ingredients);
                $stmt->bindParam(':image',               $image);
                $stmt->execute();

                $menu_item_id = $this->conn->lastInsertId();

                if (!empty($sizes_prices)) {
                    $priceQuery = "INSERT INTO " . $this->table_menu_item_size_price .
                                  " (menu_item_id, size, price) VALUES (:menu_item_id, :size, :price)";
                    $stmtPrice  = $this->conn->prepare($priceQuery);

                    foreach ($sizes_prices as $sp) {
                        $stmtPrice->bindParam(':menu_item_id', $menu_item_id);
                        $stmtPrice->bindParam(':size',         $sp['size']);
                        $stmtPrice->bindParam(':price',        $sp['price']);
                        $stmtPrice->execute();
                    }
                }

                return $menu_item_id;

            } catch (PDOException $e) {
                error_log("Add Menu Item Error: " . $e->getMessage());
                return false;
            }
        }

        public function getMenuItemById($id) {
            $query = "SELECT * FROM " . $this->table_menu_items . " WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($items as &$item) {
                $stmtSp = $this->conn->prepare(
                    "SELECT * FROM " . $this->table_menu_item_size_price . " WHERE menu_item_id = ?"
                );
                $stmtSp->execute([$item['id']]);
                $item['sizes_prices'] = $stmtSp->fetchAll(PDO::FETCH_ASSOC);
            }

            return $items;
        }

        public function fetchItemById($id) {
            try {
                $id = (int) $id;
                if ($id <= 0) {
                    return ['success' => false, 'error' => 'Invalid ID'];
                }

                $query = "SELECT * FROM " . $this->table_menu_items . " WHERE id = :id LIMIT 1";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$item) {
                    return ['success' => false, 'error' => 'Item not found'];
                }

                $queryPrices = "SELECT size, price FROM " . $this->table_menu_item_size_price .
                               " WHERE menu_item_id = :id";
                $stmtPrices  = $this->conn->prepare($queryPrices);
                $stmtPrices->bindValue(':id', $id, PDO::PARAM_INT);
                $stmtPrices->execute();
                $item['prices'] = $stmtPrices->fetchAll(PDO::FETCH_KEY_PAIR);

                return ['success' => true, 'data' => $item];

            } catch (Exception $e) {
                error_log("Fetch Item By ID Error: " . $e->getMessage());
                return ['success' => false, 'error' => 'Server error'];
            }
        }

        public function updateItemById($id, $data) {
            try {
                if ($id <= 0) {
                    return ['success' => false, 'error' => 'Invalid ID'];
                }

                $name        = trim($data['name']        ?? '');
                $description = trim($data['description'] ?? '');
                $ingredients = trim($data['ingredients'] ?? '');
                $prices      = $data['prices']           ?? [];

                if ($name === '') {
                    return ['success' => false, 'error' => 'Name is required'];
                }

                $image_name = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $image_name = time() . "_" . $_FILES['image']['name'];
                    $target     = "uploads/products/" . $image_name;
                    move_uploaded_file($_FILES['image']['tmp_name'], $target);
                }

                if ($image_name !== null) {
                    $query = "UPDATE " . $this->table_menu_items . "
                              SET name = :name, description = :description,
                                  ingredients = :ingredients, image = :image
                              WHERE id = :id";
                    $stmt  = $this->conn->prepare($query);
                    $stmt->execute([
                        'name' => $name, 'description' => $description,
                        'ingredients' => $ingredients, 'image' => $image_name, 'id' => $id
                    ]);
                } else {
                    $query = "UPDATE " . $this->table_menu_items . "
                              SET name = :name, description = :description, ingredients = :ingredients
                              WHERE id = :id";
                    $stmt  = $this->conn->prepare($query);
                    $stmt->execute([
                        'name' => $name, 'description' => $description,
                        'ingredients' => $ingredients, 'id' => $id
                    ]);
                }

                if (!empty($prices)) {
                    $priceQuery = "UPDATE " . $this->table_menu_item_size_price . "
                                   SET price = :price
                                   WHERE menu_item_id = :item_id AND size = :size";
                    $stmtPrice  = $this->conn->prepare($priceQuery);

                    foreach ($prices as $size => $price) {
                        $stmtPrice->execute([
                            'price'   => $price,
                            'item_id' => $id,
                            'size'    => strtoupper($size)
                        ]);
                    }
                }

                return ['success' => true, 'message' => 'Updated successfully'];

            } catch (Exception $e) {
                error_log("Update Item By ID Error: " . $e->getMessage());
                return ['success' => false, 'error' => 'Server error'];
            }
        }

        public function deleteItemById($id) {
            try {
                $id = (int) $id;
                if ($id <= 0) return false;

                $recordResult = $this->fetchItemById($id);

                if (!$recordResult['success'] || empty($recordResult['data'])) {
                    return false;
                }

                $record = $recordResult['data'];

                $checkStmt = $this->conn->prepare(
                    "SHOW COLUMNS FROM " . $this->table_menu_items . " LIKE 'image'"
                );
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0 && !empty($record['image'])) {
                    $imagePath = "uploads/products/" . $record['image'];
                    if (file_exists($imagePath)) {
                        @unlink($imagePath);
                    }
                }

                $stmt = $this->conn->prepare(
                    "DELETE FROM " . $this->table_menu_items . " WHERE id = :id"
                );
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                return $stmt->execute();

            } catch (Exception $e) {
                error_log("Delete Item Error: " . $e->getMessage());
                return false;
            }
        }

        // ─── Favorites ────────────────────────────────────────────────────────────

        public function toggleFavorite($userId, $productId) {
            try {
                $query = "SELECT id FROM " . $this->table_favorites .
                         " WHERE user_id = :user_id AND product_id = :product_id";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':user_id',    $userId);
                $stmt->bindParam(':product_id', $productId);
                $stmt->execute();

                if ($stmt->fetch()) {
                    $del = $this->conn->prepare(
                        "DELETE FROM " . $this->table_favorites .
                        " WHERE user_id = :user_id AND product_id = :product_id"
                    );
                    $del->bindParam(':user_id',    $userId);
                    $del->bindParam(':product_id', $productId);
                    $del->execute();
                    return ['success' => true, 'message' => 'Removed from favorites'];
                } else {
                    $ins = $this->conn->prepare(
                        "INSERT INTO " . $this->table_favorites . " (user_id, product_id)
                         VALUES (:user_id, :product_id)"
                    );
                    $ins->bindParam(':user_id',    $userId);
                    $ins->bindParam(':product_id', $productId);
                    $ins->execute();
                    return ['success' => true, 'message' => 'Added to favorites'];
                }

            } catch (PDOException $e) {
                error_log("Toggle Favorite Error: " . $e->getMessage());
                return ['success' => false, 'message' => 'Favorites error: ' . $e->getMessage()];
            }
        }

        public function getFavorites($userId) {
            try {
                $query = "SELECT p.id, p.name, p.description, p.image
                          FROM " . $this->table_favorites . " f
                          INNER JOIN " . $this->table_menu_items . " p ON f.product_id = p.id
                          WHERE f.user_id = :user_id";

                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($favorites)) {
                    return [];
                }

                foreach ($favorites as &$favorite) {
                    $stmtSp = $this->conn->prepare(
                        "SELECT size, price FROM " . $this->table_menu_item_size_price . " WHERE menu_item_id = ?"
                    );
                    $stmtSp->execute([$favorite['id']]);
                    $sizesPrices = $stmtSp->fetchAll(PDO::FETCH_ASSOC);

                    $favorite['price_s'] = null;
                    $favorite['price_m'] = null;
                    $favorite['price_l'] = null;

                    foreach ($sizesPrices as $sp) {
                        $sizeCode = strtolower($sp['size']);
                        if     (strpos($sizeCode, 'small')  !== false) $favorite['price_s'] = $sp['price'];
                        elseif (strpos($sizeCode, 'medium') !== false) $favorite['price_m'] = $sp['price'];
                        elseif (strpos($sizeCode, 'large')  !== false) $favorite['price_l'] = $sp['price'];
                    }
                }

                return $favorites;

            } catch (PDOException $e) {
                error_log("Get Favorites Error: " . $e->getMessage());
                return [];
            }
        }

        public function removeFavorite($userId, $productId) {
            try {
                $query = "DELETE FROM " . $this->table_favorites .
                         " WHERE user_id = :user_id AND product_id = :product_id";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':user_id',    $userId);
                $stmt->bindParam(':product_id', $productId);
                $stmt->execute();
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                error_log("Remove Favorite Error: " . $e->getMessage());
                return false;
            }
        }

        public function checkIfFavorite($itemId, $userId) {
            $query = "SELECT COUNT(*) FROM " . $this->table_favorites .
                     " WHERE user_id = :user_id AND product_id = :item_id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId,  PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }

        // ─── Cart ─────────────────────────────────────────────────────────────────

        public function addToCart($userId, $productId, $size, $quantity = 1) {
            try {
                $checkQuery = "SELECT quantity FROM " . $this->table_cart .
                              " WHERE user_id = :user_id AND product_id = :product_id AND size = :size";
                $stmt       = $this->conn->prepare($checkQuery);
                $stmt->bindParam(':user_id',    $userId,    PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':size',       $size);
                $stmt->execute();

                if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                    $updateStmt = $this->conn->prepare(
                        "UPDATE " . $this->table_cart . " SET quantity = quantity + :quantity
                         WHERE user_id = :user_id AND product_id = :product_id AND size = :size"
                    );
                    $updateStmt->bindParam(':quantity',   $quantity,   PDO::PARAM_INT);
                    $updateStmt->bindParam(':user_id',    $userId,     PDO::PARAM_INT);
                    $updateStmt->bindParam(':product_id', $productId,  PDO::PARAM_INT);
                    $updateStmt->bindParam(':size',       $size);
                    $updateStmt->execute();
                    return ['success' => true, 'message' => 'Cart quantity updated'];
                } else {
                    $insertStmt = $this->conn->prepare(
                        "INSERT INTO " . $this->table_cart . " (user_id, product_id, size, quantity)
                         VALUES (:user_id, :product_id, :size, :quantity)"
                    );
                    $insertStmt->bindParam(':quantity',   $quantity,   PDO::PARAM_INT);
                    $insertStmt->bindParam(':user_id',    $userId,     PDO::PARAM_INT);
                    $insertStmt->bindParam(':product_id', $productId,  PDO::PARAM_INT);
                    $insertStmt->bindParam(':size',       $size);
                    $insertStmt->execute();
                    return ['success' => true, 'message' => 'Added to cart'];
                }

            } catch (PDOException $e) {
                error_log("Add To Cart Error: " . $e->getMessage());
                return ['success' => false, 'message' => 'Cart error: ' . $e->getMessage()];
            }
        }

        public function getCart($userId) {
            try {
                $query = "SELECT
                              c.user_id,
                              c.product_id,
                              p.name     AS product_name,
                              p.image    AS product_image,
                              c.size,
                              c.quantity,
                              m.price,
                              (c.quantity * m.price) AS total_price
                          FROM " . $this->table_cart . " c
                          JOIN " . $this->table_menu_item_size_price . " m
                               ON c.product_id = m.menu_item_id AND c.size = m.size
                          JOIN " . $this->table_menu_items . " p ON c.product_id = p.id
                          WHERE c.user_id = :user_id
                          ORDER BY c.added_at DESC";

                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            } catch (PDOException $e) {
                error_log("Get Cart Error: " . $e->getMessage());
                return [];
            }
        }

        public function updateSizeInCart($userId, $productId, $oldSize, $newSize) {
            try {
                $this->conn->beginTransaction();

                $stmt = $this->conn->prepare(
                    "SELECT quantity FROM cart
                     WHERE user_id = :user_id AND product_id = :product_id AND size = :old_size"
                );
                $stmt->bindParam(':user_id',    $userId,    PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':old_size',   $oldSize);
                $stmt->execute();

                $oldItem = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$oldItem) {
                    $this->conn->rollBack();
                    return false;
                }

                $oldQuantity = (int) $oldItem['quantity'];

                $stmt = $this->conn->prepare(
                    "SELECT quantity FROM cart
                     WHERE user_id = :user_id AND product_id = :product_id AND size = :new_size"
                );
                $stmt->bindParam(':user_id',    $userId,    PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':new_size',   $newSize);
                $stmt->execute();

                $newItem = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($newItem) {
                    // Merge quantities into the target size, then remove the old row
                    $this->conn->prepare(
                        "UPDATE " . $this->table_cart . "
                         SET quantity = quantity + :old_quantity
                         WHERE user_id = :user_id AND product_id = :product_id AND size = :new_size"
                    )->execute([':old_quantity' => $oldQuantity, ':user_id' => $userId,
                                ':product_id'  => $productId,   ':new_size' => $newSize]);

                    $this->conn->prepare(
                        "DELETE FROM " . $this->table_cart . "
                         WHERE user_id = :user_id AND product_id = :product_id AND size = :old_size"
                    )->execute([':user_id' => $userId, ':product_id' => $productId, ':old_size' => $oldSize]);

                } else {
                    $this->conn->prepare(
                        "UPDATE " . $this->table_cart . "
                         SET size = :new_size
                         WHERE user_id = :user_id AND product_id = :product_id AND size = :old_size"
                    )->execute([':new_size' => $newSize, ':user_id' => $userId,
                                ':product_id' => $productId, ':old_size' => $oldSize]);
                }

                $this->conn->commit();
                return true;

            } catch (PDOException $e) {
                $this->conn->rollBack();
                error_log("Update Size In Cart Error: " . $e->getMessage());
                return false;
            }
        }

        public function updateQuantity($userId, $productId, $size, $action) {
            try {
                $this->conn->beginTransaction();

                if ($action === 'increase') {
                    $query = "UPDATE " . $this->table_cart . "
                              SET quantity = quantity + 1
                              WHERE user_id = :user_id AND product_id = :product_id AND size = :size";

                } elseif ($action === 'decrease') {
                    $check = "SELECT quantity FROM " . $this->table_cart . "
                              WHERE user_id = :user_id AND product_id = :product_id AND size = :size";
                    $stmt  = $this->conn->prepare($check);
                    $stmt->bindParam(':user_id',    $userId,    PDO::PARAM_INT);
                    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                    $stmt->bindParam(':size',       $size);
                    $stmt->execute();

                    $item = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$item) {
                        $this->conn->rollBack();
                        return false;
                    }

                    $query = $item['quantity'] > 1
                        ? "UPDATE " . $this->table_cart . "
                           SET quantity = quantity - 1
                           WHERE user_id = :user_id AND product_id = :product_id AND size = :size"
                        : "DELETE FROM " . $this->table_cart . "
                           WHERE user_id = :user_id AND product_id = :product_id AND size = :size";

                } else {
                    $this->conn->rollBack();
                    return false;
                }

                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':user_id',    $userId,    PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':size',       $size);
                $stmt->execute();

                $this->conn->commit();
                return true;

            } catch (PDOException $e) {
                $this->conn->rollBack();
                error_log("Update Quantity Error: " . $e->getMessage());
                return false;
            }
        }

        public function removeFromBag($userId, $productId, $size) {
            try {
                $query = "DELETE FROM " . $this->table_cart . "
                          WHERE user_id = :user_id AND product_id = :product_id AND size = :size";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(':user_id',    $userId,    PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':size',       $size);
                $stmt->execute();

                return $stmt->rowCount() > 0;

            } catch (PDOException $e) {
                error_log("Remove From Bag Error: " . $e->getMessage());
                return false;
            }
        }
    }
