<?php

namespace App\Listeners;

use App\Enums\DeviceStatus;
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
        $device = $event->Device;
        if ($device->client_approval !== null) {
            $status = $device->client_approval ?  DeviceStatus::InProgress->value :  DeviceStatus::NotAgree->value;
            $device->update(['status' => $status]);
        }
    }
}
