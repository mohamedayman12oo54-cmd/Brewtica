<?php

    class UserController {

        public function showJoinForm() {
            render('user/join_B', [], 'layouts/layout_join_B');
        }

        public function join() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $fullname = getPostData('fullname');
            $email    = filter_var(getPostData('email'), FILTER_SANITIZE_EMAIL);
            $password = getPostData('password');
            $confirm  = getPostData('confirm_password');

            $errors = [];

            if (empty($fullname)) {
                $errors['fullname'] = 'Full name is required';
            } elseif (strlen($fullname) < 3) {
                $errors['fullname'] = 'Full name must be at least 3 characters';
            }

            if (empty($email)) {
                $errors['email'] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format';
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required';
            } elseif (strlen($password) < 4) {
                $errors['password'] = 'Password must be at least 4 characters';
            }

            if ($password !== $confirm) {
                $errors['confirm_password'] = 'Passwords do not match';
            }

            if (!empty($errors)) {
                http_response_code(422);
                echo json_encode(['success' => false, 'errors' => $errors]);
                exit;
            }

            $user = new User();

            if ($user->register($fullname, $email, $password, $confirm)) {
                echo json_encode(['success' => true, 'message' => 'Account created successfully']);
            } else {
                http_response_code(409);
                echo json_encode(['success' => false, 'message' => 'Email already exists']);
            }
        }

        public function sign_in() {

            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
                exit;
            }

            $email    = $_POST['email']    ?? '';
            $password = $_POST['password'] ?? '';

            $user = new User();

            if ($user->login($email, $password)) {
                echo json_encode(['success' => true, 'role' => $_SESSION['role']]);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
            }
        }

        public function UpdateUserInfo() {

            if (isPostRequest()) {
                $day    = getPostData('day');
                $month  = getPostData('month');
                $year   = getPostData('year');
                $gender = getPostData('gender');
                $phone  = getPostData('phone');

                $user = new User();

                if ($user->updateUserInfo($day, $month, $year, $gender, $phone)) {
                    redirect("my_account_B");
                } else {
                    echo "Failed to update profile";
                }
            }
        }

        public function logout() {
            $_SESSION = [];
            session_destroy();
            redirect('/', ['openModal' => 'signinModal']);
        }
    }
