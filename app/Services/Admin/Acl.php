<?php
/**
 *  
 *  @author  Mike <m@9026.com>
 *  @version    1.0
 *  @date 2015年11月13日
 *
 */
namespace App\Services\Admin;

use App\Services\Base\BaseProcess;
use App\Models\AdminAccessModel;
use App\Models\AdminMenusModel;

class Acl extends BaseProcess {
    
    private $objModel;
    private $menusModel;
    /**
     * 初始化
     *
     * @access public
     *
     */
    public function __construct()
    {
        if( ! $this->objModel) $this->objModel = new AdminAccessModel();
        if( ! $this->menusModel) $this->menusModel = new AdminMenusModel();
    }
    
    public function checkFunc($module,$contrl,$action) {
        
    }
    
    
    public function getRoleFunc($roleIds) {
        $data =$this->objModel->getRoleAccessMenu($roleIds);
        if(!$data) {
              return array('menus'=>array(),'func'=>array());
        }
        $arr = array('/'=>'0','Foundation/Index/index'=>501,'Foundation/Index/welcome'=>502,'Foundation/Login/logout'=>503);
        foreach ($data as $val) {
            $arr[$val['path']] = $val['id'];
        }
        return array('menus'=>$data,'func'=>$arr);
            ;
    }
    
    public function getRoleMenu($roleIds) {
        $data =$this->objModel->getRoleAccessMenu($roleIds,true);
        if(!$data) {
            return array();
        }
        return $data;
    }
    
    
    public function getRootFunc() {
        $data =$this->menusModel->select('id','pid','path','name','display','level','ico')->orderBy('sort','desc')->get()->toArray();
        if(!$data) {
            return array('menus'=>array(),'func'=>array());
        }
        $arr = array('/'=>'0','Foundation/Index/index'=>501,'Foundation/Index/welcome'=>502,'Foundation/Login/logout'=>503);
        foreach ($data as $val) {
            $arr[$val['path']] = $val['id'];
        }
        return array('menus'=>$data,'func'=>$arr);
    }
    /**
     * 获取角色权限ID
     * @param unknown $roleId
     */
   public function getAccessIDs($roleId) {
       $data = $this->objModel->select("menu_id")->where("role_id",$roleId)->get();
       $arr = array();
       if($data) {
            foreach ($data as $val) {
                $arr[] = $val['menu_id'];
            }
       }
       return $arr;
   }
   /**
    * 
    * @param unknown $roleId
    * @param unknown $menuIds
    * @param string $allMenus 权限范围，如果为false不验证
    */
   public function setRole($roleId,$menuIds,$allMenus=false) {
       
       try
       {
           $result = \DB::transaction(function() use ($roleId, $menuIds,$allMenus)
           {
               $ok = $this->objModel->where("role_id",$roleId)->delete();
               if($ok===false) {
                  throwException("删除出错");
               }
               foreach ($menuIds as $menu_id) {
                   if($allMenus !== false) {
                       if(!in_array($menu_id, $allMenus)) {
                           throwException("涉及到越权操作");
                       }
                   }
                   $add['role_id'] = $roleId;
                   $add['menu_id'] = $menu_id;
                   
                   $ok = $this->objModel->create($add);
                   if(!$ok) {
                       throwException("添加出错");
                   }
               }
              
               return true;
           });
       }
       catch (\Exception $e)
       {
           $result = false;
       }
       
       if( ! $result) return $this->setMsg('操作失败');
       
       return true;
   }
   
    
}