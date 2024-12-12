<?php
namespace models\messages;

class MessageRetrieval {
    public static function getMessageById($pdo, $messageId) {
        $stmt = $pdo->prepare("
            SELECT messages.id, messages.content, messages.created_at, messages.updated_at, users.username, users.id as user_id
            FROM messages
            JOIN users ON messages.user_id = users.id
            WHERE messages.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $messageId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function getAllMessages($pdo) {
        $stmt = $pdo->prepare("
            SELECT messages.id, messages.content, messages.created_at, messages.updated_at, users.username, users.id AS user_id
            FROM messages
            JOIN users ON messages.user_id = users.id
            ORDER BY messages.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>