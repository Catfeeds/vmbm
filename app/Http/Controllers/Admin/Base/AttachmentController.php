<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Base\Attachment;
use App\Models\BaseAttachmentModel;
use Request, Response;

class AttachmentController extends Controller
{
    private $_serviceAttachment;
    private $_serviceAttachmentBbs;
    private $_serviceForumAttachment;
    private $_serviceForumAttachmentUnused;

    public function __construct()
    {
        if( !$this->_serviceAttachment ) $this->_serviceAttachment = new Attachment();

    }


    /**
     * SWFUpload文件上传
     */
    public function upload()
    {
        $request = Request::all();

        //通过上传控件ID,区分文件上传类型
        if(isset($request['elementid']) && substr($request['elementid'], 0, 15) == 'upload_template'){

            $this->_uploadTemplate($request);

            //上传到本地
        }elseif(isset($request['position']) && $request['position'] == 'local'){

            $this->_uploadToServer($request);

            //上传专题文件
        }elseif(isset($request['position']) && $request['position'] == 'special'){

            $this->_uploadSpecial($request);

            //上传到阿里云
        } else{

            $this->_uploadToAlioss($request);

        }
    }


    /**
     * 上传到本地
     */
    private function _uploadToServer($request)
    {
        $return = $this->_serviceAttachment->localUpload('imgFile', $request);
        if($return['code']=='200'){
            echo json_encode(["error"=> 0,"url" => config('app.url').$return['fileurl']]);exit;
        }else{

            echo json_encode(["error" => 1,"message" =>  $return['message']]);exit;
        }
    }

    /**
     * 上传专题文件
     */
    private function _uploadSpecial($request)
    {
        $return = $this->_serviceAttachment->specialUpload('Filedata', $request);
        echo json_encode($return);exit;
    }

    /**
     * 上传到阿里云
     */
    private function _uploadToAlioss($request)
    {
        $return = [];
        if(isset($request['KindEditor'])){
            $data = $this->_serviceAttachment->aliUpload($request['field'], $request);
            if($data['code'] === 200){
                $return['error'] = 0;
                $return['url']   = $data['fileurl'];
            }else{
                $return['error']    = 1;
                $return['message']  = $data['message'];
            }
        }else{
            $return = $this->_serviceAttachment->aliUpload('Filedata', $request);
        }
        echo json_encode($return);exit;
    }

    /**
     * 控件上传
     */
    public function webupload()
    {
        $request = request()->all();
        $data = $this->_serviceAttachment->localUpload('file', $request, 'files');
//        return response()->json(array('data' => $data), 200);
        echo json_encode($data);exit;
    }


    /**
     * @api {get} /api/attachment/download/{md5} 下载文件（图片）
     * @apiDescription 下载文件（图片）(get code)
     * @apiGroup Attachment
     * @apiPermission none
     * @apiVersion 0.1.0
     * @apiParam {string} md5   图片md5码
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       文件二进制码
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not found
     */
    public function download()
    {
        $request = Request::all();
        $attachment = BaseAttachmentModel::where(['md5' => $request['md5']])->first();
        if (!$attachment) {
            return view('errors.404');
        }

        return Response::download($attachment->path, $attachment->name, [
            'Content-type'  => $attachment->file_type,
            'Accept-Ranges' => 'bytes',
            'Accept-Length' => $attachment->size,
        ]);
    }




    private function _createAttachmentRecord($data)
    {
        $uid = Request::input('uid');
        $aid = $this->_serviceForumAttachment->create(['tid' => 0, 'pid' => 0, 'uid' => $uid, 'tableid' => 127]);
        if($aid){
            $info = [
                'aid'           => $aid,
                'uid'           => $uid,
                'dateline'      => SYSTEM_TIME,
                'filename'      => $data['filename'],
                'filesize'      => $data['filesize'],
                'attachment'    => $data['attachment'],
                'isimage'       => (isset($data['width']) && $data['width']) ? 1 : 0,
                'remote'        => 1,
                'width'         => isset($data['width']) ? $data['width'] : 0,
                'thumb'         => 0,
            ];
            if(!$this->_serviceForumAttachmentUnused->create($info)){
                return 0;
            }
        }
        return $aid;
    }

}
