<?php
// core/routing/auth.php

/**
 * Gère les routes liées à l'authentification.
 *
 * @param string $currentRoute
 * @param \Controllers\AuthController $authController
 * @param array|null $app_user
 */
function handleAuthRoutes(string $currentRoute, $authController, $app_user): void {
    if ($app_user) {
        $_SESSION['temp_message'] = "Vous êtes déjà identifié.";
        header('Location: ' . path('profile'));
        exit;
    }

    if ($currentRoute === 'login') {
        $authController->login();
    } else {
        $authController->register();
    }
    exit;
}

function handleLoginRoute($authController, $app_user): void {
    if ($app_user) {
        $_SESSION['temp_message'] = "You are already logged in.";
        header('Location: ' . path('profile'));
        exit;
    }
    $authController->login();
}

function handleRegisterRoute($authController, $app_user): void {
    if ($app_user) {
        $_SESSION['temp_message'] = "You are already registered.";
        header('Location: ' . path('profile'));
        exit;
    }
    $authController->register();
}

function handleForgotPasswordRoute($authController): void {
    $authController->showForgotPasswordForm();
}

function handleProcessForgotPassword($authController): void {
    $authController->handleForgotPassword();
}

function handleResetPasswordRoute($authController): void {
    $authController->showResetPasswordForm();
}

function handleProcessResetPassword($authController): void {
    $authController->handleResetPassword();
}

?>