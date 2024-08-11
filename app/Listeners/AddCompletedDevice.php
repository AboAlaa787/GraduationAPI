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
git            $completedDevice = CompletedDevice::where('code', $device->code)->first();
            if (!$completedDevice) {
                $completedDevice = $device->toArray();
                $completedDevice['client_name'] = $device->client?->name;
                $completedDevice['user_name'] = $device->user?->name ?? 'فني صيانة';
                $completedDevice['date_delivery_customer'] = now();
                $completedDevice = CompletedDevice::create($completedDevice);
            } else {
                $completedDevice->date_delivery_customer = now();
                $completedDevice->cost_to_customer = $device->cost_to_customer;
                $completedDevice->deliver_to_customer = true;
                if ($device->status == DeviceStatus::Ready->value) {
                    $completedDevice->customer_date_warranty = $device->customer_date_warranty;
                }
                $completedDevice->save();
            }
            $device->delete();
        }
    }
}
