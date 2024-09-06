<?php

namespace App\Controllers;

class AdminController extends BaseController
{

    public function __construct()
    {
       //Helpers
       include_once BASEPATH . "/src/Helpers/Admin/Dashboard.php";
    }
}
