<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description {{table_comment}}
 *  @author  system;
 *  @version    1.0
 *  @date {{date}}
 *
 */
class {{class_name}} extends BaseModel
{
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = '{{table_name}}';
    /**
    主键
     */
    protected $primaryKey = '{{table_primary}}';

    //分页
    protected $perPage = PAGE_NUMS;

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = {{fillable}};

}