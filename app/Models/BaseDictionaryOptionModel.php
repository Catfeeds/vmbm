<?php
/**
 *------------------------------------------------------
 * BaseDictionaryOptionModel.php
 *------------------------------------------------------
 *
 * @author    m@9026.com
 * @date      2017/03/20 13:09
 * @version   V1.0
 *
 */

namespace App\Models;

class BaseDictionaryOptionModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "base_dictionary_option";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'dictionary_table_code',
        'dictionary_code',
        'key',
        'value',
        'name',
        'input_code',
        'sort'
    ];

}