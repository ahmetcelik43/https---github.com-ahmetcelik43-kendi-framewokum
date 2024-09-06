<?php

namespace App\Entity\Repository;

use App\Entity\Models\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }

    public function getById(int $id)
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT p.*, u.* 
            FROM users u
            JOIN permissions p ON p.permissionid = u.userpermission where u.userid=:userid
        ';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue("userid", $id);
        return $stmt->executeQuery()->fetchAssociative();
    }

    public function delete(int $userid): void
    {
        $user = $this->getEntityManager()->find(User::class, $userid);

        if (!$user) {
            throw $this->createNotFoundException('Kullanıcı bulunamadı!');
        }
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
