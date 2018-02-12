<?php

namespace App\Http\Controllers\Web;

use App\Models\AD;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return view('web.index.index');
    }

    public function get(Request $request)
    {
        $ad = AD::first();
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        return view('web.index.index');
    }

    public function buy(Request $request)
    {
        return view('web.index.index');
    }
}
