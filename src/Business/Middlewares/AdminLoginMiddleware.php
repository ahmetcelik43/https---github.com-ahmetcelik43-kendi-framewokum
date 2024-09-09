<?php

namespace App\Business\Middlewares;

use App\Business\Middlewares;

class AdminLoginMiddleware extends Middlewares
{
    public function before()
    {
        session_start();
        $adminSessionName = config('Settings', 'adminSessionName');
        return isset($_SESSION[$adminSessionName]);
    }
    public function after() {}
}
