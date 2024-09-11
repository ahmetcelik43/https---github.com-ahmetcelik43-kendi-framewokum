<?php

namespace App\Entity\Repository;

use App\Entity\Models\User;

class UserRepository extends ParentRepository
{

    public function __construct()
    {
        parent::__construct();
    }

    public static function getAll()
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
