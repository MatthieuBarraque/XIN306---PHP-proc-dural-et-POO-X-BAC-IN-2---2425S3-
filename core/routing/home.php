<?php
// core/routing/home.php

/**
 * Rend la page d'accueil.
 *
 * @param Twig\Environment $twig
 * @param array|null $app_user
 */
function renderHomePage($twig, $app_user): void {
    $slides = [
        [
            'image' => '/images/image.png',
            'icon' => 'fas fa-shield-alt',
            'title' => 'Un projet PHP captivant',
            'description' => "Plongez dans le développement d'un livre d'or interactif (Guestbook) en PHP procédural.",
        ],
        [
            'image' => '/images/image.png',
            'icon' => 'fas fa-user-friends',
            'title' => 'Connexion et Déconnexion simplifiées',
            'description' => "Offrez à vos utilisateurs la possibilité de créer un compte avec un nom d'utilisateur unique et un mot de passe sécurisé.",
        ],
        [
            'image' => '/images/image.png',
            'icon' => 'fas fa-clock',
            'title' => 'Un affichage des messages soigné',
            'description' => "Donnez vie à votre livre d'or en permettant aux utilisateurs connectés de partager leurs messages.",
        ],
    ];

    echo $twig->render('home/home.html.twig', [
        'title' => 'Accueil - Livre d\'Or',
        'currentRoute' => 'home',
        'includeNavbarAndFooter' => includeNavbarAndFooter('home'),
        'slides' => $slides,
        'app_user' => $app_user,
    ]);
    exit;
}
?>