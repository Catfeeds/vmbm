<?php
/**
 * User: Mike
 * Email: m@9026.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace App\Repositories\Settings\Criteria;


use App\Repositories\Base\Criteria;
use App\Repositories\Contracts\RepositoryInterface as Repository;

class MultiWhere extends Criteria {

    private $search = [];

    /**
     * MultiWhere constructor.
     * @param array $search
     *
     */
    public function __construct(array $search)
    {
        $this->search = $search;
    }

    /**
    * @param $model
    * @param RepositoryInterface $repository
    * @return mixed
    */
    public function apply($model, Repository $repository)
    {
        if(isset($this->search['keyword']) && ! empty($this->search['keyword'])) {
            $keywords = '%' . $this->search['keyword'] . '%';
            $model = $model->where(function ($query) use ($keywords) {
                $query->where('key'  , 'like', $keywords)
                    ->orwhere('value', 'like', $keywords);
            });
        }
        return $model;
    }

}