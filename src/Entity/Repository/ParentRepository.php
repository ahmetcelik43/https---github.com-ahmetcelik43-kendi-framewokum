<?php

namespace App\Entity\Repository;

trait ParentRepository
{
    public function insertBatch(array $userbatch = array(), $tablename, $entityManager)
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
        $connection = $entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        foreach ($userbatch as $key => $value) {
            foreach ($value as $key2 => $vl) {
                $stmt->bindValue($key . $key2, $vl);
            }
        }
        $stmt->executeQuery();
        $entityManager->flush();
        $connection->close();
    }

    public function updateBatch(array $userbatch = array(), string $column, $tablename, $entityManager)
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
        $updateColumns = implode(',', $updateColumns);
        $sql = "UPDATE $tablename tbl JOIN ( $values ) vals ON tbl.$column = vals.id SET $updateColumns;";

        $connection = $entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        foreach ($userbatch as $key => $value) {
            for ($i = 0; $i < count($columnKeys); $i++) {
                if ($columnKeys[$i] == $column) {
                    $stmt->bindValue(("id" . $key . $i), $userbatch[$key][$columnKeys[$i]]);
                } else {
                    $stmt->bindValue(("field" . $key . $i), $userbatch[$key][$columnKeys[$i]]);
                }
            }
        }
        $stmt->executeQuery();
        $entityManager->flush();
        $connection->close();
    }

}
