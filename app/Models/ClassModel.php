<?php

namespace App\Models;
use App\Models\BaseModel;

class ClassModel extends BaseModel
{
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'classes';
    /**
    主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;
}
