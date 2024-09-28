<?php

namespace App\Entity\Repository\Eloquent;

use App\Entity\Models\User;
use App\Entity\Repository\BaseUserRepository;

class UserEloquentRepository extends BaseUserRepository
{    
    public function getAll()
    {
        return User::with(["permission"])->get()->toArray();
    }
    public static function save(User $data, $id = null)
    {
        if ($id) {
            $userFind = User::find($id);
            return $userFind->update($data);
        }
        $data->save();
        return $data;
    }

}
