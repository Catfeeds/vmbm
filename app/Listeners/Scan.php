<?php

namespace App\Listeners;

use App\Events\Scan as ScanEvent;
use App\Models\Device;
use App\Models\Fan;
use App\Models\Record;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class Scan
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
     * @param  Scan  $event
     * @return void
     */
    public function handle(ScanEvent $event)
    {
        $message = $event->message;
        $device = Device::where('ticket', $message['Ticket'])->first();
        if(!$device) {
            Log::info('粉丝扫码时，找不到设备！');
            return;
        }
        $openId = $message['FromUserName'];
        $fan = Fan::where('wechat_id', $openId)->first();
        if(!$fan) {
            Log::info('粉丝扫码时，找不到粉丝！');
            return;
        };
        $record = Record::create(['fan_id' => $fan->id, 'device_id' => $device->id]);
        if(!$record) {
            Log::info('粉丝扫码时，创建记录失败！');
            return;
        };
        Log::info('粉丝扫码成功！');
        return;
    }
}
