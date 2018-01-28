<?php
namespace App\Repositories\Base;

use App\Repositories\Contracts\RepositoryInterface as BaseRepository;

abstract class Criteria {

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, BaseRepository $repository);
}
