<?php

namespace App\Listeners;

use App\Events\Unsubscribe as UnsubscribeEvent;
use App\Models\Fan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class Unsubscribe
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Unsubscribe  $event
     * @return void
     */
    public function handle(UnsubscribeEvent $event)
    {
        $message = $event->message;
        $openId = $message['FromUserName'];
        $fan = Fan::where('wechat_id', $openId)->first();
        if(!$fan) {
            Log::info('取消关注时，找不到粉丝！');
            return;
        };
        $fan->status = 0;
        $res = $fan->save();
        if(!$res) {
            Log::info('取消关注时，粉丝保存失败！');
            return;
        }
        Log::info('取消关注成功！');
        return;
    }
}
