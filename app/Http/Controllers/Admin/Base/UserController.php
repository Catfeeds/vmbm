<?php
/**
 *  
 *  @author  Mike <m@9026.com>
 *  @version    1.0
 *  @date 2015年10月12日
 *
 */
namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\Role;
use App\Services\Admin\AdminUser;
use Request;

class UserController extends Controller
{
    private $_service;
    private $_role_service;

    /**
     * 初始化Service
     */
    public function __construct()
    {
        parent::__construct();
        if(!$this->_service) $this->_service = new AdminUser();
        if(!$this->_role_service) $this->_role_service = new Role();
    }
    
    /**
     * 列表
     */
    function index()
    {
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');

        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $list = $this->_service->search($search, $orderby);
        $roles = pairList($this->_getRoles(), 'id', 'name');
        return view('admin.base.user.index', compact('list', 'roles'));
    }

    /**
     * 列表
     */
    function resetPwd()
    {
//        $pwd = '$2y$10$jRQGg4qdfDhdt.4TZpDaL.2pbgBJZqvdR.AMrE5rA2D3dgMyit8vS';
//        var_dump(crypt('abcded', $pwd));exit;
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');
        $search['resetPwd'] =true;
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $list = $this->_service->search($search, $orderby);
        return view('admin.base.user.resetPwd', compact('list'));
    }

    function resetPwdPass()
    {
        $ok = $this->_service->resetPwdPass(Request::get('id'));
        if($ok) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning('操作失败');
        }
    }

    function resetPwdReject()
    {
        $ok = $this->_service->resetPwdReject(Request::get('id'));
        if($ok) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning('操作失败');
        }
    }



    /**
     * 更新
     */
    public function create()
    {
        if(Request::method() == 'POST'){
            $data = Request::input('info');
            if(isset($data['admin_role_id']))$data['admin_role_id'] = implode(',', $data['admin_role_id']);
            if($this->_service->create($data)){
                $this->showMessage('操作成功', urldecode(Request::input('_referer')));
            }else{
                $this->showWarning('操作失败'  . $this->_service->getMsg(), urldecode(Request::input('_referer')));
            }
        }
        $data = $this->_service->find(Request::input('id'));

        if($this->_user['is_root']){
            $roles = $this->_getRoles();
        }else{
            $roles = $this->_getCurrentRoles();
        }
        return view('admin.base.user.edit', compact('data', 'roles'));
    }


    /**
     * 更新
     */
    public function update()
    {
        if(Request::method() == 'POST'){
            $data = Request::input('info');
            if(isset($data['admin_role_id']))$data['admin_role_id'] = implode(',', $data['admin_role_id']);
            if($this->_service->update(Request::input('id'), $data)){
                $this->showMessage('操作成功', urldecode(Request::input('_referer')));
            }else{
                $this->showWarning('操作失败' . $this->_service->getMsg(), urldecode(Request::input('_referer')));
            }
        }
        $data = $this->_service->find(Request::input('id'));
        
        if($this->_user['is_root']){
            $roles = $this->_getRoles();
        }else{
            $roles = $this->_getCurrentRoles();
        }
        return view('admin.base.user.edit', compact('data', 'roles'));
    }
    
    public function auth() {
        if(Request::method() == 'POST'){
            $info = Request::input('info');
            if(!empty($info['admin_role_id'])){
                $info['admin_role_id'] = implode(',', $info['admin_role_id']);
            }
            if(!$info['id']) {
                $this->showWarning('数据不全', urldecode(Request::input('_referer')));
            }
            if($this->_service->auth($info)){
                $this->showMessage('操作成功', urldecode(Request::input('_referer')));
            }else{
                $this->showWarning('操作失败'. $this->_service->getMsg(), urldecode(Request::input('_referer')));
            }
        }
        if($this->_user['is_root']){
            $roles = $this->_getRoles();
        }else{
            $roles = $this->_getCurrentRoles();
        }
        return view('admin.base.user.auth', compact( 'roles'));
    }

    public function status() {
        $ok = $this->_service->updateStatus(Request::get('id'),Request::get('status'));
        if($ok) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning('操作失败' . $this->_service->getMsg());
        }
    }


    /**
     * 得到当前角色所拥有的角色
     */
    private function _getCurrentRoles()
    {
        $_node = $this->_getRoleNode();
        return $this->_role_service->getChildByLevel($_node['level'])->toArray();
    }
    
    /**
     * 获取角色权限节点（level越小权限越大）
     */
    private function _getRoleNode()
    {
        return $this->_role_service->getLevelNode($this->_user['admin_role_id'])->toArray();
    }
    
    /**
     * 得到所有角色
     */
    private function _getRoles()
    {
        return $this->_role_service->get()->toArray();
    }
    
}