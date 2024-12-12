<?php

function handleMessagesRoute($messageController, $userModel, $app_user, $twig, $pdo) {
    // Vérifie si l'utilisateur est connecté via la session (donc $app_user)
    if (is_null($app_user)) {
        header('Location: ' . path('login'));
        exit;
    }

    // L'utilisateur est connecté, on appelle le contrôleur
    $messageController->handleMessages($app_user);
}

?>