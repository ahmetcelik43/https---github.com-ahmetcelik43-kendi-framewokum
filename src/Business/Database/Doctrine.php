<?php

namespace App\Business\Database;

class Doctrine extends Database
{
    public function __construct()
    {
        $this->init();
    }
    function init()
    {
       echo 'doctrine';
    }
    function insertBatch(array $userbatch = array(), $tablename)
    {
       echo 'doctrine insert batch';
    }
}
