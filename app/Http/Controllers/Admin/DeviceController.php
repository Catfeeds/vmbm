<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $list = Device::paginate();
        return view('admin.device.index', compact('list'));
    }
}
