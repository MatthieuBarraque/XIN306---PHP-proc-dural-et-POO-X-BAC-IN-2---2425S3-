<?php

require_once __DIR__ . '/../../models/users/UserModel.php';

$userModel = new \Models\Users\UserModel($pdo);
$logged_in = false;
$username = null;

if (isset($_COOKIE['auth_token'])) {
    $token = $_COOKIE['auth_token'];
    $hashedToken = hash_hmac('sha256', $token, 'secret_key');
    $user = $userModel->getUserByToken($hashedToken);

    if ($user) {
        $logged_in = true;
        $username = $user['username'];
    }
}

$twig->addGlobal('logged_in', $logged_in);
$twig->addGlobal('username', $username);
?>
