<?php

namespace App\Entity\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudRepository extends BaseRepository
{
    public abstract function getQuery(Model $model = null);
    public abstract function getSingleQuery(Model $model = null, int $id);
    public abstract function saveQuery(Model $model = null, int $id = null, array $post);
    public abstract function deleteQuery(Model $model = null, int $id = null);
}
