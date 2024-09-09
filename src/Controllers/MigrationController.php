<?php

namespace App\Controllers;

use App\Configs\Database;
use App\Entity\Models\User;
use App\Business\Cache\ICache;
use App\Configs\Migrations;

class MigrationController extends BaseController
{

    public function create()
    {
        echo Migrations::create();
    }
 
}
