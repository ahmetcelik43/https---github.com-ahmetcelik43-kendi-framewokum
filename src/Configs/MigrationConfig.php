<?php

namespace App\Configs;

use App\Configs\Database;
use App\Entity\Repository\ParentRepository;

class MigrationConfig extends ParentRepository
{
    private function getMigrations()
    {
        $contents = file_get_contents(BASEPATH . "/src/configs/Migrations.json");
        if ($contents == false) {
            $content = '{
                "Migrations": []
            }';
            file_put_contents(BASEPATH . "/src/configs/Migrations.json", $content);
            $contents = [];
        } else {
            $contents = json_decode($contents, true)["Migrations"];
        }
        return $contents;
    }
    private function addMigration(string $executed)
    {
        $contents = file_get_contents(BASEPATH . "/src/configs/Migrations.json");
        $contents = json_decode($contents, true);
        $add = [];
        foreach ($contents["Migrations"] as $value) {
            $add[] = '"' . $value . '"';
        }
        $add[] = '"' . $executed . '"';
        $content = '{
            "Migrations": [' . implode(',', $add) . ']
        }';
        return file_put_contents(BASEPATH . "/src/configs/Migrations.json", $content);
    }
    public static function create()
    {
        if (!file_exists($path = BASEPATH . '/src/Entity/Migrations')) {
            mkdir($path);
        }
        $filename = "Version" . time();
        $contents = "<?php
        namespace App\Entity\Migrations;
        class $filename{
            public function up(){
                return false;
            }
        }
        ";

        file_put_contents($path  . "/$filename.php", $contents);
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

        //$result = Migrations::select("version")->whereIn("version", $filenames)->get()->toArray();
        $result = $this->getMigrations();
        foreach ($filenames as $key => $value) {
            $value = str_replace(".php", '', $value);
            if (in_array($value, $result)) {
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
                    $this->addMigration($value);
                    $execResult[] = ["version" => $value, "executed_at" => date("Y-m-d H:i:s")];
                }
            } catch (\Exception $th) {
                //var_dump($th->getMessage());
            }
        }
    }
}
