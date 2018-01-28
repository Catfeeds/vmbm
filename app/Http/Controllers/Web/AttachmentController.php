<?php

namespace App\Http\Controllers\Web;

use App\Models\BaseAttachmentModel;
use Response;

class AttachmentController extends Controller
{

    public function download($md5)
    {
        $attachment = BaseAttachmentModel::where(['md5' => $md5])->first();
        if (!$attachment) {
            return view('errors.404');
        }

        return Response::download($attachment->path, $attachment->name, [
            'Content-type'  => $attachment->file_type,
            'Accept-Ranges' => 'bytes',
            'Accept-Length' => $attachment->size,
        ]);
    }

    public function image($md5)
    {
        $attachment = BaseAttachmentModel::where(['md5' => $md5])->first();
        if (!$attachment) {
            return view('errors.404');
        }
        return Response::download($attachment->path, $attachment->name, [
            'Content-type'  => $attachment->file_type,
            'Accept-Ranges' => 'bytes',
            'Accept-Length' => $attachment->size,
        ], 'inline');
    }

}
