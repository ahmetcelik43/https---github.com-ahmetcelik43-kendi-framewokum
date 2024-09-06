<?php

namespace App\Controllers;

use App\Configs\Database;
use App\Controllers\BaseController;
use App\Entity\Models\Permission;
use App\Entity\Models\User;

class Home extends AdminController
{
    use Database;
    
    public function index()
    {
        /*$user = new User();
        $user->setName('John Doe');
        $user->setEmail('john.doe@example.com');
        $this->entityManager->getRepository(User::class)->save($user);*/
        //$this->con->close();
        $user = $this->entityManager->getRepository(User::class)->getById(1);
        return $this->view("Admin/Dashboard",$user);

        //$this->entityManager->getRepository(Permission::class)->delete(1);
    }
  
}
