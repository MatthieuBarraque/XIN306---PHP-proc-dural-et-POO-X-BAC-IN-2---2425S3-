<?php
namespace models\messages;

class MessageOwnership {
    public static function isUserMessageOwner($pdo, $userId, $messageId) {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM messages 
            WHERE id = :id AND user_id = :user_id
        ");
        $stmt->execute([':id' => $messageId, ':user_id' => $userId]);
        return $stmt->fetchColumn() > 0;
    }
}

?>