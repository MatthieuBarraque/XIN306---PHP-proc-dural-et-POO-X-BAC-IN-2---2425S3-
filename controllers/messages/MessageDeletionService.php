<?php
namespace controllers\messages;

use models\Messages\MessageModel;

class MessageDeletionService {
    private $messageModel;

    public function __construct(MessageModel $messageModel) {
        $this->messageModel = $messageModel;
    }

    public function deleteMessage(int $userId, int $messageId): bool {
        if ($this->messageModel->isUserMessageOwner($userId, $messageId)) {
            return $this->messageModel->deleteMessage($messageId);
        }
        return false;
    }
}
?>