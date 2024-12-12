<?php
namespace controllers;

use models\users\UserModel;
use models\messages\MessageModel;
use controllers\messages\MessageCreationService;
use controllers\messages\MessageEditionService;
use controllers\messages\MessageDeletionService;
use controllers\messages\MessageRetrievalService;

class MessageController {
    private $pdo;
    private $twig;
    private $userModel;
    private $messageModel;
    private $creationService;
    private $editionService;
    private $deletionService;
    private $retrievalService;

    public function __construct($pdo, $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;

        $this->userModel = new UserModel($pdo);
        $this->messageModel = new MessageModel($pdo);

        $this->creationService = new MessageCreationService($this->messageModel);
        $this->editionService = new MessageEditionService($this->messageModel);
        $this->deletionService = new MessageDeletionService($this->messageModel);
        $this->retrievalService = new MessageRetrievalService($this->messageModel);
    }

    public function handleMessages($app_user) {
        $error = null;
        $success = null;
        if (is_null($app_user)) {
            header('Location: ' . path('login'));
            exit;
        }

        $userId = $app_user['id'];
        $username = $app_user['username'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;
            $messageContent = $_POST['message'] ?? '';
            $messageId = isset($_POST['message_id']) ? (int)$_POST['message_id'] : null;

            switch ($action) {
                case 'add':
                    $addSuccess = $this->creationService->createMessage($userId, $messageContent);
                    if ($addSuccess) {
                        $_SESSION['success_message'] = "Message ajouté avec succès.";
                        header('Location: ' . path('messages'));
                        exit;
                    } else {
                        $error = "Erreur lors de l'ajout du message (message vide ou problème).";
                    }
                    break;

                case 'edit':
                    if ($messageId !== null) {
                        $editSuccess = $this->editionService->editMessage($userId, $messageId, $messageContent);
                        if ($editSuccess) {
                            $_SESSION['success_message'] = "Message modifié avec succès.";
                            header('Location: ' . path('messages'));
                            exit;
                        } else {
                            $error = "Erreur lors de la modification du message.";
                        }
                    } else {
                        $error = "ID de message invalide pour l'édition.";
                    }
                    break;

                case 'delete':
                    if ($messageId !== null) {
                        $deleteSuccess = $this->deletionService->deleteMessage($userId, $messageId);
                        if ($deleteSuccess) {
                            $_SESSION['success_message'] = "Message supprimé avec succès.";
                            header('Location: ' . path('messages'));
                            exit;
                        } else {
                            $error = "Erreur lors de la suppression du message.";
                        }
                    } else {
                        $error = "ID de message invalide pour la suppression.";
                    }
                    break;
            }
        }

        $messages = $this->retrievalService->getAllMessages();
        if (isset($_SESSION['success_message'])) {
            $success = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        if (isset($_SESSION['error_message'])) {
            $error = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        echo $this->twig->render('messages/messages.html.twig', [
            'title' => 'Messages - Livre d\'Or',
            'currentRoute' => 'messages',
            'includeNavbarAndFooter' => includeNavbarAndFooter('messages'),
            'messages' => $messages,
            'error' => $error,
            'success' => $success,
            'app_user' => $app_user
        ]);
    }
}

?>