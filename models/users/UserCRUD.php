<?php

namespace models\users;

class UserCRUD {
    public static function createUser($pdo, $username, $email, $password) {
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username LIMIT 1");
        $checkStmt->execute([':email' => $email, ':username' => $username]);

        if ($checkStmt->fetch()) {
            return ['success' => false, 'message' => 'Cet utilisateur existe déjà.'];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())");

        if ($stmt->execute([':username' => $username, ':email' => $email, ':password' => $hashedPassword])) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Une erreur est survenue lors de l\'insertion.'];
    }
}

?>