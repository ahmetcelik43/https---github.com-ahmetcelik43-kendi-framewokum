<?php

namespace App\Entity\Repository;

abstract class BaseUserRepository extends BaseRepository
{
    public abstract function getAll();
   
}
