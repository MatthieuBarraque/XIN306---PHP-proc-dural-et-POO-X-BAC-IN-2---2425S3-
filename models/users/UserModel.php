<?php
namespace models\users;

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function updateUserToken($email, $hashedToken) {
        return UserAuthentication::updateUserToken($this->pdo, $email, $hashedToken);
    }

    public function getUserByToken($hashedToken) {
        return UserAuthentication::getUserByToken($this->pdo, $hashedToken);
    }

    public function updateUserTokenByToken($hashedToken, $newToken) {
        return UserAuthentication::updateUserTokenByToken($this->pdo, $hashedToken, $newToken);
    }

    public function checkCredentials($email, $password) {
        return UserAuthentication::checkCredentials($this->pdo, $email, $password);
    }

    public function createUser($username, $email, $password) {
        return UserCRUD::createUser($this->pdo, $username, $email, $password);
    }

    public function createPasswordResetToken($userId, $token, $expiresAt) {
        return UserPasswordReset::createPasswordResetToken($this->pdo, $userId, $token, $expiresAt);
    }

    public function getUserByPasswordResetToken($token) {
        return UserPasswordReset::getUserByPasswordResetToken($this->pdo, $token);
    }

    public function invalidatePasswordResetToken($token) {
        return UserPasswordReset::invalidatePasswordResetToken($this->pdo, $token);
    }

    public function updateUserPassword($userId, $newPassword) {
        return UserPasswordReset::updateUserPassword($this->pdo, $userId, $newPassword);
    }

    public function loginUserSession($user) {
        UserSession::loginUserSession($user);
    }

    public function logoutUserSession() {
        UserSession::logoutUserSession();
    }
}

?>