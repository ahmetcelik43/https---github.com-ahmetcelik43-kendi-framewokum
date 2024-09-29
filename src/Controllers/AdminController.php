<?php

namespace App\Controllers;

use App\Business\Middlewares\AdminLoginMiddleware;

class AdminController extends BaseController
{
    protected array $generalData;
    public function __construct()
    {
        //AdminLoginMiddleware::before();
        $this->generalData["settings"] = config("Settings");
    }
}
