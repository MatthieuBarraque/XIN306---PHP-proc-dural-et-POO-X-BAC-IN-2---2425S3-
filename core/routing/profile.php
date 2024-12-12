<?php
// core/routing/profile.php

/**
 * Rend la page de profil.
 *
 * @param Twig\Environment $twig
 * @param PDO $pdo
 * @param array|null $app_user
 */
function renderProfilePage($twig, $pdo, $app_user): void {
    if ($app_user) {
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $app_user['id']]);
        $user = $stmt->fetch();

        $tempMessage = $_SESSION['temp_message'] ?? null;
        unset($_SESSION['temp_message']); // Supprimer le message temporaire après affichage

        echo $twig->render('profile/profile.html.twig', [
            'title' => 'Mon Profil',
            'currentRoute' => 'profile',
            'includeNavbarAndFooter' => includeNavbarAndFooter('profile'),
            'username' => $app_user['username'],
            'email' => $user['email'] ?? '',
            'app_user' => $app_user,
            'temp_message' => $tempMessage,
        ]);
    } else {
        header('Location: ' . path('login'));
    }
    exit;
}

?>