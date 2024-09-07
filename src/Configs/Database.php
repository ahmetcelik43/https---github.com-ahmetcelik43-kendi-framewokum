<?php

namespace App\Configs;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class Database
{
    public $entityManager;
    private $connection;

    function __destruct()
    {
        $this->connection->close();
        $this->entityManager->flush();
    }

    public function __construct()
    {
        //require_once "vendor/autoload.php";

        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/src/Entity'],
            isDevMode: true,
        );
        // or if you prefer XML
        // $config = ORMSetup::createXMLMetadataConfiguration(
        //    paths: [__DIR__ . '/config/xml'],
        //    isDevMode: true,
        //);


        // configuring the database connection
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'user'     => 'root',
            'password' => 'Ahmet.4336',
            'dbname'   => 'doctrine',
        ], $config);

        // obtaining the entity manager
        $this->entityManager = new EntityManager($connection, $config);
        $this->connection = $connection;
    }
    public function get() {
        return $this->entityManager;
    }

   
}
