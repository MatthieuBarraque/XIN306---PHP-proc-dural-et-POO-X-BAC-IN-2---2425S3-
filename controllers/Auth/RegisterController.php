<?php

namespace controllers\Auth;

class RegisterController extends AuthBaseController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $error = $this->validateRegistration($username, $email, $password, $confirmPassword);

            if (!$error) {
                $result = $this->userModel->createUser($username, $email, $password);
                if ($result['success']) {
                    $this->handleSuccessfulRegistration($username, $email);
                } else {
                    $error = $result['message'];
                }
            }

            $this->renderRegisterForm($error);
        } else {
            $this->renderRegisterForm();
        }
    }

    private function validateRegistration($username, $email, $password, $confirmPassword) {
        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            return "Veuillez remplir tous les champs.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Veuillez fournir un email valide.";
        }
        if ($password !== $confirmPassword) {
            return "Les mots de passe ne correspondent pas.";
        }
        if (strlen($password) < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères.";
        }
        return null;
    }

    private function handleSuccessfulRegistration($username, $email) {
        $userId = $this->pdo->lastInsertId();
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash_hmac('sha256', $token, 'secret_key');

        $this->userModel->updateUserToken($email, $hashedToken);
        $this->userModel->loginUserSession(['id' => $userId, 'username' => $username]);

        setcookie('auth_token', $token, [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'secure' => false, // false en dev si pas de HTTPS
            'httponly' => true,
            'samesite' => 'Strict',
        ]);

        header('Location: ' . path('profile'));
        exit;
    }

    private function renderRegisterForm($error = null) {
        echo $this->twig->render('auth/register.html.twig', [
            'title' => 'Inscription - Livre d\'Or',
            'error' => $error,
            'currentRoute' => 'register',
            'includeNavbarAndFooter' => includeNavbarAndFooter('register'),
        ]);
    }
}
?>