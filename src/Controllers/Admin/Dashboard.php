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
    public function __construct()
    {
        parent::__construct();
    }
    public function save($id = null)
    {
        // YETKI KAYDET
        $permissionData = $_POST["permission"];
        $permission = new Permission();
        $permission->fill($permissionData);
        $permission = PermissionRepository::save($permission, $id);
        // KULLANICI KAYDET
        $userData = $_POST["user"];
        $userData['userpermission'] = $permission->permissionid;
        $user = new User();
        $user->fill($userData);
        UserRepository::save($user, $id);
        print_r($user);
    }
    public function insertBatch()
    {
        $post = $_POST["data"];
        // BATCH INSERT
        if (!empty($post)) (new PermissionRepository())->insertBatch($post, 'permissions');
    }

    public function updateBatch()
    {
        $post = $_POST["data"];
        // BATCH INSERT
        if (!empty($post)) (new PermissionRepository())->updateBatch($post, "permissionid", 'permissions');
    }
}
