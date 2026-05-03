<?php

    class User {

        private $conn;
        private $table             = 'users';
        private $user_phones_table = 'user_phones';

        public function __construct() {
            $this->conn = Database::getInstance()->getConnection();
        }

        public function register($fullname, $email, $password, $confirm_password, $role = 'customer') {
            try {
                if ($password !== $confirm_password) {
                    error_log("Register Error: Password and Confirm Password do not match.");
                    return false;
                }

                $nameParts = explode(" ", trim($fullname), 2);
                $f_name    = $nameParts[0];
                $l_name    = isset($nameParts[1]) ? $nameParts[1] : "";

                $query = "INSERT INTO " . $this->table . " (f_name, l_name, email, password, role)
                          VALUES (:f_name, :l_name, :email, :password, :role)";

                $stmt           = $this->conn->prepare($query);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $f_name = sanitize($f_name);
                $l_name = sanitize($l_name);
                $email  = sanitize($email);
                $role   = sanitize($role);

                $stmt->bindParam(':f_name',   $f_name);
                $stmt->bindParam(':l_name',   $l_name);
                $stmt->bindParam(':email',    $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':role',     $role);

                if ($stmt->execute()) {
                    return $this->conn->lastInsertId();
                }

                return false;

            } catch (Exception $e) {
                error_log("Register Error: " . $e->getMessage());
                return false;
            }
        }

        public function login($email, $password) {
            try {
                $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
                $stmt  = $this->conn->prepare($query);

                $email = sanitize($email);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_OBJ);

                if ($user && password_verify($password, $user->password)) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id']   = $user->id;
                    $_SESSION['f_name']    = $user->f_name;
                    $_SESSION['l_name']    = $user->l_name;
                    $_SESSION['email']     = $user->email;
                    $_SESSION['role']      = $user->role;
                    return true;
                }

                return false;

            } catch (Exception $e) {
                error_log("Login Error: " . $e->getMessage());
                return false;
            }
        }

        public function fetchCurrentUser() {
            try {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if (!isset($_SESSION['email'])) {
                    return ['success' => false, 'error' => 'No user logged in'];
                }

                $email = trim($_SESSION['email']);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return ['success' => false, 'error' => 'Invalid email format'];
                }

                $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    return ['success' => false, 'error' => 'User not found'];
                }

                $phoneQuery = "SELECT phone FROM " . $this->user_phones_table . " WHERE user_id = :id";
                $phoneStmt  = $this->conn->prepare($phoneQuery);
                $phoneStmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
                $phoneStmt->execute();
                $user['phone'] = $phoneStmt->fetchColumn();

                return ['success' => true, 'data' => $user];

            } catch (Exception $e) {
                error_log("Fetch By Email Error: " . $e->getMessage());
                return ['success' => false, 'error' => 'Server error'];
            }
        }

        public function updateUserInfo($day, $month, $year, $gender, $phone) {
            try {
                // Use a transaction so all updates roll back together on failure
                $this->conn->beginTransaction();

                $queryUser = "UPDATE " . $this->table . "
                              SET day = :day, month = :month, year = :year, gender = :gender
                              WHERE id = :id";

                $stmtUser = $this->conn->prepare($queryUser);
                $stmtUser->bindParam(':day',    $day);
                $stmtUser->bindParam(':month',  $month);
                $stmtUser->bindParam(':year',   $year);
                $stmtUser->bindParam(':gender', $gender);
                $stmtUser->bindParam(':id',     $_SESSION['user_id']);
                $stmtUser->execute();

                $checkQuery = "SELECT * FROM " . $this->user_phones_table . " WHERE user_id = :id";
                $checkStmt  = $this->conn->prepare($checkQuery);
                $checkStmt->bindParam(':id', $_SESSION['user_id']);
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0) {
                    $phoneQuery = "UPDATE " . $this->user_phones_table . " SET phone = :phone WHERE user_id = :id";
                } else {
                    $phoneQuery = "INSERT INTO " . $this->user_phones_table . " (user_id, phone) VALUES (:id, :phone)";
                }

                $stmtPhone = $this->conn->prepare($phoneQuery);
                $stmtPhone->bindParam(':id',    $_SESSION['user_id']);
                $stmtPhone->bindParam(':phone', $phone);
                $stmtPhone->execute();

                $this->conn->commit();
                return true;

            } catch (Exception $e) {
                $this->conn->rollBack();
                error_log("Update User Info Error: " . $e->getMessage());
                return false;
            }
        }

        public function getAllUsers() {
            try {
                $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
                $stmt  = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (Exception $e) {
                error_log("Get Users Error: " . $e->getMessage());
                return false;
            }
        }

        public function fetchById($id) {
            try {
                $id = (int) $id;
                if ($id <= 0) {
                    return ['success' => false, 'error' => 'Invalid ID'];
                }

                $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
                $stmt  = $this->conn->prepare($query);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$item) {
                    return ['success' => false, 'error' => 'User not found'];
                }

                return ['success' => true, 'data' => $item];

            } catch (Exception $e) {
                error_log("Fetch By ID Error: " . $e->getMessage());
                return ['success' => false, 'error' => 'Server error'];
            }
        }

        public function updateById($id, $data) {
            try {
                if ($id <= 0) {
                    return ['success' => false, 'error' => 'Invalid ID'];
                }

                $fullname = trim($data['fullname'] ?? '');
                $email    = trim($data['email']    ?? '');
                $password = trim($data['password'] ?? '');
                $role     = trim($data['role']     ?? '');

                if ($fullname === '' || $email === '' || $role === '') {
                    return ['success' => false, 'error' => 'Missing required fields'];
                }

                $nameParts = explode(" ", $fullname);
                $f_name    = $nameParts[0] ?? '';
                $l_name    = $nameParts[1] ?? '';

                // The sentinel '.........' means "keep existing password unchanged"
                if ($password !== '.........') {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                    $query = "UPDATE " . $this->table . "
                              SET f_name = :f_name, l_name = :l_name, email = :email,
                                  password = :password, role = :role
                              WHERE id = :id";

                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([
                        'f_name' => $f_name, 'l_name' => $l_name,
                        'email'  => $email,  'password' => $hashedPassword,
                        'role'   => $role,   'id' => $id
                    ]);

                } else {

                    $query = "UPDATE " . $this->table . "
                              SET f_name = :f_name, l_name = :l_name, email = :email, role = :role
                              WHERE id = :id";

                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([
                        'f_name' => $f_name, 'l_name' => $l_name,
                        'email'  => $email,  'role' => $role, 'id' => $id
                    ]);
                }

                return ['success' => true, 'message' => 'Updated successfully'];

            } catch (Exception $e) {
                error_log("Update By ID Error: " . $e->getMessage());
                return ['success' => false, 'error' => 'Server error'];
            }
        }

        public function deleteUser($id) {
            $record = $this->fetchById($id);

            if (!$record || !$record['success']) {
                return false;
            }

            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        }
    }
