<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../../views');
$twig = new Environment($loader, [
    'cache' => false,
    'debug' => true,
]);

$twig->addFunction(new \Twig\TwigFunction('path', 'path'));

return $twig;

?>