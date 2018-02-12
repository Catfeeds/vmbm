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
//          $id = '演示PHP-MYSQL';
//          $item1 = urlencode($id);
//          $item2 = urldecode($item1);
//          dd($id, $item1, $item2);
//          dd($app->server->push());
//            $app->broadcasting->sendText("考研");
//          Log::info('rrrr');
//          return '考研';
        $buttons = [
            [
                "type" => "view",
                "name" => "纸妹子",
                "url"  => "http://47.104.165.93/web/user"
            ]
        ];
        $app->menu->delete(); // 全部
        $res = $app->menu->create($buttons);
//        return $res;
//        $openId = 'oTIRp1f-L2Auc0hVQvywEh7lwU-s';
        dd($res);
    }

    public function qrcode(Request $request)
    {
        $app = app('wechat.official_account');
        $result = $app->qrcode->forever('abcde');
        $ticket = $result['ticket'];
        $url = $app->qrcode->url($ticket);
        dd($ticket, $url);
    }

    public function time(Request $request)
    {
        dd(Carbon::now());
    }

    public function device(Request $request)
    {
        $device = Device::where('IMEI', 'abcde')->first();
        dd($device);
    }
}
