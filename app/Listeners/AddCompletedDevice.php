<?php

namespace App\Listeners;

use App\Enums\DeviceStatus;
use App\Events\DeleteDevice;
use App\Notifications\CustomerNotification;

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
            if ($device->status === DeviceStatus::Ready->value) {
                $customer->notify(new CustomerNotification($device));
            }
           $device->delete();
        }
    }
}
