<?php

namespace App\Configs;

use App\Configs\Database;
use App\Entity\Repository\ParentRepository;
use Illuminate\Database\Capsule\Manager as DB;
use App\Entity\Models\Migrations;
use App\Entity\Repository\MigrationRepository;

class MigrationConfig extends ParentRepository
{

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

        $result = Migrations::select("version")->whereIn("version", $filenames)->get();
        //debug($result);
        foreach ($filenames as $key => $value) {
            $value = str_replace(".php", '', $value);
            foreach ($result as $vl) {
                if ($value== $vl["version"]) {
                    unset($filenames[$key]);
                }
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
            (new ParentRepository())->insertBatch($execResult, "migrations");
            //$this->insertBatch($execResult, "migrations", $entityManager);
        }
    }
}
