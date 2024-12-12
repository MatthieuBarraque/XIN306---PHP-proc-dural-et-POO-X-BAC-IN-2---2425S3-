<?php
namespace controllers\Auth;

use models\users\UserModel;

class AuthBaseController {
    protected $pdo;
    protected $twig;
    protected $userModel;

    public function __construct($pdo, $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;
        $this->userModel = new UserModel($pdo);
    }
}

?>