<?php

namespace App\Entity\Repository;

abstract class BaseRepository
{
    public function __construct()
    {
        $orm = config('Settings', 'orm');
        (new $orm());
    }
}
