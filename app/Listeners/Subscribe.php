<?php

namespace App\Listeners;

use App\Events\Subscribe;
use App\Models\Device;
use App\Models\Fan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function handle(Subscribe $event)
    {
        $message = $event->message;
        $device = Device::where('ticket', $message['Ticket'])->first();
        if(!$device) return;
        $app = app('wechat.official_account');
        $user = $app->user->get($openId);
        $fan = Fan::firstOrCreate([])
    }
}
