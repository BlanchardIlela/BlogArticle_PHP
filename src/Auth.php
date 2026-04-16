<?php
namespace App;

use App\Security\ForbiddenExcept;

class Auth {

    public static function check ()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['auth'])) {
            throw new ForbiddenExcept();
        }
    }

}