<?php

namespace models\users;

class UserSession {
    public static function loginUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }

    public static function logoutUserSession() {
        $_SESSION = [];
        if (session_id() !== "" || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();
    }
}

?>