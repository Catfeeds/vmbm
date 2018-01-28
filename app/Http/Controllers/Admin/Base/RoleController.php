<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\Role;
use Request;
use App\Services\Admin\Acl;

class RoleController extends Controller
{
    private $level;
    private $_service;
    private $_serviceDepartments;

    /**
     * 初始化Service
     */
    public function __construct()
    {
        parent::__construct();
        
        if(!$this->_service) $this->_service = new Role();
        $this->level = isset($this->_getRoleNode()->level)?$this->_getRoleNode()->level:'';
    }
    
    /**
     * 列表
     */
    function index()
    {
        if($this->_user['is_root']){
            $search['level'] = 0;
        }else{
            $search['level'] = $this->level;
        }
        
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');
        
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $list = $this->_service->search($search, $orderby);

        return view('admin.base.role.index', compact('list'));
    }

    /**
     * 创建
     */
    public function create()
    {
        if(Request::method() == 'POST'){
            if(intval(Request::input('info.level')) < $this->level){
                $this->showWarning('你无权创建该等级的角色！', urldecode(Request::input('_referer')));
            }
            if($this->_service->create(Request::input('info'))){
                $this->showMessage('操作成功', U( 'Base/Role/index'));
            }else{
                $this->showMessage('操作失败', U( 'Base/Role/index'));
            }
        }
        $level = $this->level;
        return view('admin.base.role.edit', compact('level', 'Departments'));
    }

    /**
     * 更新
     */
    public function update()
    {
        if(Request::method() == 'POST'){
            if(intval(Request::input('info.level')) < $this->level){
                $this->showWarning('你无权创建该等级的角色！', urldecode(Request::input('_referer')));
            }
            if($this->_service->update(Request::input('id'), Request::input('info'))){
                $this->showMessage('操作成功', urldecode(Request::input('_referer')));
            }else{
                $this->showWarning('操作失败', urldecode(Request::input('_referer')));
            }
        }
        $data = $this->_service->find(Request::input('id'));
        $level = $this->level;
        return view('admin.base.role.edit', compact('data', 'level', 'Departments'));
    }
    
    /**
     * 更新
     */
    public function auth()
    {
        $id = Request::input('id');
        
        $objAcl = new Acl();
        
        
        if(Request::method() == 'POST'){
           $menuIds = Request::input('menu_ids');
           if($this->_user['is_root']) {
               $allMenus = false;
           }else{
               $allMenus = array();
               foreach ($this->_user['menus'] as $value) {
                   $allMenus[] = $value['id'];
               }
           }
           $ok = $objAcl->setRole($id, $menuIds,$allMenus);
           if($ok) {
               $arr['status'] = SUCESS_CODE;
               
           }else{
               $arr['status'] = SERVER_ERROR;
           }
           exit(json_encode($arr));
        }
        
        $hasPermissions = $objAcl->getAccessIDs($id);
        
        $role =  session(LOGIN_MARK_SESSION_KEY);
        //为ztree做数据准备
        $zTree = []; $all = [];
        foreach($role['menus'] as $key => $value)
        {
            $arr = ['id' => $value['id'], 'pId' => $value['pid'], 
                    'name' => $value['name'] . " (" . $value['path'] . ")",
                    'open' => true];
            if(in_array($value['id'], $hasPermissions)) $arr['checked'] = true;
            $zTree[] = $arr;
            $all[] = $value['id'];
        }
        $data = $this->_service->find($id);
        return view('admin.base.role.auth', compact('data','zTree','all'));
    }
  
    /**
     * 更新状态
     */
    public function status()
    {
        $bool = $this->_service->updateStatus(Request::input('id'), Request::input('status'));
        if($bool) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning('操作失败');
        }
    }
    
    /**
     * 删除
     */
    public function destroy()
    {
        $bool = $this->_service->destroy(Request::input('id'));
        if($bool) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning("操作失败");
        }
    }
    
    /**
     * 获取角色权限节点（level越小权限越大）
     */
    private function _getRoleNode()
    {
        return $this->_service->getLevelNode($this->_user['admin_role_id']);
    }


    /**
     * 获取树形结构
     */
    private function _getTreeByDepartmentId()
    {
        if($this->_user['is_root']){
            $department_id = 0;
        }else{
            $department_id = intval($this->_user['department_id']);
        }
        return $this->_serviceDepartments->getTreeByDepartmentId($department_id);
    }
    
}
