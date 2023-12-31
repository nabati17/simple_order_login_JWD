<?php

session_start();

require_once 'Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // List user yang valid
        // Selain user ini tidak bisa login.
        $list_user = [
            [
                'email' => 'asnaba@gmail.com',
                'password' => '1'
            ],
        ];

        $login_success = false;

        foreach ($list_user as $registered_user) {
            if ($registered_user['email'] == $email && $registered_user['password'] == $password) {
                $_SESSION['login'] = true;
                $_SESSION['email'] = $email;
                $login_success = true;
                break;
            }
        }

        if ($login_success) {
            $cart = new Cart($_SESSION);
            $_SESSION['login_success'] = true;
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = 'Email atau password salah';
            header("Location: login.php");
            exit;
        }
    }
}