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

class LogsController extends Controller
{
   
    //系统日志
    public function nginx() {
        $log_path = storage_path() . '/logs/' . "error-log" . date("Y-m-d") . ".log";
        if(file_exists($log_path)) {
            echo "<pre>" . file_get_contents($log_path) . "</pre>";
        }else{
            exit("没有错误日志");
        }
        
    }
    /**
     * 初始化文件上传组件
     */
    private function _uploadControl($folder, $position = 'ali')
    {
        //初始化文件上传组件
        $attachmentObj = new Attachment();
        return $attachmentObj -> initupload([
                'file_types' => 'jpg|jpeg|gif|png|bmp',
        ], [
                'position'   => $position,
                'folder'     => $folder,
        ]);
    }
    
} 