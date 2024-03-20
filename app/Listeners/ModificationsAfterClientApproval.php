<?php

namespace App\Listeners;

use App\Events\ClientApproval;
use App\Models\Device;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModificationsAfterClientApproval
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
    public function handle(ClientApproval $event): void
    {
        $device = Device::find($event->id);
        if ($device && ($device->status === 'NotAgree') && ($device->client_approval !== null)) {
            $status = $device->client_approval ? 'NotStarted' : 'Ready';
            $device->update(['status' => $status]);
        }
    }
}
