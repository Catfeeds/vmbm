<?php
/**
 * User: Mike
 * Email: m@9026.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace App\Repositories\Base\Criteria;




use App\Repositories\Base\Criteria;
use App\Repositories\Contracts\RepositoryInterface as Repository;

class OrderBy extends Criteria {

    private $field = '';
    private $sort = 'ASC';

    /**
     * MultiWhere constructor.
     * @param array $search
     *
     *               id  商品ID
     *               name 商品名称（模糊查询）
     *               cate_id 分类ID
     *               store_id 商家ID
     *               store_name 商家名称(模糊查询)
     *
     *
     *
     */
    public function __construct($field,$sort="ASC")
    {
        $this->field = $field;
        $this->sort = $sort;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $model = $model->orderBy($this->field,$this->sort);
        return $model;
    }

}