<?php

namespace App\Controllers\Admin;

use App\Configs\Database;
use App\Controllers\AdminController;
use App\Controllers\BaseController;
use App\Entity\Models\Permission;
use App\Entity\Models\User;
use App\Entity\Repository\PermissionRepository;
use App\Entity\Repository\UserRepository;

class Dashboard extends AdminController
{
    private $permissionService = null;
    private $userService = null;
    public function __construct()
    {
        parent::__construct();
        $this->permissionService = new PermissionRepository();
        $this->userService = new UserRepository();
    }
    public function save($id = null)
    {
        // YETKI KAYDET
        $permission = new Permission();
        $permission->setName('Super Admin');
        $permission->setPermissions("");
        $permission = $this->permissionService->save($permission);
        // KULLANICI KAYDET
        $user = new User();
        $user->setUserName('Ahmet Çelik');
        $user->setUserEmail('ahmetcelik@hiosis.com');
        $user->setUserPermission($permission->getId());
        $this->userService->save($user);
        print_r($user);
    }
    public function insertBatch()
    {
        $post = $_POST["data"];
        // BATCH INSERT
        if (!empty($post))  $this->permissionService->batchInsert($post);
    }

    public function updateBatch()
    {
        $post = $_POST["data"];
        // BATCH INSERT
        if (!empty($post)) $this->permissionService->batchupdate($post, "permissionid");
    }
}
