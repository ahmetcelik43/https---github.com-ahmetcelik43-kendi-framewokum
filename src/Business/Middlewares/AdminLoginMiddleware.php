<?php

namespace App\Business\Middlewares;

use App\Business\Middlewares;
use App\Configs\Session;

class AdminLoginMiddleware extends Middlewares
{
    public function before() : bool
    {
        Session::init();
        $adminSessionName = config('Settings', 'adminSessionName');
        $session = $_SESSION[$adminSessionName];
        if ($session['user_ip'] !== $_SERVER['REMOTE_ADDR'] || $session['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            session_destroy();
            return false;
        }
        return isset($session);
    }
    public function after() {}
}
