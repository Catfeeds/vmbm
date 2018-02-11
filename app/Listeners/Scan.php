<?php

namespace App\Listeners;

use App\Events\Scan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function handle(Scan $event)
    {
        //
    }
}
