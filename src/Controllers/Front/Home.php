<?php

namespace App\Controllers\Front;

use App\Business\Cache\FileSystemCache;
use App\Business\Cache\ICache;
use App\Business\Database\Database;
use App\Business\ServiceContainer;
use App\Controllers\FrontController;
use App\Entity\Repository\BaseUserRepository;
use App\Entity\Repository\UserRepository;

class Home extends FrontController
{
    private ICache $cacheManager;
    private BaseUserRepository $userService;

    public function __construct(ICache $cacheManager, BaseUserRepository $userService)
    {
        parent::__construct();
        $this->cacheManager =  $cacheManager;
        $this->userService =  $userService;
    }

    public function index()
    {
        /*$cacheKey = 'home-cache';
        if (!$this->cacheManager->isExpire($cacheKey)) {
            $user = UserRepository::getAll();
            $cacheValue = viewData("Admin/Dashboard", $user);
            $this->cacheManager->getAndSave($cacheKey, $cacheValue);
            return finish($cacheValue);
        }
        return finish($this->cacheManager->get($cacheKey));
        */
        //var_dump(baseurl("image"));die();
        //print_r($this->orm->init());
        $user = $this->userService->getAll();
        $cacheValue = viewData("Admin/Dashboard", $user);
        return finish($cacheValue);


        //$cacheValue = viewData("Admin/Dashboard", $user);
        //debug($user);

        $post = array(
            array("permissionid" => 1, "permissionname" => "Super Admin", "permissions" => "permission"),
            array("permissionid" => 2, "permissionname" => "Admin", "permissions" => "permission"),
            array("permissionid" => 3, "permissionname" => "Site Manager", "permissions" => "permission")
        );
        //debug($this->userService->insertBatch($post,"permissions"));

    }

    public function list()
    {
        echo 'ok';
    }
}
