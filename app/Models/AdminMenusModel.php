<?php
/**
 *------------------------------------------------------
 * AdminMenusModel.php
 *------------------------------------------------------
 *
 * @author    m@9026.com
 * @date      2017/03/20 11:43
 * @version   V1.0
 *
 */

namespace App\Models;

class AdminMenusModel extends BaseModel
{
    /**
     * 数据表名
     */
    protected $table = "admin_menus";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'pid',
        'path',
        'name',
        'display',
        'sort',
        'level',
        'ico',
        'mark'
    ];

}