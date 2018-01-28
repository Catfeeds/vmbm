<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\AttachmentHelper;
use Illuminate\Http\Request;
use App\Services\Base\Attachment;
use App\Services\Base\ErrorCode;
use Validator, Response;

class AttachmentController extends Controller
{
    use AttachmentHelper;

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
    public function download($md5)
    {
        $attachment = Attachment::where(['md5' => $md5])->first();
        if (!$attachment) {
            return view('errors.404');
        }

        return Response::download($attachment->path, $attachment->name, [
            'Content-type'  => $attachment->file_type,
            'Accept-Ranges' => 'bytes',
            'Accept-Length' => $attachment->size,
        ]);
    }

    /**
     * @api {post} /api/attachment/upload 通用上传接口
     * @apiDescription 通用上传接口
     * @apiGroup Attachment
     * @apiPermission none
     * @apiVersion 0.1.0
     * @apiParam {string} tag 附件标签 avatar video dream
     * @apiParam {File} file 附件（可以多个，使用file.xxx，可返回多个）[默认大小【10M】, 类型图片png jpg gif,视频类型mp4]
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "state": true,
     *     "code": 0,
     *     "message": "",
     *     "data": [
     *         "file": "f72e7dad80f597ed6621a009e82243ad",
     *          //文件访问url http://localhost/attachment/f72e7dad80f597ed6621a009e82243ad
     *     ]
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *     "state": false,
     *     "code": 1000,
     *     "message": "传入参数不正确",
     *     "data": null or []
     * }
     * 可能出现的错误代码：
     *    200     SAVE_USER_FAILED                保存用户数据失败
     *    201     ATTACHMENT_MKDIR_FAILED         创建附件目录失败
     *    202     ATTACHMENT_UPLOAD_INVALID       上传附件文件无效
     *    203     ATTACHMENT_SAVE_FAILED          保存附件失败
     *    204     ATTACHMENT_MOVE_FAILED          移动附件失败
     *    205     ATTACHMENT_DELETE_FAILED        删除附件文件失败
     *    206     ATTACHMENT_RECORD_DELETE_FAILED 删除附件记录失败
     *    1000    CLIENT_WRONG_PARAMS             传入参数不正确
     *    1101    INCORRECT_VERIFY_CODE           输入验证码错误
     *    1105    USER_DOES_NOT_EXIST             用户不存在
     *    1200    ATTACHMENT_UPLOAD_FAILED        附件上传失败
     *    1201    ATTACHMENT_SIZE_EXCEEDED        附件大小超过限制
     *    1202    ATTACHMENT_MIME_NOT_ALLOWED     附件类型不允许
     *    1203    ATTACHMENT_NOT_EXIST            附件不存在
     */
    public function upload(Request $request) {
        \Log::info($request->all());
        $validator = Validator::make($request->all(),
            [
                'tag'         => 'required|alpha_dash',
            ],
            [
                'tag.required'      => 'tag必填',
                'tag.alpha_dash'    => 'tag只能为字母数字中/下划线',
            ]
        );

        if ($validator->fails()) {
            return $this->error(ErrorCode::CLIENT_WRONG_PARAMS, '', $validator->messages());
        }

        $result = $this->uploadAttachment($request, $request->get('file'), $request->get('tag'), 10 * 1024 * 1024, [
            'image/jpeg',
            'image/png',
            'image/gif',
            'video/mp4',
        ]);
        if (is_array($result)) {
            return $this->api($result);
        } elseif (is_string($result)) {
            return $this->api(['file' => $result]);
        } else {
            return $this->error($result);
        }

    }

    /**
     * @api {get} /api/attachment/delete/{md5} 删除文件（图片）
     * @apiDescription 删除文件（图片）
     * @apiGroup Attachment
     * @apiPermission Passport
     * @apiVersion 0.1.0
     * @apiParam {string} md5   图片md5码
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "state": true,
     *     "code": 0,
     *     "message": "",
     *     "data": {
     *         "result": true/false
     *     }
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *     "state": false,
     *     "code": 1000,
     *     "message": "传入参数不正确",
     *     "data": null or []
     * }
     * 可能出现的错误代码：
     *    205     ATTACHMENT_DELETE_FAILED        删除附件文件失败
     *    206     ATTACHMENT_RECORD_DELETE_FAILED 删除附件记录失败
     *    1203    ATTACHMENT_NOT_EXIST            附件不存在
     */
    public function delete($md5) {
        $result = $this->deleteAttachment($md5);
        if ($result === 0) {
            return $this->api(['result' => true]);
        } else {
            return $this->error($result);
        }
    }

}
