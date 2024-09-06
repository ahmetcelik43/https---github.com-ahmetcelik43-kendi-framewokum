<?php

namespace App\Controllers;

use App\Configs\Database;

class BaseController
{
    // VIEW RENDER
    protected function view($path, $data)
    {
        include BASEPATH . "/src/Views/$path.php";
        header("content-type:text/html");
        exit();
    }
}
