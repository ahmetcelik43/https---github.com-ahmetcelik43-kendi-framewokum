<?php

namespace App\Entity\Migrations;
use Illuminate\Database\Capsule\Manager as DB;
class Version1725915480
{
    public function up()
    {
        $sql = "TRUNCATE TABLE users";
        return DB::statement($sql);
    }
}
