<?php

namespace App\Entity\Migrations;
use App\Configs\Database;
use Doctrine\DBAL\Exception;
class Version1725808753
{
    public function up()
    {
        $entityManager = Database::getInstance()->getEntityManager();
        $conn = $entityManager->getConnection();
        try {
            $conn->beginTransaction();
            $sql = '
                TRUNCATE permissions;
                 ';
            $stmt = $conn->prepare($sql);
            $stmt->executeQuery();
            return true;
        } catch (\Exception $e) {
            $conn->rollBack();
            return false;
        }
    }
}
