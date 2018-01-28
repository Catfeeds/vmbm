<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request as HttpRequest;
use App\Http\Controllers\Admin\Controller;
use App\Models\ClassModel;
use App\Models\BaseAttachmentModel;
use Request, Response, Validator, File;

class ClassController extends Controller
{
    public function add(HttpRequest $request)
    {
    	if(! $request->has('class') || Request::method() != 'POST') {
    		return back();
    	}

    	$validator = Validator::make($request->all(), [
            'class' => 'required|string|max:100|unique:classes,class',
        ]);
    	if($validator->fails()) {
    		$validator->errors()->add('my-error', '分类已存在！');
    		return back()->withErrors($validator)->withInput();
    	}
    	
    	$class = new ClassModel;
    	$class->class = $request->input('class');
    	if(! $class->save()) {
    		$validator->errors()->add('my-error', '添加分类失败！');
    		return back()->withErrors($validator)->withInput();
    	}

    	return back();
    }

    public function delete(HttpRequest $request)
    {
        if(Request::method() != 'POST') {
            return back();
        }

        $class = null;
        if($request->has('class') && ($class = ClassModel::find($request->input('class'))) != null) {
            if($class->class == '未分类') {
                return back();
            }

            $photos = BaseAttachmentModel::where('class', $class->class)->get();
            foreach($photos as $photo) {
                File::delete($photo->path);
                $photo->delete();
            }
            $class->delete();
        }
        return redirect('admin/Base/Photos/index');
    }
}
