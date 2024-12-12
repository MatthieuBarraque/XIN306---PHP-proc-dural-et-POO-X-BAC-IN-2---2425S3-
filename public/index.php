<?php
session_start();

require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../vendor/autoload.php';

use controllers\AuthController;
use controllers\MessageController;
use models\Users\UserModel;

if (!isset($pdo) || !isset($twig)) {
    die("Erreur : \$pdo ou \$twig non défini. Vérifiez init.php");
}

$routes = [
    'home' => '/',
    'messages' => '/messages',
    'login' => '/login',
    'register' => '/register',
    'logout' => '/logout',
    'profile' => '/profile',
    'about' => '/about',
    'forgot_password' => '/forgot_password',
    'handle_forgot_password' => '/handle_forgot_password',
    'reset_password' => '/reset_password',
    'handle_reset_password' => '/handle_reset_password',
];

require_once __DIR__ . '/../core/router.php';

try {
    $currentRoute = getCurrentRoute();
    $authController = new AuthController($pdo, $twig);
    $messageController = new MessageController($pdo, $twig);
    $userModel = new UserModel($pdo);

    $app_user = (isset($_SESSION['user_id']) && isset($_SESSION['username'])) ? [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
    ] : null;

    handleRoute($currentRoute, $authController, $messageController, $userModel, $twig, $pdo, $app_user);
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur interne : " . htmlspecialchars($e->getMessage());
    exit;
}

?>