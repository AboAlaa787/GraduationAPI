<?php

namespace App\Listeners;

use App\Enums\DeviceStatus;
use App\Events\DeleteDevice;
use App\Models\CompletedDevice;
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
            if (!CompletedDevice::where('code', $device->code)->exists()) {
                $completedDevice = $device->toArray();
                $completedDevice['client_name'] = $device->client?->name;
                $completedDevice['user_name'] = $device->user?->name ?? 'فني صيانة';
                $completedDevice = CompletedDevice::create($completedDevice);
            }
           $device->delete();
        }
    }
}
