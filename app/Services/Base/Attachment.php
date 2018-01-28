<?php
/**
 *------------------------------------------------------
 * BaseProcess.php
 *------------------------------------------------------
 *
 * @author    Mike
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */

namespace App\Services\Base;

use App\Models\BaseAttachmentModel;
use Response;
use App\Models\BaseSettingsModel;
use Image;
class Attachment
{
    private $_model;

    public function __construct() {
        if( !$this->_model ) $this->_model = new BaseAttachmentModel();
    }

    public function aliUpload(){

    }

    public function specialUpload(){

    }


    public function _uploadfiles(){

    }


    public function _jsonMessage($status,$ret){
        $ret['code'] = $status;
        return $ret;
    }
//    /**
//     * 上传到本地服务器
//     * @param $field
//     * @param $request
//     */
//    public function localUpload($field = '', $request = array())
//    {
//        $uploadfiles = $this->_uploadfiles($field);
//        if(!$uploadfiles){
//            return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '没有文件被上传']);
//        }
//
//        //文件夹路径
//        $folder = isset($request['folder']) ? $request['folder'] : 'common';
//
//        //上传的文件名是否MD5
//        $is_md5 = isset($request['is_md5']) ? $request['is_md5'] : 1;
//        if($is_md5){
//            $fileurl = $folder . '/' . md5_file($uploadfiles[0]['tmp_name']);
//        }else{
//            $fileName = basename($uploadfiles[0]['name'], "." . substr(strrchr($uploadfiles[0]['name'], '.'), 1));
//            $fileurl = $folder . '/' . $fileName;
//        }
//
//        $filePath = public_path() . DIRECTORY_SEPARATOR . $fileurl;
//        $dirPath = public_path() . DIRECTORY_SEPARATOR .$folder;
//
//        //创建目录
//        if(!is_dir($dirPath)){
//            @mkdir($dirPath, 0755, true)
////            $this->_dirUtil->dirCreate($dirPath);
//        }
//        /*if(!file_exists($filePath)){
//            $this->_dirUtil->dirCreate($filePath);
//        }*/
//
//        //获取文件后缀名
//        $fileext = strtolower(trim(substr(strrchr($uploadfiles[0]['name'], '.'), 1, 10)));
//
//        //判断是否需要解包
//        $is_extract = isset($request['is_extract']) ? $request['is_extract'] : 0;
//        if($is_extract && $fileext == 'zip'){   //ZIP解压
//
////            $message = $this->_zipTool($uploadfiles[0]['tmp_name'], $filePath);
//
//        }elseif($is_extract && $fileext == 'rar'){  //RAR解压
//
//            if(!get_extension_funcs('rar')){
//                return $this->_jsonMessage(500, $request['elementid'], ['message' => '没有发现RAR扩展库']);
//            }else{
////                $message = $this->_rarTool($uploadfiles[0]['tmp_name'], $filePath);
//            }
//
//        }else{
//
//            $fileurl = $filePath . '.' . $fileext;
//            if(move_uploaded_file($uploadfiles[0]['tmp_name'], $fileurl)){
//                $fileurl = trim(str_replace(public_path(), '', $fileurl), '\\');
//                return $this->_jsonMessage(SUCESS_CODE, $request['elementid'], ['message' => '文件上传成功', 'fileurl' => $fileurl]);
//            }else{
//                return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '文件上传成功', 'fileurl' => '']);
//            }
//
//        }
//            $attachment = new BaseAttachmentModel();
//            $attachment->name = $clientName;
//            $attachment->md5 = $md5;
//            $attachment->path = $real_path;
//            $attachment->url = $url_path;
//            $attachment->size = $fileSize;
//            $attachment->file_type = $fileMimeType;
//            if ($attachment->save()) {
//                $result = 'Foundation/Attachment/download/?md5='.$md5;
//            } else {
//                @unlink($real_path);
//                $result= ErrorCode::ATTACHMENT_SAVE_FAILED;
//            }
//        if($message['code'] == 200){
//            //修改文件夹为只读属性
//            //chmod($filePath, 0444);
//        }else{
//            if(file_exists($filePath)){
//                rmdir($filePath);
//            }
//        }
//        return $this->_jsonMessage($message['code'], $request['elementid'], ['message' => $message['message'], 'fileurl' => $fileurl,'name'=>basename($uploadfiles[0]['name'], '.' . $fileext)]);
//    }

    /**
     * 上传附件
     *
     * @param string|array $field 文件key
     * @param Request $request  laravel's http request
     * @param string $tag       文件tag
     * @param int $size         文件size限制，默认2M
     * @param array $mimeType   文件mime类型限制，默认不限
     * @return array|string|int 返回：md5字串|ErrorCode或[md5字串|ErrorCode]
     */


