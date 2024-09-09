<?php

namespace App\Entity\Repository;

use App\Entity\Models\Permission;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Entity\Repository\ParentRepository;

class PermissionRepository extends EntityRepository
{
    use ParentRepository;
    private $tablename = "permissions";

    public function save(Permission $user, $entityManager = null): Permission
    {
        if (!$entityManager) {
            $entityManager = $this->getEntityManager();
        }
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }
    public function delete(int $roleid, $entityManager = null): void
    {
        if (!$entityManager) {
            $entityManager = $this->getEntityManager();
        }
        $role = $this->getEntityManager()->find(Permission::class, $roleid);
        $this->getEntityManager()->remove($role);
        $this->getEntityManager()->flush();
    }
    public function batchInsert(array $post = array(), $entityManager = null): void
    {
        if (!$entityManager) {
            $entityManager = $this->getEntityManager();
        }
        $this->insertBatch($post, $this->tablename, $entityManager);
    }
    public function batchUpdate(array $post = array(), string $column, $entityManager = null): void
    {
        if (!$entityManager) {
            $entityManager = $this->getEntityManager();
        }
        $this->updateBatch($post, $column, $this->tablename, $entityManager);
    }
}
