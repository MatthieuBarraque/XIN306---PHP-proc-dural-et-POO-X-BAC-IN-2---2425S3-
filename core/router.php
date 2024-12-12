<?php
require_once __DIR__ . '/routing/home.php';
require_once __DIR__ . '/routing/auth.php';
require_once __DIR__ . '/routing/profile.php';
require_once __DIR__ . '/routing/about.php';
require_once __DIR__ . '/routing/messages.php';
require_once __DIR__ . '/routing/logout.php';
require_once __DIR__ . '/routing/errors.php';

/**
 * Determines the current route based on the request URI.
 *
 * @return string The current route.
 * @throws Exception If routes are not defined.
 */
function getCurrentRoute(): string {
    global $routes;

    if (!isset($routes) || !is_array($routes)) {
        throw new Exception("Routes are not defined or not an array.");
    }

    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if ($requestUri !== '/' && substr($requestUri, -1) === '/') {
        $requestUri = rtrim($requestUri, '/');
    }
    return array_search($requestUri, $routes, true) ?: '404';
}

/**
 * Handles routing logic for the current route.
 *
 * @param string $currentRoute The current route.
 * @param \Controllers\AuthController $authController $authController Authentication controller.
 * @param \Controllers\MessageController $messageController Message controller.
 * @param \Models\Users\UserModel $userModel User model.
 * @param Twig\Environment $twig Twig rendering engine.
 * @param PDO $pdo Database connection.
 * @param array|null $app_user Logged-in user details.
 */
function handleRoute(
    string $currentRoute,
    $authController,
    $messageController,
    \Models\Users\UserModel $userModel,
    $twig,
    $pdo,
    $app_user
): void {
    switch ($currentRoute) {
        case 'home':
            renderHomePage($twig, $app_user);
            break;

        case 'login':
            handleLoginRoute($authController, $app_user);
            break;

        case 'register':
            handleRegisterRoute($authController, $app_user);
            break;

        case 'profile':
            renderProfilePage($twig, $pdo, $app_user);
            break;

        case 'messages':
            handleMessagesRoute($messageController, $userModel, $app_user, $twig, $pdo);
            break;
            

        case 'about':
            renderAboutPage($twig, $app_user);
            break;

        case 'logout':
            handleLogout($userModel);
            break;

        case 'forgot_password':
            handleForgotPasswordRoute($authController);
            break;

        case 'handle_forgot_password':
            handleProcessForgotPassword($authController);
            break;

        case 'reset_password':
            handleResetPasswordRoute($authController);
            break;

        case 'handle_reset_password':
            handleProcessResetPassword($authController);
            break;

        case '404':
        default:
            render404Page($twig, $app_user);
            break;
    }
}
?>
