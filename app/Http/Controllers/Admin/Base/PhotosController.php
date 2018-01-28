<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Base\Attachment;
use App\Models\BaseAttachmentModel;
use App\Models\ClassModel;
use Illuminate\Http\Request as HttpRequest;
use Request;
use File;

class PhotosController extends Controller
{
    private $_serviceAttachment;

    public function __construct()
    {
        if( !$this->_serviceAttachment ) $this->_serviceAttachment = new Attachment();
    }

    public function index(HttpRequest $request)
    {
        $classes = ClassModel::all();
        $a_class = $request->has('class') ? $request->input('class') : null;
        if(($a_class = ClassModel::find($a_class)) == null) {
            $a_class = ClassModel::first();
        }
        $photos = null;
        $status = 'normal';
        if($request->has('search')) {
            $name = '%' . $request->input('search') . '%';
            $photos = BaseAttachmentModel::where('name', 'like', $name)->get();
            $status = 'search';
        } else {
            if($a_class){
                $photos = BaseAttachmentModel::where('class', $a_class->class)->get();
            }
        }

    	return view('admin.base.photos.index', compact('photos', 'classes', 'a_class', 'photos', 'status', 'photo_compress_quality'));
    }

    public function edit(HttpRequest $request)
    {
        if(Request::method() != 'POST') {
            return back();
        }

        if($request->has('img-name') && $request->has('img-id')) {
            $photo = BaseAttachmentModel::find($request->input('img-id'));
            $photo->name = $request->input('img-name');
            $photo->save();
        }

        return back();
    }

    public function move(HttpRequest $request)
    {
        if(Request::method() != 'POST') {
            return back();
        }

        $ids = explode(',', $request->input('ids'));
        $class = ClassModel::find($request->input('class'));
        BaseAttachmentModel::whereIn('id', $ids)->update(['class' => $class->class]);
        return back();
    }

    public function delete(HttpRequest $request)
    {
        if(Request::method() != 'POST') {
            return back();
        }

        $ids = explode(',', $request->input('ids'));
        $photos = BaseAttachmentModel::find($ids);
        foreach($photos as $photo) {
            File::delete($photo->path);
            $photo->delete();
        }
        return back();
    }

    public function crop(HttpRequest $request)
    {
        if(Request::method() != 'POST') {
            return back();
        }

        $this->_serviceAttachment->localUpload('file', $request->all());

        return response()->json(['status' => 'ok'], 200);
    }
}
