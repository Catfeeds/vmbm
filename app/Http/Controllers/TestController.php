<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $buttons = [
            [
                "type" => "view",
                "name" => "纸妹子",
                "url"  => "http://47.104.165.93/user"
            ]
        ];
        $app = app('wechat.official_account');
        $app->menu->delete();
        $app->menu->create($buttons);
        return 'ok';
    }
}
