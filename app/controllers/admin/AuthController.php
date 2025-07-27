<?php

namespace admin;

use Controller;

class AuthController extends Controller
{
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: index.php");
        exit();
    }
}
