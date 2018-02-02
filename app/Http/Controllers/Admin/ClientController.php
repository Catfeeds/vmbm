<?php

namespace App\Http\Controllers\Admin;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('keyword') && $request->input('keyword')) {
            $keyword = '%' . $request->input('keyword') . '%';
            $list = Client::where('name', 'like', $keyword)->withCount('devices')->orderBy('updated_at', 'desc')->paginate();
        } else {
            $list = Client::withCount('devices')->orderBy('updated_at', 'desc')->paginate();
        }
        return view('admin.client.index', compact('list'));
    }

    public function create(Request $request)
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        if($request->method() != 'POST') return back();
        $res = Client::create($request->all());
        if(! $res) return $this->showWarning('新建客户失败！');
        return $this->showMessage('新建成功！', '/admin/client/index');
    }

    public function device(Request $request)
    {
        if(!$request->has('id') || ($client = Client::find($request->input('id'))) == null) return $this->showWarning('客户不存在！');
        $list = Device::where('client_id', $client->id)->orderBy('updated_at', 'desc')->paginate();
        return view('admin.client.device', compact('client', 'list'));
    }

    public function edit(Request $request)
    {
        if(!$request->has('id') || ($item = Client::find($request->input('id'))) == null) return back();
        return view('admin.client.edit', compact('item'));
    }

    public function update(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Client::find($request->input('id'))) == null) return $this->showWarning('找不到客户！');
        $arr = $request->all();
        unset($arr['_token']);
        $res = Client::where('id', $request->input('id'))->update($arr);
        if(!$res) return $this->showWarning('数据库更新失败！');
        return $this->showMessage('更新成功！', '/admin/client/index');
    }

    public function destroy(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Client::find($request->input('id'))) == null) return $this->showWarning('找不到客户！');
        if(!$item->delete()) return $this->showWarning('删除失败！');
        return $this->showMessage('删除成功！', '/admin/device/index');
    }
}
