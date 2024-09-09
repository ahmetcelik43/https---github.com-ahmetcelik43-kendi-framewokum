<?php

namespace App\Entity\Repository;

use App\Configs\Database;
use App\Entity\Models\User;
//use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private $connection = null;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    

    /* public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }*/

    public function getById(int $id)
    {
        $sql = '
            SELECT p.*, u.* 
            FROM users u
            JOIN permissions p ON p.permissionid = u.userpermission where u.userid=:userid
        ';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("userid", $id);
        return $stmt->executeQuery()->fetchAssociative();
    }
    public function getAll()
    {
        $sql = '
            SELECT p.*, u.* 
            FROM users u
            JOIN permissions p ON p.permissionid = u.userpermission
        ';
        $stmt = $this->connection->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }
    /*
    public function delete(int $userid): void
    {
        $user = $this->getEntityManager()->find(User::class, $userid);

        if (!$user) {
            throw $this->createNotFoundException('Kullanıcı bulunamadı!');
        }
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }*/
}
