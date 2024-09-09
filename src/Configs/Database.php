<?php

namespace App\Configs;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class Database
{
    private static $instance = null; // Singleton instance
    private static $entityManager;
    private static $con;

    // Private constructor to prevent multiple instantiations
    private function __construct()
    {
        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/src/Entity'],
            isDevMode: false,
        );

        // Configure the database connection
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'user'     => 'root',
            'password' => 'Ahmet.4336',
            'dbname'   => 'doctrine',
            'pooling' => true
        ], $config);

        // Obtain the entity manager
        $this->entityManager = new EntityManager($connection, $config);
        $this->con = $this->entityManager->getConnection();
    }

    // Singleton method to get the instance of Database
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to return the EntityManager
    public function getEntityManager()
    {
        return $this->entityManager;
    }
    public function getConnection()
    {
        return $this->con;
    }

    // Destructor to clean up resources
    /* function __destruct()
    {
        $this->connection->close();
        $this->entityManager->flush();
    }*/
}
