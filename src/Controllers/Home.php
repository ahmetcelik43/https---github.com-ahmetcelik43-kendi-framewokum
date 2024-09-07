<?php

namespace App\Controllers;

use App\Configs\Database;
use App\Entity\Models\Permission;
use App\Entity\Models\User;
use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;

class Home extends AdminController
{
    private $cacheManager;
    private $entityManager;

    public function __construct(ICache $cacheManager)
    {
        $this->entityManager = (new Database())->get();
        $this->cacheManager = $cacheManager;
    }

    public function index()
    {
        $cacheKey = 'home-cache';
        if (!$this->cacheManager->isExpire($cacheKey)) {
            $user = $this->entityManager->getRepository(User::class)->getAll();
            $cacheValue = viewData("Admin/Dashboard", $user);
            $this->cacheManager->getAndSave($cacheKey, $cacheValue);
            echo $cacheValue;
            exit();
        }
        echo $this->cacheManager->get($cacheKey);
    }
}
