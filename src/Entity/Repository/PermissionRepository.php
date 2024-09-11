<?php

namespace App\Entity\Repository;

use App\Entity\Models\Permission;

class PermissionRepository extends ParentRepository
{
    public static function save(Permission $data, $id = null)
    {
        if ($id) {
            $permission = Permission::find($id);
            return $permission->update($data);
        }
        $data->save();
        return $data;
    }
}
