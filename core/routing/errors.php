<?php


/**
 * Rend la page 404.
 */
function render404Page($twig, $app_user): void {
    http_response_code(404);
    echo $twig->render('404.html.twig', [
        'title' => '404 - Page introuvable',
        'currentRoute' => '404',
        'includeNavbarAndFooter' => includeNavbarAndFooter('404'),
        'app_user' => $app_user,
    ]);
    exit;
}

?>