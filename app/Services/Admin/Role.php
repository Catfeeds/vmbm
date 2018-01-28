<?php
/**
 *  用户角色
 *  @author  qqiu@qq.com
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
namespace App\Services\Admin;

use App\Services\Base\BaseProcess;
use App\Models\AdminRoleModel;

class Role extends BaseProcess
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
        if( !$this->objModel) $this->objModel = new AdminRoleModel();
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
    public function search($search, $orderby, $pagesize = PAGE_NUMS)
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('name'  , 'like', $keywords)
                ->orwhere('mark', 'like', $keywords);
            });
        }
        
        if(isset($search['department_ids']) && !empty($search['department_ids'])) {
            $department_ids = $search['department_ids'];
            $currentQuery = $currentQuery->where(function ($query) use ($department_ids) {
                $query->whereIn('department_id', $department_ids);
            });
        }
        
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('id', 'DESC');
        }
        
        $currentQuery = $currentQuery->where('level', '>=', $search['level'])->paginate($pagesize);
        return $currentQuery;
    }

    /**
     * 添加
     * @param $data
     */
    public function create($data)
    {
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
    
    /**
     * 获取角色权限节点（level越小权限越大）
     */
    public function getLevelNode($role_ids)
    {
        $role_ids = is_array($role_ids) ? $role_ids : explode(',', $role_ids);
        return $this->objModel->whereIn('id', $role_ids)->take(1)->orderBy('level', 'ASC')->first();
    }
    
    /**
     * 根据状态查询数据
     */
    public function getValidData($status = 1)
    {
        return $this->objModel->where('status', $status)->orderBy('id', 'DESC')->get();
    }
    
    /**
     * 查询多条数据
     */
    public function get($pagesize = PAGE_NUMS) {
        return $this->objModel->take($pagesize)->orderBy('level', 'ASC')->get();
    }
    
    /**
     * 查询多条数据并分页
     */
    public function getPage($pagesize = PAGE_NUMS) {
        return $this->objModel->orderBy('id', 'DESC')->paginate($pagesize);
    }
    
    /**
     * 获取子等级数据
     */
    public function getChildByLevel($level, $departmentIds=array())
    {
        $currentQuery = $this->objModel;
        $currentQuery = $currentQuery->where('level', '>=', $level);
        $currentQuery = $currentQuery->where('status', '=', 1);
        if($departmentIds){
            $currentQuery = $currentQuery->whereIn('department_id', $departmentIds);
        }
        return $currentQuery = $currentQuery->orderBy('level', 'ASC')->get();
    }
    
    /**
     * 根据部门ID获取角色个数
     */
    public function getCountByDepartmentId($department_id)
    {
        return $this->objModel->where('department_id', '=', $department_id)->count();
    }
    
}
