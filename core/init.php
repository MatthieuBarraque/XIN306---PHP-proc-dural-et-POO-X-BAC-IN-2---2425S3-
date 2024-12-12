<?php

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = require __DIR__ . '/bootstrap/db.php';

$twig = require __DIR__ . '/bootstrap/twig.php';

require __DIR__ . '/bootstrap/auth.php';

require __DIR__ . '/bootstrap/helpers.php';

global $twig;

?>