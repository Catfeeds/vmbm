<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fan;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FanController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('keyword') && $request->input('keyword')) {
            $keyword = $request->input('keyword');
            $list = Fan::where('wechat_id', 'like', $keyword)->orWhere('wechat_name', 'like', $keyword)->orderBy('updated_at', 'desc')->paginate();
        } else {
            $list = Fan::orderBy('updated_at', 'desc')->paginate();
        }
        return view('admin.fan.index', compact('list'));
    }

    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function create()
    {
        return view('admin.fan.create');
    }

    public function store(Request $request)
    {
        if($request->method() != 'POST') return back();
        $res = Fan::create($request->all());
        if(! $res) return $this->showWarning('新建粉丝失败！');
        return $this->showMessage('新建成功！', '/admin/Fan/index');
    }

    public function detail(Request $request)
    {
        if(!$request->has('id') || ($item = Fan::find($request->input('id'))) == null) return back();
        return view('admin.fan.detail', compact('item'));
    }

    public function edit(Request $request)
    {
        if(!$request->has('id') || ($item = Fan::find($request->input('id'))) == null) return back();
        return view('admin.fan.edit', compact('item'));
    }

    public function update(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Fan::find($request->input('id'))) == null) return $this->showWarning('找不到粉丝！');
        $arr = $request->all();
        unset($arr['_token']);
        $res = Fan::where('id', $request->input('id'))->update($arr);
        if(!$res) return $this->showWarning('数据库更新失败！');
        return $this->showMessage('更新成功！', '/admin/Fan/index');
    }

    public function destroy(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Fan::find($request->input('id'))) == null) return $this->showWarning('找不到粉丝！');
        if(!$item->delete()) return $this->showWarning('删除失败！');
        return $this->showMessage('删除成功！', '/admin/Fan/index');
    }
}
