<?php
/**
 *  日志记录
 *  @author  system
 *  @version    1.0
 *  @date 2016-12-28 11:54:01
 *
 */

namespace App\Services\Log;

use App\Models\LogRemarkModel;
use App\Services\Base\BaseProcess;

class LogRemark extends BaseProcess
{
    /**
     * 模型
     */
    private $_model;

    /**
     * 初始化
     */
    public function __construct()
    {
        if( ! $this->_model ) $this->_model = new LogRemarkModel();
    }

    /**
     * 添加日志记录
     * @param $system 所属系统
     * @param $system_primary 所属系统ID
     * @param $system_key 所属系统二级主键ID
     * @param array $data
     * @return static
     */
    public function createRecord($system, $system_primary, $system_key, array $data)
    {
        $data['system'] = $system;
        $data['system_primary'] = $system_primary;
        $data['system_key'] = $system_key;

        if( isset($data['status']) ){
            $model = $this->_model
                ->where('system', $data['system'])
                ->where('system_primary', $data['system_primary'])
                ->where('system_key', $data['system_key'])
                ->where('status', $data['status'])
                ->first();
        }else{
            $model = $this->_model
                ->where('system', $data['system'])
                ->where('system_primary', $data['system_primary'])
                ->where('system_key', $data['system_key'])
                ->first();
        }
        return $model ? $model->update($data) : $this->_model->create($data);
    }

}