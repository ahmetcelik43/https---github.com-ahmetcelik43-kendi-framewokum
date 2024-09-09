<?php

namespace App\Entity\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Version1725915581
{
    public function up()
    {
        $sql = "DROP TABLE migrations";
        return DB::statement($sql);
    }
}
