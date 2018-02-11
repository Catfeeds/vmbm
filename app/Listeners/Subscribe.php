<?php

namespace App\Listeners;

use App\Events\Subscribe as SubscribeEvent;
use App\Models\Device;
use App\Models\Fan;
use App\Models\Record;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class Subscribe
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
     * @param  Subscribe  $event
     * @return void
     */
    public function handle(SubscribeEvent $event)
    {
        $message = $event->message;
        $device = Device::where('ticket', $message['Ticket'])->first();
        if(!$device) {
            Log::info('粉丝关注时，找不到设备！');
            return;
        }
        $app = app('wechat.official_account');
        $openId = $message['FromUserName'];
        $user = $app->user->get($openId);
        if(isset($user['err_code'])) {
            Log::info('粉丝关注时，找不到粉丝！');
            return;
        };
        $fan = Fan::firstOrCreate(['wechat_id' => $openId], ['wechat_name' => $user['nickname'], 'status' => 1]);
        if(!$fan) {
            Log::info('粉丝关注时，创建粉丝失败！');
            return;
        };
        $record = Record::create(['fan_id' => $fan->id, 'device_id' => $device->id]);
        if(!$record) {
            Log::info('粉丝关注时，创建记录失败！');
            return;
        };
        Log::info('粉丝关注成功！');
        return;
    }
}
