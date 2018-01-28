<?php
/**
 *------------------------------------------------------
 * AdminUserModel.php
 *------------------------------------------------------
 *
 * @author    m@9026.com
 * @date      2017/03/21 10:15
 * @version   V1.0
 *
 */

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUserModel extends Authenticatable
{
    /**
     * 数据表名
     */
    protected $table = "admin_users";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'name',
        'real_name',
        'password',
        'email',
        'mobile',
        'avatar',
        'type',
        'last_login_time',
        'status',
        'is_root',
        'admin_role_id'
    ];

}