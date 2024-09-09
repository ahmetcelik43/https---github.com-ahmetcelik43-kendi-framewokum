<?php

namespace App\Entity\Migrations;

use App\Configs\Database;

class Version1725802966
{
    public function up()
    {
        $entityManager = Database::getInstance()->getEntityManager();
        $sql = '
        INSERT INTO permissions(permissionname,permissions) values(:name,:permissions);
         ';
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->bindValue("name", "Super Admin");
        $stmt->bindValue("permissions", "");
        $stmt->executeQuery();
        return true;
    }
}
