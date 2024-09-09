<?php

namespace App\Configs;

use App\Configs\Database;
use App\Entity\Repository\ParentRepository;

class Migrations
{
    use ParentRepository;
    public static function create()
    {
        $filename = "Version" . time();
        $contents = "<?php
        namespace App\Entity\Migrations;
        class $filename{
            public function up(){
                return false;
            }
        }
        ";

        file_put_contents(BASEPATH . "/src/Entity/Migrations/$filename.php", $contents);
        return 'ok';
    }
    public function control()
    {
        $klasorYolu = BASEPATH . "/src/Entity/Migrations";

        $dosyalar = scandir($klasorYolu);
        $filenames = [];

        foreach ($dosyalar as $dosya) {
            if ($dosya !== '.' && $dosya !== '..') {
                $dosya = str_replace(".php", '', $dosya);
                $filenames[] = $dosya;
            }
        }

        $entityManager = Database::getInstance()->getEntityManager();
        $sql = '
        SELECT version 
        FROM migrations u where version not in (:filenames)
         ';
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->bindValue("filenames", implode(',', $filenames));
        $result = $stmt->executeQuery()->fetchAllAssociative();
        foreach ($filenames as $key => $value) {
            $value = str_replace(".php", '', $value);
            if (in_array($value, array_column($result, "version"))) {
                unset($filenames[$key]);
            }
        }
        
        $execResult = [];
        foreach ($filenames as $value) {
            $value = str_replace([".php"], '', $value);
            $class = "\\App\\Entity\\Migrations\\" . $value;
            $class = new $class;

            try {
                if ($class->up() != false) {
                    $execResult[] = ["version" => $value, "executed_at" => date("Y-m-d H:i:s")];
                }
            } catch (\Exception $th) {
                //var_dump($th->getMessage());
            }
        }

        if (!empty($execResult)) {
            $this->insertBatch($execResult, "migrations", $entityManager);
        }
    }
}
