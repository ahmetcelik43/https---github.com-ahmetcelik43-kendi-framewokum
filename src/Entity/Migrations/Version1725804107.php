<?php

namespace App\Entity\Migrations;

use App\Configs\Database;
use Doctrine\DBAL\Exception;

class Version1725804107
{
    public function up()
    {
        $entityManager = Database::getInstance()->getEntityManager();
        $conn = $entityManager->getConnection();
        try {
            $conn->beginTransaction();
            $sql = '
        TR permissionss(permissionname,permissions) values(:name,:permissions);
         ';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("name", "Super Admin");
            $stmt->bindValue("permissions", "");
            $stmt->executeQuery();
            return true;
        } catch (\Exception $e) {
            $conn->rollBack();
            return false;
        }
    }
}
