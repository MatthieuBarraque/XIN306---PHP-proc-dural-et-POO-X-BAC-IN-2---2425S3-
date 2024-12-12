<?php
namespace controllers\messages;

use models\Messages\MessageModel;

class MessageRetrievalService {
    private $messageModel;

    public function __construct(MessageModel $messageModel) {
        $this->messageModel = $messageModel;
    }

    public function getAllMessages() {
        return $this->messageModel->getAllMessages();
    }
}
?>