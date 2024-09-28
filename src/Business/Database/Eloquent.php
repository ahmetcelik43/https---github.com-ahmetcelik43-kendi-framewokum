<?php

namespace App\Business\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent extends Database
{
    public function __construct()
    {
        $this->init();
    }
    function init()
    {
        $capsule = new Capsule;

        // Veritabanı bağlantı ayarlarını yapıyoruz
        $capsule->addConnection(config('Settings','default_database'));

        // ORM kullanımı için gerekli olan global fonksiyonları yükle
        $capsule->setAsGlobal();

        // Eloquent ORM'i başlatıyoruz
        $capsule->bootEloquent();
    }

     function insertBatch(array $userbatch = array(), $tablename)
    {
        $columnKeys = array_keys(array_values($userbatch)[0]);
        $columnKeys = implode(',', $columnKeys);
        $values = [];
        foreach ($userbatch as $key => $value) {
            $temp = [];
            foreach ($value as $key2 => $vl) {
                $temp[] .= ":$key$key2";
            }
            $values[] =  "(" . implode(',', $temp) . ")";
        }
        $values = implode(',', $values);
        $sql = "INSERT INTO $tablename ($columnKeys) VALUES $values;";

        $params = [];
        foreach ($userbatch as $key => $value) {
            foreach ($value as $key2 => $vl) {
                $params[($key . $key2)] = $vl;
            }
        }
        return Capsule::statement($sql, $params);
    }

     function updateBatch(array $userbatch = array(), string $column, $tablename)
    {
        $columnKeys = array_keys(array_values($userbatch)[0]);
        $values = [];
        $columns = [];
        foreach ($userbatch  as $key => $value) {
            $temp = [];

            for ($i = 0; $i < count($columnKeys); $i++) {
                if ($key == 0) {
                    if ($columnKeys[$i] == $column) {
                        $temp[] = "  :id" . $key . $i . " as id";
                    } else {
                        $temp[] = "  :field" . $key . $i . " as field" . $key . $i . " ";
                        $columns[] = " field" . $key . $i . " ";
                    }
                } else {
                    if ($columnKeys[$i] == $column) {
                        $temp[] = "  :id" . $key . $i . "";
                    } else {
                        $temp[] = "  :field" . $key . $i;
                    }
                }
            }


            $values[] =  " SELECT " . implode(' , ', $temp);
        }


        $values = implode(' UNION ALL', $values);
        $updateColumns = [];
        $indis = 0;
        foreach ($columnKeys as $key => $value) {
            if ($column != $value) {
                $updateColumns[] = $value . "=" . $columns[$indis];
                $indis++;
            }
        }
        $params = [];
        $updateColumns = implode(',', $updateColumns);
        $sql = "UPDATE $tablename tbl JOIN ( $values ) vals ON tbl.$column = vals.id SET $updateColumns;";
        foreach ($userbatch as $key => $value) {
            for ($i = 0; $i < count($columnKeys); $i++) {
                if ($columnKeys[$i] == $column) {
                    $params[("id" . $key . $i)] = $userbatch[$key][$columnKeys[$i]];
                } else {
                    $params[("field" . $key . $i)] = $userbatch[$key][$columnKeys[$i]];
                }
            }
        }
        return Capsule::statement($sql, $params);
    }
}
