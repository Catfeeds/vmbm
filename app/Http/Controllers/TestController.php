<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class TestController extends Controller
{
    public function index(Request $request)
    {
          $app = app('wechat.official_account');
//        $buttons = [
//            [
//                "type" => "view",
//                "name" => "纸妹子",
//                "url"  => "http://47.104.165.93/user"
//            ]
//        ];
//        $res = $app->menu->delete(); // 全部
//        return $res;
        $openId = 'oTIRp1f-L2Auc0hVQvywEh7lwU-s';
        $user = $app->user->get($openId);
        dd($user);
    }
}
