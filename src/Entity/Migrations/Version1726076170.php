<?php

namespace App\Entity\Migrations;

use App\Business\Database\Eloquent;
use Illuminate\Database\Capsule\Manager;

class Version1726076170
{
    public function up()
    {
        new Eloquent();
        Manager::statement(
            "TRUNCATE members;"
        );
        return true;
    }
}
