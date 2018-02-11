<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('keyword') && $request->input('keyword')) {
            $keyword = $request->input('keyword');
            $list = Device::with(['client'])->orderBy('updated_at', 'desc')->get()->filter(function ($value) use($keyword) {
                if(!(strpos($value->name, $keyword) === false)) return true;
                if($value->client && !(strpos($value->client->name, $keyword) === false)) return true;
                return false;
            });
            $list = $this->paginate($list);
        } else {
            $list = Device::with(['client'])->orderBy('updated_at', 'desc')->paginate();
        }
        return view('admin.device.index', compact('list'));
    }

    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function create(Request $request)
    {
        $clients = Client::all();
        return view('admin.device.create', compact('clients'));
    }

    public function detail(Request $request)
    {
        if(!$request->has('id') || ($item = Device::find($request->input('id'))) == null) return back();
        return view('admin.device.detail', compact('item'));
    }

    public function edit(Request $request)
    {
        if(!$request->has('id') || ($item = Device::find($request->input('id'))) == null) return back();
        $clients = Client::orderBy('updated_at', 'desc')->get();
        return view('admin.device.edit', compact('item', 'clients'));
    }

    public function store(Request $request)
    {
        if($request->method() != 'POST') return back();
        $validator = Validator::make($request->all(), [
            'IMEI' => 'required|unique:devices'
        ], [
            'IMEI.unique' => 'IMEI已存在！'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $request->all();
        $app = app('wechat.official_account');
        $result = $app->qrcode->forever($data['IMEI']);
        $data['ticket'] = $result['ticket'];
        $res = Device::create($data);
        if(! $res) return $this->showWarning('新建设备失败！');

        return $this->showMessage('新建成功！', '/admin/Device/index');
    }

    public function update(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Device::find($request->input('id'))) == null) return $this->showWarning('找不到设备！');
        $arr = $request->all();
        unset($arr['_token']);
        $res = Device::where('id', $request->input('id'))->update($arr);
        if(!$res) return $this->showWarning('数据库更新失败！');
        return $this->showMessage('更新成功！', '/admin/Device/index');
    }

    public function changeAuthStatus(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Device::find($request->input('id'))) == null) return $this->showWarning('找不到设备！');
        if(!$request->has('auth_status')) return back();
        $item->auth_status = $request->input('auth_status');
        if(!$item->saveOrFail()) return $this->showWarning('数据库保存失败！');
        return $this->showMessage('操作成功！', '/admin/Device/index');
    }

    public function destroy(Request $request)
    {
        if($request->method() != 'POST') return back();
        if(!$request->has('id') || ($item = Device::find($request->input('id'))) == null) return $this->showWarning('找不到设备！');
        if(!$item->delete()) return $this->showWarning('删除失败！');
        return $this->showMessage('删除成功！', '/admin/Device/index');
    }
}
