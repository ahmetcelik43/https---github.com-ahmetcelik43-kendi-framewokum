<?php

namespace App\Entity\Repository;

use App\Configs\Database;
use App\Entity\Models\User;

class UserRepository extends ParentRepository
{

    public function __construct()
    {
       parent::__construct();
    }

    public static function getAll()
    {
        return User::with(["permission"])->get()->toArray();
    }

 
}
