<?php

namespace App\Controllers;

use App\Configs\Database;
use App\Entity\Models\User;
use App\Business\Cache\ICache;
use App\Entity\Repository\UserRepository;

class Home extends FrontController
{
    private ICache $cacheManager;
    private static $userService = null;

    public function __construct(ICache $cacheManager)
    {
        $this->cacheManager = $cacheManager;
        $this->userService = new UserRepository();
    }

    public function index()
    {
        /* $cacheKey = 'home-cache';
        if (!$this->cacheManager->isExpire($cacheKey)) {
            $user = $this->entityManager->getRepository(User::class)->getAll($this->entityManager);
            $cacheValue = viewData("Admin/Dashboard", $user);
            $this->cacheManager->getAndSave($cacheKey, $cacheValue);
            return finish($cacheValue);
        }
        return finish($this->cacheManager->get($cacheKey));*/

        $user = $this->userService->getAll();
        $cacheValue = viewData("Admin/Dashboard", $user);
        return finish($cacheValue);
    }
    public function delete($id = 123)
    {
        return finish(123);
    }
}
