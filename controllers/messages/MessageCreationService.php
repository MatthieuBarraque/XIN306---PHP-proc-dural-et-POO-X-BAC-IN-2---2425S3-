<?php
namespace controllers\messages;

use models\Messages\MessageModel;

class MessageCreationService {
    private $messageModel;

    public function __construct(MessageModel $messageModel) {
        $this->messageModel = $messageModel;
    }

    public function createMessage(int $userId, string $content): bool {
        if (empty(trim($content))) {
            return false;
        }
        return $this->messageModel->addMessage($userId, $content);
    }
}
?>