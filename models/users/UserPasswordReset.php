<?php

namespace models\users;

class UserPasswordReset {
    public static function createPasswordResetToken($pdo, $userId, $token, $expiresAt) {
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)");
        return $stmt->execute([':user_id' => $userId, ':token' => $token, ':expires_at' => $expiresAt]);
    }

    public static function getUserByPasswordResetToken($pdo, $token) {
        $stmt = $pdo->prepare("
            SELECT users.id, users.username, users.email 
            FROM users 
            JOIN password_resets ON users.id = password_resets.user_id 
            WHERE password_resets.token = :token AND password_resets.expires_at > NOW() 
            LIMIT 1
        ");
        $stmt->execute([':token' => $token]);
        return $stmt->fetch();
    }

    public static function invalidatePasswordResetToken($pdo, $token) {
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = :token");
        return $stmt->execute([':token' => $token]);
    }

    public static function updateUserPassword($pdo, $userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        return $stmt->execute([':password' => $hashedPassword, ':id' => $userId]);
    }
}

?>