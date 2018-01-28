<?php
namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Services\Base\ErrorCode;
use App\Models\BaseAttachmentModel;

trait AttachmentHelper
{
    /**
     * 上传附件
     *
     * @param Request $request  laravel's http request
     * @param string|array $key 文件key
     * @param string $tag       文件tag
     * @param int $size         文件size限制，默认2M
     * @param array $mimeType   文件mime类型限制，默认不限
     * @return array|string|int 返回：md5字串|ErrorCode或[md5字串|ErrorCode]
     */
    public function uploadAttachment(Request $request, $key, $tag = 'files', $size = 10 * 1024 * 1024, array $mimeType = []) {
        if ($request->hasFile($key)) {
            $rel_path = '/upload/' . $tag . '/' . date('Ymd');
            $path = public_path() . $rel_path;
            if (!file_exists($path)) {
                if (!@mkdir($path, 0755, true)) {
                    return ErrorCode::ATTACHMENT_MKDIR_FAILED;
                }
            }

            $files = $request->file($key);
            if ($files === null) {
                return ErrorCode::ATTACHMENT_UPLOAD_INVALID;
            }
            if ($files instanceof UploadedFile) {
                $files = [$files];
            }

            $result = [];
            foreach ($files as $idx => $file) {
                if (!$file->isValid()) {
                    $result[$idx] = ErrorCode::ATTACHMENT_UPLOAD_INVALID;
                    continue;
                }

                $fileSize = $file->getSize();
                if ($fileSize > $size) {
                    $result[$idx] = ErrorCode::ATTACHMENT_SIZE_EXCEEDED;
                    continue;
                }

                $fileMimeType = $file->getMimeType();
                \Log::info("fileMimeType:".$fileMimeType);
                if (!empty($mimeType) && !in_array($fileMimeType, $mimeType)) {
                    $result[$idx] = ErrorCode::ATTACHMENT_MIME_NOT_ALLOWED;
                    continue;
                }

                $clientName = $file->getClientOriginalName();
                $md5 = md5($clientName . time());
                $md5_filename = $md5 . '.' . $file->getClientOriginalExtension();

                try {
                    $file->move($path, $md5_filename);

                    $real_path = $path . '/' . $md5_filename;
                    $url_path = $rel_path . '/' . $md5_filename;

                    $attachment = new BaseAttachmentModel();
                    $attachment->name = $clientName;
                    $attachment->md5 = $md5;
                    $attachment->path = $real_path;
                    $attachment->url = $url_path;
                    $attachment->size = $fileSize;
                    $attachment->file_type = $fileMimeType;
                    if ($attachment->save()) {
                        $result[$idx] = $md5;
                    } else {
                        @unlink($real_path);
                        $result[$idx] = ErrorCode::ATTACHMENT_SAVE_FAILED;
                    }
                } catch (FileException $e) {
                    $result[$idx] = ErrorCode::ATTACHMENT_MOVE_FAILED;
                }
            }
            if (count($result) == 1) {
                return array_shift($result);
            }
            return $result;
        } else {
            return ErrorCode::ATTACHMENT_UPLOAD_INVALID;
        }

    }

    /**
     * 删除附件
     *
     * @param $md5 string 删除文件的md5码
     * @return int 错误码or 0（成功）
     */
    public function deleteAttachment($md5) {
        $attachment = Attachment::where(['md5' => $md5])->first();
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