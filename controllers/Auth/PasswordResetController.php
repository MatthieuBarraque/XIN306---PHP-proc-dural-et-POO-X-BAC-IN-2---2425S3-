<?php

namespace Controllers\Auth;

class PasswordResetController extends AuthBaseController {
    public function showForgotPasswordForm() {
        echo $this->twig->render('auth/forgot_password.html.twig', [
            'title' => 'Mot de passe oublié - Livre d\'Or',
            'currentRoute' => 'forgot_password',
            'includeNavbarAndFooter' => includeNavbarAndFooter('forgot_password'),
        ]);
    }
    public function handleForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Veuillez fournir une adresse e-mail valide.";
                echo $this->twig->render('auth/forgot_password.html.twig', [
                    'title' => 'Mot de passe oublié - Livre d\'Or',
                    'error' => $error,
                    'currentRoute' => 'forgot_password',
                    'includeNavbarAndFooter' => includeNavbarAndFooter('forgot_password')
                ]);
                return;
            }
    
            $stmt = $this->pdo->prepare("SELECT id, username, email FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
    
            if ($user) {
                $token = bin2hex(random_bytes(50));
                $expiresAt = date("Y-m-d H:i:s", strtotime('+1 hour'));
                $this->userModel->createPasswordResetToken($user['id'], $token, $expiresAt);
                    header('Location: ' . path('reset_password') . '?token=' . $token . '&user_id=' . $user['id']);
                exit;
            } else {
                $error = "Aucun utilisateur trouvé avec cette adresse e-mail.";
                echo $this->twig->render('auth/forgot_password.html.twig', [
                    'title' => 'Mot de passe oublié - Livre d\'Or',
                    'error' => $error,
                    'currentRoute' => 'forgot_password',
                    'includeNavbarAndFooter' => includeNavbarAndFooter('forgot_password')
                ]);
            }
        } else {
            header('Location: ' . path('forgot_password'));
            exit;
        }
    }

    private function renderForgotPasswordForm($error) {
        echo $this->twig->render('auth/forgot_password.html.twig', [
            'title' => 'Mot de passe oublié - Livre d\'Or',
            'error' => $error,
            'currentRoute' => 'forgot_password',
            'includeNavbarAndFooter' => includeNavbarAndFooter('forgot_password'),
        ]);
    }

    public function showResetPasswordForm() {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $this->renderResetPasswordForm("Token invalide.");
            return;
        }

        $user = $this->userModel->getUserByPasswordResetToken($token);

        if ($user) {
            echo $this->twig->render('auth/reset_password.html.twig', [
                'title' => 'Réinitialiser le mot de passe - Livre d\'Or',
                'token' => $token,
                'user_id' => $user['id'],
                'currentRoute' => 'reset_password',
                'includeNavbarAndFooter' => includeNavbarAndFooter('reset_password'),
            ]);
        } else {
            $this->renderResetPasswordForm("Token invalide ou expiré.");
        }
    }

    public function handleResetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $userId = $_POST['user_id'] ?? '';
            $newPassword = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $error = $this->validatePasswordReset($token, $userId, $newPassword, $confirmPassword);

            if (!$error) {
                $user = $this->userModel->getUserByPasswordResetToken($token);
                if ($user && $user['id'] == $userId) {
                    $this->userModel->updateUserPassword($userId, $newPassword);
                    $this->userModel->invalidatePasswordResetToken($token);

                    $_SESSION['success_message'] = "Votre mot de passe a été réinitialisé avec succès.";
                    header('Location: ' . path('login'));
                    exit;
                } else {
                    $this->renderResetPasswordForm("Token invalide ou expiré.");
                }
            } else {
                $this->renderResetPasswordForm($error);
            }
        }
    }

    private function validatePasswordReset($token, $userId, $newPassword, $confirmPassword) {
        if (empty($token) || empty($userId)) {
            return "Token invalide.";
        }
        if ($newPassword !== $confirmPassword) {
            return "Les mots de passe ne correspondent pas.";
        }
        if (strlen($newPassword) < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères.";
        }
        return null;
    }

    private function renderResetPasswordForm($error) {
        echo $this->twig->render('auth/reset_password.html.twig', [
            'title' => 'Réinitialiser le mot de passe - Livre d\'Or',
            'error' => $error,
            'currentRoute' => 'reset_password',
            'includeNavbarAndFooter' => includeNavbarAndFooter('reset_password'),
        ]);
    }
}

?>