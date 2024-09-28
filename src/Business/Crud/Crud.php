<?php

namespace App\Business\Crud;

use App\Entity\Repository\ParentRepository;
use Illuminate\Database\Eloquent\Model;

trait Crud
{

    public function getQuery(Model $model)
    {
        // $fillables = $model->getFillable();
        $data = $model::all()->toArray();
        //$model->getAttributes()
        return $data;
    }

    public function getSingleQuery(Model $model, int $id)
    {
        // $fillables = $model->getFillable();
        $data = $model::find($id);
        //$model->getAttributes()
        return $data;
    }

    public function saveQuery(Model $model,int $id = null, array $post)
    {
        if ($id) {
            return $model->find($id)->update($post);
        }
        return $model::create($post);
    }

    public function deleteQuery(Model $model,int $id = null)
    {
        if ($id) {
            return $model->find($id)->delete();
        }
    }
}
