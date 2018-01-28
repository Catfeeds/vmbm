<?php
/**
 *  
 *  @author  Mike <m@9026.com>
 *  @version    1.0
 *  @date 2015年10月30日
 *
 */
namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Base\Attachment;
use App\Services\Base\System;
use Request;

class SystemController extends Controller
{
   
    //系统日志
    public function config() {
        if(Request::method() == 'POST') {
            return $this->_counfigSave();
        }
        $obj = new System();
        $data = $obj->getCoufig();
        return view('admin.base.system.config', compact('data'));

    }

    private function _counfigSave() {
        $data = (array) Request::input('data');
        $obj = new System();
        $ok = $obj->saveConfig($data);
        if($ok) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning('操作失败');
        }
    }

} 