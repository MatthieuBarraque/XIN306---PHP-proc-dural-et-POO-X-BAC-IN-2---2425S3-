<?php
namespace models\messages;

class MessageModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addMessage($userId, $content) {
        return MessageCRUD::addMessage($this->pdo, $userId, $content);
    }

    public function editMessage($messageId, $content) {
        return MessageCRUD::editMessage($this->pdo, $messageId, $content);
    }

    public function deleteMessage($messageId) {
        return MessageCRUD::deleteMessage($this->pdo, $messageId);
    }

    public function isUserMessageOwner($userId, $messageId) {
        return MessageOwnership::isUserMessageOwner($this->pdo, $userId, $messageId);
    }

    public function getMessageById($messageId) {
        return MessageRetrieval::getMessageById($this->pdo, $messageId);
    }

    public function getAllMessages() {
        return MessageRetrieval::getAllMessages($this->pdo);
    }
}

?>