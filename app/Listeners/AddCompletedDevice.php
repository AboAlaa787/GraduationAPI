<?php

namespace App\Listeners;

use App\Enums\DeviceStatus;
use App\Events\DeleteDevice;
use App\Models\Client;
use App\Models\CompletedDevice;
use App\Models\Device;
use App\Notifications\CustomerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddCompletedDevice
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
    public function handle(DeleteDevice $event): void
    {
        $device = $event->device;
        if ($device->deliver_to_customer) {
            $customer = $device->customer;
            $customer->notify(new CustomerNotification($device));
           $device->delete();
            return;
        }
    }
}
