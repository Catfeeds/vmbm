<?php

namespace App\Http\Controllers\Admin;

use App\Models\AD;
use App\Models\Device;
use App\Models\Fan;
use App\Models\Tissue;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TissueController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('keyword') && $request->input('keyword')) {
            $keyword = $request->input('keyword');
            $list = Tissue::where('wechat_id', 'like', $keyword)->orWhere('wechat_name', 'like', $keyword)->orderBy('updated_at', 'desc')->paginate();
        } else {
            $list = Tissue::orderBy('updated_at', 'desc')->paginate();
        }
        return view('admin.tissue.index', compact('list'));
    }

    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function create()
    {
        $fans = Fan::all();
        $devices = Device::all();
        $ads = AD::all();
        return view('admin.tissue.create', compact('fans', 'devices', 'ads'));
    }

    public function store(Request $request)
    {
        if($request->method() != 'POST') return back();
        $res = Tissue::create($request->all());
        if(! $res) return $this->showWarning('新建纸巾失败！');
        return $this->showMessage('新建成功！', '/admin/Tissue/index');
    }

    public function detail(Request $request)
    {
        if(!$request->has('id') || ($item = Tissue::find($request->input('id'))) == null) return back();
        return view('admin.tissue.detail', compact('item'));
    }

    public function edit(Request $request)
    {
        $fans = Fan::all();
        $devices = Device::all();
        $ads = AD::all();
        if(!$request->has('id') || ($tissue = Tissue::find($request->input('id'))) == null) return back();
        return view('admin.tissue.edit', compact('tissue', 'fans', 'devices', 'ads'));
    }

    public function update(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Tissue::find($request->input('id'))) == null) return $this->showWarning('找不到纸巾！');
        $arr = $request->all();
        unset($arr['_token']);
        $res = Tissue::where('id', $request->input('id'))->update($arr);
        if(!$res) return $this->showWarning('数据库更新失败！');
        return $this->showMessage('更新成功！', '/admin/Tissue/index');
    }

    public function destroy(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Tissue::find($request->input('id'))) == null) return $this->showWarning('找不到纸巾！');
        if(!$item->delete()) return $this->showWarning('删除失败！');
        return $this->showMessage('删除成功！', '/admin/Tissue/index');
    }
}
