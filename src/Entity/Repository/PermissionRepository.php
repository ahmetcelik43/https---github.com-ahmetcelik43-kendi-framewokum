<?php

namespace App\Entity\Repository;

use App\Entity\Models\Permission;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Entity\Repository\ParentRepository;

class PermissionRepository extends EntityRepository
{
    use ParentRepository;

    public function save(Permission $user): Permission
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }
    public function delete(int $roleid): void
    {
        $role = $this->getEntityManager()->find(Permission::class, $roleid);
        $this->getEntityManager()->remove($role);
        $this->getEntityManager()->flush();
    }
    public function batchInsert(array $post = array()): void
    {
        $this->insertBatch($post, $this->getEntityManager());
    }
    public function batchUpdate(array $post = array(), string $column): void
    {
        $this->updateBatch($post, $column, $this->getEntityManager());
    }
}
