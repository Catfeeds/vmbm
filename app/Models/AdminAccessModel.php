<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 权限表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2015-11-13
 *
 */
class AdminAccessModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'admin_access';
    /**
                主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;
    
    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
        'role_id',
        'menu_id'
    ];
    
    public function menus() {
        return $this->hasOne('App\Models\AdminMenusModel','id','menu_id');
    }
    
    public $timestamps = false;
    /**
     * 取得用户组的权限信息
     * 
     * @param intval $groupId
     * @return array
     */
    public function getRoleAccessMenu($roleIds,$isMenu = false)
    {
        if(is_string($roleIds)) {
            $roleIds = explode(',', $roleIds);
        }
        $info = $this->select('admin_menus.id',
                               'admin_menus.pid',
                              'admin_menus.path',
                            'admin_menus.name',
                             'admin_menus.ico',
                             'admin_menus.display',
                            'admin_menus.sort')
                     ->leftJoin('admin_menus', 'admin_access.menu_id', '=', 'admin_menus.id')
                     ->leftjoin("admin_roles","admin_access.role_id","=","admin_roles.id")
                    ->whereIn('role_id',$roleIds)
                    ->where("admin_roles.status",1);
        if($isMenu) {
            $info = $info->where("admin_menus.display",1);
        }
        $info = $info
                     ->orderBy('admin_menus.sort', 'desc')->orderBy('admin_menus.id', 'asc')
                     ->groupby(\DB::raw("admin_menus.id"))
                     ->get();
        return $info->toArray();
    }
}