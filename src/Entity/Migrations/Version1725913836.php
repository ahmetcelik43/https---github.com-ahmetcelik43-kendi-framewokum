<?php

namespace App\Entity\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Version1725913836
{
    public function up()
    {
        $sql = "TRUNCATE TABLE users";
        return DB::statement($sql);
    }
}
