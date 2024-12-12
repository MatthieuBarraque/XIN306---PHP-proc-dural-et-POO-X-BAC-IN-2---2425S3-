<?php
namespace models\messages;

class MessageCRUD {
    public static function addMessage($pdo, $userId, $content) {
        $sanitizedContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        $stmt = $pdo->prepare("
            INSERT INTO messages (user_id, content, created_at, updated_at)
            VALUES (:user_id, :content, NOW(), NOW())
        ");
        return $stmt->execute([':user_id' => $userId, ':content' => $sanitizedContent]);
    }

    public static function editMessage($pdo, $messageId, $content) {
        $sanitizedContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        $stmt = $pdo->prepare("
            UPDATE messages 
            SET content = :content, updated_at = NOW() 
            WHERE id = :id
        ");
        return $stmt->execute([':content' => $sanitizedContent, ':id' => $messageId]);
    }

    public static function deleteMessage($pdo, $messageId) {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
        return $stmt->execute([':id' => $messageId]);
    }
}

?>