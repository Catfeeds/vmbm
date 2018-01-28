<?php
/**
 *  用户操作
 *  @author  Mike <m@9026.com>
 *  @version    1.0
 *  @date 2015年11月13日
 *
 */
namespace App\Services\Admin;
use App\Models\AdminUserModel;
use Hash;
use App\Services\Base\BaseProcess;

class AdminUser extends BaseProcess
{
    /**
     * 模型
     *
     * @var object
     *
     */
    private $objModel;
    
    /**
     * 初始化
     */
    public function __construct()
    {
        if( !$this->objModel) $this->objModel = new AdminUserModel();
    }
    
    public function model()
    {
        $this->setSucessCode();
        return $this->objModel;
    }
    
    /**
     * 搜索
     * @param $search
     * @param $pagesize
     */
    public function search($search, $orderby = array(), $pagesize = PAGE_NUMS)
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('name'  , 'like', $keywords)
                ->orwhere('email', 'like', $keywords)
                ->orwhere('mobile', 'like', $keywords);
            });
        }
        if(isset($search['resetPwd']) && $search['resetPwd']) {

            $currentQuery = $currentQuery->where('reset_password', '<>', '');
        }

        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('id', 'DESC');
        }
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }
    
    /**
     * 添加
     * @param $data
     */
    public function create($data)
    {
        // 判断是否唯一
      /*   if($this->objModel->where('name', '=', $data['name'])->count()){
            $this->setMsg("已经存在【{$data['name']}】用户！");
            return false;
        } */
        $data['username'] = isset($data['username']) ? $data['username'] : "";
        $data['email'] = isset($data['email']) ? $data['email'] : "";
        $data['mobile'] = isset($data['mobile']) ? $data['mobile'] : "";
        if($data['username']== "" && $data['email']=="" && $data['mobile']=="") {
            $this->setMsg("至少有一个登陆凭证");
            return false;
        }
        if(isset($data['username']) && $data['username']) {
            if(is_numeric($data['username'])) {
                $this->setMsg("用户名不能是全数字！");
                return false;
            }
            if(strpos($data['username'],"@")) {
                $this->setMsg("用户名不能有@符号！");
                return false;
            }
            if($this->objModel->where('username', '=', $data['username'])->count()){
                $this->setMsg("已经存在的用户名！");
                return false;
            }
        }
        if(isset($data['email']) && $data['email']) {
            if($this->objModel->where('email', '=', $data['email'])->count()){
                $this->setMsg("已经存在的邮箱！");
                return false;
            }
        }
        if(isset($data['mobile']) && $data['mobile']) {
            if($this->objModel->where('mobile', '=', $data['mobile'])->count()){
                $this->setMsg("已经存在的手机号！");
                return false;
            }
        }
        if(isset($data['password']) && $data['password']){
            $data['password'] = bcrypt($data['password']);
        }

        return $this->objModel->create($data);
    }
    
    /**
     * 更新
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $obj = $this->objModel->find($id);
        if(!$obj) {
            return false;
        }
        if(isset($data['password']) && $data['password']){
            $data['password'] = bcrypt($data['password']);
        }
        if(isset($data['username']) && $data['username']) {
            if(is_numeric($data['username'])) {
                $this->setMsg("用户名不能是全数字！");
                return false;
            }
            if(strpos($data['username'],"@")) {
                $this->setMsg("用户名不能有@符号！");
                return false;
            }
            if($this->objModel->where('username', '=', $data['username'])->where('id',"<>",$id)->count()){
                $this->setMsg("已经存在的用户名！");
                return false;
            }
        }
        if(isset($data['email']) && $data['email']) {
            if($this->objModel->where('email', '=', $data['email'])->where('id',"<>",$id)->count()){
                $this->setMsg("已经存在的邮箱！");
                return false;
            }
        }
        if(isset($data['mobile']) && $data['mobile']) {
            if($this->objModel->where('mobile', '=', $data['mobile'])->where('id',"<>",$id)->count()){
                $this->setMsg("已经存在的手机号！");
                return false;
            }
        }
        $ok = $obj->update($data);
        return $ok;
    }

    /**
     * 更新状态
     * @param $id
     * @param $status
     */
    public function updateStatus($id, $status)
    {
        $data = $this->objModel->find($id);
        //禁用
        $mobile = $data->mobile;
        $data->status = $status;
        return $data->save();
    }
    
    /**
     * 删除
     * @param $id
     */
    public function destroy($id)
    {
        return $this->objModel->destroy($id);
    }
    
    /**
     * 获取一行数据
     * @param $where
     * @return
     */
    public function find($id)
    {
        return $this->objModel->find($id);
    }
    

    public function login($login,$password) {
        if(is_numeric($login)) {
            $loginField = "mobile";
        }elseif(strpos($login,"@")) {
            $loginField = "email";
        }else{
            $loginField = "name";
        }
        if (\Auth::guard('admin')->attempt(array($loginField => $login, 'password' =>$password)))
        {
            $data =  \Auth::guard('admin')->user();
            if($data->status==0) {
                $this->setMsg('账号正在努力审核中...');
                return false;
            }
            if(!$data->status) {
                $this->setMsg('账号被禁用');
                return false;
            }
            $role = [];
            if($data->is_root) {
                $aclObj = new Acl();
                $data =  $aclObj->getRootFunc();
                $role['role'] =$data['func'];
                $role['menus'] =$data['menus'];
            }elseif($data->admin_role_id) {
                $aclObj = new Acl();
                $data =  $aclObj->getRoleFunc($data->admin_role_id);
                $role['role'] =$data['func'];
                $role['menus'] =$data['menus'];
            }
            session()->put(LOGIN_MARK_SESSION_KEY, $role);
            session()->save();
            return true;
        }else{
            $this->setMsg('用户密码错误');
            return false;
        }
    }

    /**
     * 重设密码
     * @param $loginName
     * @param $data
     */
    public function resetPwd($loginName,$data) {
        if(is_numeric($loginName)) {
            $loginField = "mobile";
        }elseif(strpos($loginName,"@")) {
            $loginField = "email";
        }else{
            $loginField = "username";
        }
        $user = $this->objModel->where($loginField,$loginName)->first();
        if(!$user) {
            $this->setMsg('没有找到用户');
            return false;
        }
        $user->reset_password = bcrypt($data['reset_password']);
        $user->reset_password_img = $data['reset_password_img'];
        $ok = $user->save();
        if(!$ok) {
            $this->setMsg('操作失败');
            return false;
        }
        return true;
    }


    /**
     * 查询多条数据
     */
    public function get($pagesize = PAGE_NUMS) {
        return $this->objModel->take($pagesize)->orderBy('id', 'DESC')->get();
    }


    /**
     * 查询多条数据并分页
     */
    public function getPage($pagesize = PAGE_NUMS) {
        return $this->objModel->orderBy('id', 'DESC')->paginate($pagesize);
    }
    
    
}
