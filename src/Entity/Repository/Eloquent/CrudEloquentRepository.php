<?php

namespace App\Entity\Repository\Eloquent;

use App\Entity\Repository\BaseCrudRepository;
use Illuminate\Database\Eloquent\Model;

class CrudEloquentRepository extends BaseCrudRepository
{    
    public function getQuery(Model $model=null)
    {
        // $fillables = $model->getFillable();
        $data = $model::all()->toArray();
        //$model->getAttributes()
        return $data;
    }

    public function getSingleQuery(Model $model=null, int $id)
    {
        // $fillables = $model->getFillable();
        $data = $model::find($id);
        //$model->getAttributes()
        return $data;
    }

    public function saveQuery(Model $model=null,int $id = null, array $post)
    {
        if ($id) {
            return $model->find($id)->update($post);
        }
        return $model::create($post);
    }

    public function deleteQuery(Model $model=null,int $id = null)
    {
        if ($id) {
            return $model->find($id)->delete();
        }
    }

}
