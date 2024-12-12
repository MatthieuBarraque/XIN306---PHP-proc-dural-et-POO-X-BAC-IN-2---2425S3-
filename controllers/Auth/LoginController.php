<?php

namespace Controllers\Auth;

class LoginController extends AuthBaseController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $error = $this->validateLogin($email, $password);

            if (!$error) {
                $user = $this->userModel->checkCredentials($email, $password);
                if ($user) {
                    $this->handleSuccessfulLogin($user, $email);
                } else {
                    $error = "Identifiants incorrects.";
                }
            }

            echo $this->twig->render('auth/login.html.twig', [
                'title' => 'Connexion - Livre d\'Or',
                'error' => $error,
                'currentRoute' => 'login',
                'includeNavbarAndFooter' => includeNavbarAndFooter('login'),
            ]);
        } else {
            $success = $_SESSION['success_message'] ?? null;
            unset($_SESSION['success_message']);

            echo $this->twig->render('auth/login.html.twig', [
                'title' => 'Connexion - Livre d\'Or',
                'success' => $success,
                'currentRoute' => 'login',
                'includeNavbarAndFooter' => includeNavbarAndFooter('login'),
            ]);
        }
    }

    private function validateLogin($email, $password) {
        if (empty($email) || empty($password)) {
            return "Veuillez remplir tous les champs.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Veuillez fournir une adresse e-mail valide.";
        }
        return null;
    }

    private function handleSuccessfulLogin($user, $email) {
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash_hmac('sha256', $token, getenv('SECRET_KEY'));

        $this->userModel->updateUserToken($email, $hashedToken);
        $this->userModel->loginUserSession($user);

        setcookie('auth_token', $token, [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);

        header('Location: ' . path('profile'));
        exit;
    }
}

?>