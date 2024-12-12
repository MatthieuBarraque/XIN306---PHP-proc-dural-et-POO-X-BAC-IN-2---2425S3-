<?php

namespace Controllers\Auth;

class SessionController extends AuthBaseController {
    public function logoutUserSession() {
        $this->userModel->logoutUserSession();

        if (isset($_COOKIE['auth_token'])) {
            setcookie('auth_token', '', time() - 3600, '/', '', false, true);
        }

        header('Location: ' . path('home'));
        exit;
    }
}

?>