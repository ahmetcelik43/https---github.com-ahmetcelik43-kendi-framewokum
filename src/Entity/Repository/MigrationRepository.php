<?php

namespace App\Entity\Repository;

use App\Entity\Models\Migrations;

class MigrationRepository extends ParentRepository
{

    public function __construct()
    {
       parent::__construct();
    }

    public static function get($filenames)
    {
        return Migrations::select("version")->whereIn("version", $filenames)->get();
    }

 
}
