<?php
// src/Entity/User.php
namespace App\Entity\Models;

use App\Entity\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ORM\Table(name: 'permissions')]

class Permission
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]

    private $permissionid;


    #[ORM\Column(type: 'string')]

    private $permissionname;

    #[ORM\Column(type: 'text')]

    private $permissions;
    // Getters ve Setters...

    public function setName(string $name): void
    {
        $this->permissionname = $name;
    }

    public function setPermissions(string $permissions): void
    {
        $this->permissions = $permissions;
    }

    public function getName(): string
    {
        return $this->permissionname ;
    }
    public function getId(): string
    {
        return $this->permissionid ;
    }

  

}
