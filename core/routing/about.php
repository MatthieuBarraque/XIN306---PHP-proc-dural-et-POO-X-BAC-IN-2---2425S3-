<?php

/**
 * Rend la page "À propos".
 */
function renderAboutPage($twig, $app_user): void {
    echo $twig->render('about/about.html.twig', [
        'title' => 'À propos - Livre d\'Or',
        'currentRoute' => 'about',
        'includeNavbarAndFooter' => includeNavbarAndFooter('about'),
        'app_user' => $app_user,
    ]);
    exit;
}

?>