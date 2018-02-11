<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Device;
use Log;

class TestController extends Controller
{
    public function index(Request $request)
    {
          $app = app('wechat.official_account');
            $app->broadcasting->sendText("oh m");
          Log::info('rrrr');
          return 'ccc';
//        $buttons = [
//            [
//                "type" => "view",
//                "name" => "纸妹子",
//                "url"  => "http://47.104.165.93/user"
//            ]
//        ];
//        $res = $app->menu->delete(); // 全部
//        return $res;
//        $openId = 'oTIRp1f-L2Auc0hVQvywEh7lwU-s';
//        $user = $app->user->get($openId);
//        dd($user);
    }

    public function qrcode(Request $request)
    {
        $app = app('wechat.official_account');
        $result = $app->qrcode->forever(666);
        $ticket = $result['ticket'];
        $url = $app->qrcode->url($ticket);
        dd($result, $url);
    }

    public function time(Request $request)
    {
        dd(Carbon::now());
    }
}
