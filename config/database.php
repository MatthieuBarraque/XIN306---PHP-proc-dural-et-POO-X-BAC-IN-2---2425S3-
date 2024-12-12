<?php

return [
    'dsn' => 'mysql:host=db;dbname=guestbook;charset=utf8mb4',
    'username' => 'guestbook_user',
    'password' => 'MotDePasseSécurisé!',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

?>
