<?php

namespace App\Controllers\Admin;

use App\Configs\Database;
use App\Controllers\AdminController;
use App\Controllers\BaseController;
use App\Entity\Models\Permission;
use App\Entity\Models\User;

class Dashboard extends AdminController
{
    private $entityManager;
    public function __construct()
    {
        parent::__construct();
        $this->entityManager = Database::getInstance()->getEntityManager();
    }
    public function save($id = null)
    {
        echo $id;
        // YETKI KAYDET
        $permission = new Permission();
        $permission->setName('Super Admin');
        $permission->setPermissions("");
        $permission = $this->entityManager->getRepository(Permission::class)->save($permission);
        // KULLANICI KAYDET
        $user = new User();
        $user->setUserName('Ahmet Çelik');
        $user->setUserEmail('ahmetcelik@hiosis.com');
        $user->setUserPermission($permission->getId());
        $this->entityManager->getRepository(User::class)->save($user);
        print_r($user);
    }
    public function insertBatch()
    {
        $post = $_POST["data"];
        // BATCH INSERT
        if (!empty($post))  $this->entityManager->getRepository(Permission::class)->batchInsert($post,$this->entityManager);
    }

    public function updateBatch()
    {
        $post = $_POST["data"];
        // BATCH INSERT
        if (!empty($post)) $this->entityManager->getRepository(Permission::class)->batchupdate($post, "permissionid",$this->entityManager);
    }
}
