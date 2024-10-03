<?php

namespace App\Controllers;

use App\Configs\MigrationConfig;

class MigrationController extends BaseController
{
    public function create()
    {
        echo MigrationConfig::create();
    }
 
}
