<?php

namespace models\users;

class UserAuthentication {
    public static function updateUserToken($pdo, $email, $hashedToken) {
        $stmt = $pdo->prepare("UPDATE users SET auth_token = :token WHERE email = :email");
        return $stmt->execute([':token' => $hashedToken, ':email' => $email]);
    }

    public static function getUserByToken($pdo, $hashedToken) {
        $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE auth_token = :token LIMIT 1");
        $stmt->execute([':token' => $hashedToken]);
        return $stmt->fetch();
    }

    public static function updateUserTokenByToken($pdo, $hashedToken, $newToken) {
        $stmt = $pdo->prepare("UPDATE users SET auth_token = :newToken WHERE auth_token = :oldToken");
        return $stmt->execute([':newToken' => $newToken, ':oldToken' => $hashedToken]);
    }

    public static function checkCredentials($pdo, $email, $password) {
        $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}

?>