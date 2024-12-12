<?php 

/**
 * Gère la déconnexion de l'utilisateur.
 */
function handleLogout($userModel): void {
    if (isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];
        $hashedToken = hash_hmac('sha256', $token, getenv('SECRET_KEY'));
        $userModel->updateUserTokenByToken($hashedToken, null);
        setcookie('auth_token', '', time() - 3600, '/', '', false, true);
    }
    $_SESSION = [];
    if (session_id() !== "" || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    session_destroy();
    header('Location: ' . path('home'));
    exit;
}

?>