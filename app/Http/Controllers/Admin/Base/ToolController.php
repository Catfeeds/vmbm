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
use Request;
//use App\Utils\OSS\Alioss;
//use App\Utils\DirUtil;

class ToolController extends Controller
{
    private $_dirUtil;
    private $_aliossService;
    
    public function __construct() {
        if( !$this->_dirUtil ) $this->_dirUtil = new DirUtil();
        if( !$this->_aliossService ) $this->_aliossService = new Alioss();
    }
    
    /**
     * 专题上传
     */
    function specialupload() {
        $attachmentObj = new Attachment();
        $uploadControl = $attachmentObj -> initupload([
            'file_types' => 'php|htm|html',
        ], [
            'position'   => 'special',
            'folder'     => 'at',
        ]);
        
        //遍历专题目录
        $data = array();
        $dirList = $this->_dirUtil->dirTraverse(public_path('resources/views/web/special'));
        if(!empty($dirList)){
            foreach ($dirList AS $key => $val){
                $data[$key]['name'] = trim(iconv("GBK", "UTF-8//IGNORE", substr(strrchr($val, '/'), 1, 50))) . '.html';
                $data[$key]['url'] = 'http://' . config('sys.sys_www_domain') . '/at/' . $data[$key]['name'];
            }
        }
        view()->share("uploadControl", $uploadControl);
        return view('admin.base.tool.specialupload', compact('data'));
    }
    
    /**
     * 阿里云上传
     */
    function alimanage()
    {
        
        $ok = $this->_aliossService->doesObjectExist("a/bg.jpg");
        
        $img_path = config('sys.sys_images_url');
        $file_path = config('sys.sys_file_url');
        $folder = trim(Request::input('folder'));
        $dirname = trim(Request::input('dirname'));

        //创建目录
        if(Request::method() == 'POST'){
            if($dirname){
                $this->_createDir($dirname,  $folder);
            }else{
                $this->showWarning('目录名不能为空！');
            }
        }
        
        //构建路径
        $folderPath = '/<a href="' . U( 'Base/Tool/alimanage') . '?folder=">根目录</a>/';
        if($folder){
            $dirPath = '';
            $dirs = array_filter(explode('/', $folder));
            foreach ($dirs AS $dir){
                $dirPath .= $dir . '/';
                $folderPath .= '<a href="' . U( 'Base/Tool/alimanage') . '?folder=' . $dirPath . '">'. $dir .'</a>/';
            }
        }
        $itemObj = $this->_aliossService->listObjects(['prefix'=>$folder]);
        $item['obj'] = $itemObj->getObjectList(); // 文件列表
        $item['dir'] = $itemObj->getPrefixList(); // 目录列表
       
        $uploadControl = $this->_uploadControl('');
        
        return view('admin.base.tool.alimanage', compact('item', 'img_path', 'file_path', 'folderPath', 'uploadControl'));
    }
    
    private function _createDir($dirname, $folder)
    {
        if(strpos($dirname, '/') === false && preg_match('/^([0-9a-zA-Z\_]+)$/is', $dirname)){
            $newdir = $folder . $dirname;
            $code = $this->_aliossService->createObjectDir($newdir);
            if($code == null){
                $this->showMessage('目录创建成功！', U( 'Base/Tool/alimanage') . '?folder=' . $newdir . '/');
            }else{
                $this->showWarning('目录创建失败！');
            }
        }else{
            $this->showWarning('非法的目录名！');
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