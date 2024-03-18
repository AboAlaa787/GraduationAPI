<?php

namespace App\Listeners;

use App\Events\AddDevice;
use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncreaseCountDevice
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AddDevice $event): void
    {
        $client = Client::find($event->id);
        if ($client) {
            $client->increment('devices_count');
        }
    }
}
