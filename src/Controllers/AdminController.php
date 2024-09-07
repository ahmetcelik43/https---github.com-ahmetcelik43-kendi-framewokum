<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    protected $generalData;
    public function __construct()
    {
        //Helpers
        include_once BASEPATH . "/src/Helpers/Admin/AdminHelper.php";
        $this->generalData["settings"] = config("Settings");
    }
}
