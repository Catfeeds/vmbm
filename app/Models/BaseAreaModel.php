<?php
/**
 *------------------------------------------------------
 * BaseAreaModel.php
 *------------------------------------------------------
 *
 * @author    m@9026.com
 * @date      2017/03/20 13:09
 * @version   V1.0
 *
 */

namespace App\Models;

class BaseAreaModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "base_area";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'name',
        'pid',
        'short_name',
        'grade',
        'city_code',
        'zip_code',
        'merger_name',
        'lng',
        'lat',
        'pinyin'
    ];

}