<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
//        Log::info('request arrived.');
        $app = app('wechat.official_account');
//        return '';
//        return '';
//        $message = $app->server->getMessage();
//        Log::info($message);
        $app->server->push(function($message){
            return 'ok';
        });

//        Log::info('return response.');
        return $app->server->serve();
    }
}
