<?php

namespace App\Entity\Repository;

use App\Business\Database\Database;
use App\Business\Database\Doctrine;
use App\Business\Database\Eloquent;
use Illuminate\Database\Capsule\Manager as DB;

trait ParentRepository
{
    protected Database $database;

    public function __construct()
    {
        // orm select
        $this->initialize(new Doctrine());
    }

    function initialize(Database $database)
    {
        $this->database = $database;
        $this->database->init();
    }
}
