<?php
// src/Entity/User.php
namespace App\Entity\Models;

use App\Entity\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]

class User
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]


    private $userid;


    #[ORM\Column(type: 'string')]

    private $username;


    #[ORM\Column(type: 'string')]

    private $useremail;


    #[ORM\Column(type: 'integer')]
    //#[JoinTable(name: 'permissions')]
    //#[JoinColumn(name: 'userpermission', referencedColumnName: 'permissionid')]
    private $userpermission;


    //#[ORM\ManyToOne(targetEntity: Permission::class, inversedBy: 'users')]
    //private Permission $permission;
    // Getters ve Setters...

    public function setUserName(string $name): void
    {
        $this->username = $name;
    }
    public function setUserEmail(string $email): void
    {
        $this->useremail = $email;
    }
    public function setUserPermission(int $permission): void
    {
        $this->userpermission = $permission;
    }
    public function getUserPermission(): int
    {
        return $this->userpermission;
    }
}
