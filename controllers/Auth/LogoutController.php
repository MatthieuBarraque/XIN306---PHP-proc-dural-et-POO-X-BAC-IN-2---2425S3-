<?php

namespace Controllers\Auth;

class LogoutController extends AuthBaseController {
    public function logout() {
        $this->userModel->logoutUserSession();
        if (isset($_COOKIE['auth_token'])) {
            setcookie('auth_token', '', time() - 3600, '/', '', false, true);
        }
        header('Location: ' . path('home'));
        exit;
    }
}

?>