<?php

namespace App\Listeners;

use App\Events\Unsubscribe;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function handle(Unsubscribe $event)
    {
        //
    }
}
