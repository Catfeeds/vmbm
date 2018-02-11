<?php

namespace App\Http\Controllers;

use App\Events\Scan;
use App\Events\Subscribe;
use App\Events\Unsubscribe;
use App\Models\Fan;
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
        $app = app('wechat.official_account');
        $app->server->push(function($message) {
            Log::info($message);
            switch ($message['MsgType'])
            {
                case 'event':
                    if($message['Event'] == 'subscribe') {
                        event(new Subscribe($message));
                    } elseif($message['Event'] == 'unsubscribe') {
                        event(new Unsubscribe($message));
                    } elseif($message['Event'] == 'SCAN') {
                        event(new Scan($message));
                    }
                    break;
                default:
                    break;
            }
            return 'ok';
        });

//        Log::info('return response.');
        return $app->server->serve();
    }
}
