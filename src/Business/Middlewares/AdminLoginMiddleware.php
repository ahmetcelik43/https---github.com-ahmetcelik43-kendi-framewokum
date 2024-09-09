<?php

namespace App\Business\Middlewares;

use App\Business\Middlewares;

class AdminLoginMiddleware extends Middlewares
{
    public function before()
    {
        session_start();
        $adminSessionName = config('Settings', 'adminSessionName');
        if (!isset($_SESSION[$adminSessionName])) {
            return false;
        }
        return true;
    }
    public function after() {}
}
