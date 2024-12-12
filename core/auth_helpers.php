<?php
function getAppUser(): ?array
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
        ];
    }
    return null;
}

?>