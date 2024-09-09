<?php

namespace App\Entity\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Version1725900121
{
    public function up()
    {
        $sql = "TRUNCATE TABLE permissions";
        return DB::statement($sql);
    }
}
