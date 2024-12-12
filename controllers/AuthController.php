<?php

namespace controllers;

use controllers\Auth\RegisterController;
use controllers\Auth\LoginController;
use controllers\Auth\PasswordResetController;
use controllers\Auth\SessionController;

class AuthController {
    private $registerController;
    private $loginController;
    private $passwordResetController;
    private $sessionController;

    public function __construct($pdo, $twig) {
        $this->registerController = new RegisterController($pdo, $twig);
        $this->loginController = new LoginController($pdo, $twig);
        $this->passwordResetController = new PasswordResetController($pdo, $twig);
        $this->sessionController = new SessionController($pdo, $twig);
    }

    public function register() {
        $this->registerController->register();
    }

    public function login() {
        $this->loginController->login();
    }

    public function showForgotPasswordForm() {
        $this->passwordResetController->showForgotPasswordForm();
    }

    public function handleForgotPassword() {
        $this->passwordResetController->handleForgotPassword();
    }

    public function showResetPasswordForm() {
        $this->passwordResetController->showResetPasswordForm();
    }

    public function handleResetPassword() {
        $this->passwordResetController->handleResetPassword();
    }

    public function logoutUserSession() {
        $this->sessionController->logoutUserSession();
    }
}

?>