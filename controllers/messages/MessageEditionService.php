<?php
namespace controllers\messages;

use \models\Messages\MessageModel;

class MessageEditionService {
    private $messageModel;

    public function __construct(MessageModel $messageModel) {
        $this->messageModel = $messageModel;
    }

    public function editMessage(int $userId, int $messageId, string $newContent): bool {
        if (empty(trim($newContent))) {
            return false;
        }

        if ($this->messageModel->isUserMessageOwner($userId, $messageId)) {
            return $this->messageModel->editMessage($messageId, $newContent);
        }

        return false;
    }
}
?>