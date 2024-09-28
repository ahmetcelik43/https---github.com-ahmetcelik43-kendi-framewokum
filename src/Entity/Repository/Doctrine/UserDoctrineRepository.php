<?php

namespace App\Entity\Repository\Doctrine;

use App\Entity\Repository\BaseUserRepository;

class UserDoctrineRepository extends BaseUserRepository
{
    public function getAll()
    {
        echo "get all doctrine";
    }
}
