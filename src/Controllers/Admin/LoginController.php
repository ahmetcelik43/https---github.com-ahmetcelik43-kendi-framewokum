<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Configs\Session;

class LoginController extends BaseController
{
    public function login()
    {
        Session::init();
        $adminSessionName = config('Settings', 'adminSessionName');
        $_SESSION[$adminSessionName]['username'] = 'admin';
        $_SESSION[$adminSessionName]['role'] = 'super-admin';
        $_SESSION[$adminSessionName]['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION[$adminSessionName]['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        session_regenerate_id(true);
        echo 'panel';
    }
    public function logout() {
        session_destroy();
    }
}
