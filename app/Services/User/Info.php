<?php
/**
 *   用户管理
 *  @author  system
 *  @version    1.0
 *  @date 2017-03-23 12:56:46
 *
 */
namespace App\Services\User;

use App\Services\Base\BaseProcess;
use App\Models\UserInfoModel;

class Info extends BaseProcess {
    /**
     * 模型
     *
     * @var object
     * 
     */
    private $_objModel;
    

    /**
     * 初始化
     *
     * @access public
     * 
     */
    public function __construct()
    {
        if( ! $this->_objModel) $this->_objModel = new UserInfoModel();
    }
    
    public function model() {
        return $this->_objModel;
    }
    public function search(array $search,array $orderby=['id'=>'desc'],$pagesize=PAGE_NUMS)
    {
        $currentQuery = $this->_objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('id'  , 'like', $keywords)             
                ->orwhere('username', 'like', $keywords)
                ->orwhere('real_name', 'like', $keywords)
                ->orwhere('password', 'like', $keywords)
                ->orwhere('email', 'like', $keywords)
                ->orwhere('mobile', 'like', $keywords)
                ->orwhere('avatar', 'like', $keywords)
                ->orwhere('address', 'like', $keywords)
                ->orwhere('idcard', 'like', $keywords)
                ->orwhere('idcard_positive', 'like', $keywords)
                ->orwhere('idcard_back', 'like', $keywords)
                ->orwhere('contact_name', 'like', $keywords)
                ->orwhere('contact_mobile', 'like', $keywords)
                ->orwhere('other_contact_name', 'like', $keywords)
                ->orwhere('other_contact_mobile', 'like', $keywords);
            });
        }
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }
        
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }
    
    public function getAll($where,$orderby=null) {
        //条件
        $currentQuery = $this->_objModel;
        if($where && is_array($where)){
            foreach ($where AS $field => $value){
               $currentQuery=   $currentQuery -> where($field, $value);
            }
        }
        
        //排序
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
               $currentQuery =  $currentQuery -> orderBy($field, $value);
            }
        }
        return $currentQuery->get();
    }
    
    public function find($id) {
        return $this->_objModel->find($id);
    }
    /**
     * 添加
     * @param unknown $data
     */
    public function create($data)
    {
        return $this->_objModel->create($data);
    }
    
    /**
     * 更新
     * @param unknown $id
     * @param unknown $data
     */
    public function update($id,$data)
    {
        $obj = $this->_objModel->find($id);
        if(!$obj) {
            $this->setMsg("没有找到要修改的数据");
            return false;
        }
        $ok = $obj->update($data);
        return $ok;
    }
    
    public function updateStatus($id,$status) {
        $data = $this->_objModel->find($id);
        $data->status = $status;
        return $data->save();
    }
    /**
     * 删除
     * @param unknown $id
     */
    public function destroy($id)
    {
        return $this->_objModel->destroy($id);
    }
    
    
}
