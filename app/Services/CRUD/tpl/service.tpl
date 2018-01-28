<?php
/**
 *   {{desc}}
 *  @author  system
 *  @version    1.0
 *  @date {{date}}
 *
 */
namespace App\Services\{{sortPath}};

use App\Services\Base\BaseProcess;
use {{modelUse}};

class {{serviceName}} extends BaseProcess {
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
        if( ! $this->_objModel) $this->_objModel = new {{modelName}}();
    }
    
    public function model() {
        return $this->_objModel;
    }
    public function search(array $search,array $orderby=['{{primaryKey}}'=>'desc'],$pagesize=PAGE_NUMS)
    {
        $currentQuery = $this->_objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                {{queryKeyord}}
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