    public function localUpload($field, $request, $tag = 'files', $size = 10 * 1024 * 1024, array $mimeType = ['image/jpeg', 'image/png', 'image/gif','video/mp4','video/quicktime'])
    {

        $tag = $request['folder'];
        $class = isset($request['class']) ? $request['class'] : '未分类';
        $sizex = isset($request['sizex']) ? $request['sizex'] : 0;
        $sizey = isset($request['sizey']) ? $request['sizey'] : 0;
        $rel_path = $tag . '/' . date('Ymd');
        $path = public_path() . $rel_path;
        // dd($request);
        if (!file_exists($path)) {
            if (!@mkdir($path, 0755, true)) {
//              return ErrorCode::ATTACHMENT_MKDIR_FAILED;
                return $this->_jsonMessage(500,  ['message' => '目录创建失败']);
            }
        }

        $file = $request[$field];
        if ($file === null) {
            return $this->_jsonMessage(500,  ['message' => '没有文件被上传']);
        }
        if (!$file->isValid()) {
            return $this->_jsonMessage(500,  ['message' => '不允许上传']);
        }

        $fileSize = $file->getSize();
        if ($fileSize > $size) {
//            $result[$idx] = ErrorCode::ATTACHMENT_SIZE_EXCEEDED;
            return $this->_jsonMessage(500,  ['message' => '文件大小超过限制']);
        }
        $fileMimeType = $file->getMimeType();
        if (!empty($mimeType) && !in_array($fileMimeType, $mimeType)) {
            return $this->_jsonMessage(500,  ['message' => '文件格式不被允许']);
        }
        $clientName = $file->getClientOriginalName();
        $md5 = md5($clientName . time());
        $md5_filename = $md5 . '.' . $file->getClientOriginalExtension();

        if(isset($request['from']) && $request['from'] == 'crop') {
            $clientName = isset($request['name']) ? $request['name'] : '裁剪.png';
            $md5_filename = $md5_filename . 'png';
        }

        try {
            if(!$file->move($path, $md5_filename)){
                return $this->_jsonMessage(500,  ['message' => '上传失败']);
            }

//            $quality = 75;
//            $modal = null;
//            if(($modal = BaseSettingsModel::where('key', env('PHOTO_COMPRESS_QUALITY_KEY'))->first()) != null) {
//                $quality = $modal->value;
//            }

            $real_path = $path . '/' . $md5_filename;
            $url_path = $rel_path . '/' . $md5_filename;

            $source_info = null;
            if(($source_info = getimagesize($real_path)) != null) {
                $source_width = $source_info[0];
                $source_height = $source_info[1];
                \Log::info('$source_width'.$source_width.'$source_height'.$source_height);
                if($sizex || $sizey){
                    if($sizex==0){
                        $sizex = $source_width*($sizey/$source_height);
                    }
                    if($sizey==0){
                        $sizey = $source_height*($sizex/$source_width);
                    }
                    \Log::info('$sizex'.$sizex.'$sizey'.$sizey);
                    Image::make($real_path)->resize($sizex, $sizey)->save($real_path);
                }
            }

            $attachment = new BaseAttachmentModel();
            $attachment->name = $clientName;
            $attachment->md5 = $md5;
            $attachment->path = $real_path;
            $attachment->url = $url_path;
            $attachment->size = $fileSize;
            $attachment->file_type = $fileMimeType;
            $attachment->class = $class;
            if ($attachment->save()) {
                return $this->_jsonMessage(200,  ['message' => "上传成功", 'fileurl' => $url_path,'name'=>$md5_filename]);

            } else {
                @unlink($real_path);
                return $this->_jsonMessage(500,  ['message' => '数据库保存错误']);
//                $result= ErrorCode::ATTACHMENT_SAVE_FAILED;
            }
        } catch (FileException $e) {
            return $this->_jsonMessage(500,  ['message' => '上传失败']);
//            $result = ErrorCode::ATTACHMENT_MOVE_FAILED;
        }
    }

    /**
     * 删除附件
     *
     * @param $md5 string 删除文件的md5码
     * @return int 错误码or 0（成功）
     */
    public function deleteAttachment($md5) {
        $attachment = $this->_model->where(['md5' => $md5])->first();
        if (!$attachment) {
            return ErrorCode::ATTACHMENT_NOT_EXIST;
        }
        if (file_exists($attachment->path)) {
            if (@unlink($attachment->path)) {
                if ($attachment->delete()) {
                    return 0;
                } else {
                    return ErrorCode::ATTACHMENT_RECORD_DELETE_FAILED;
                }
            } else {
                return ErrorCode::ATTACHMENT_DELETE_FAILED;
            }
        } else {
            return ErrorCode::ATTACHMENT_NOT_EXIST;
        }

    }

}
