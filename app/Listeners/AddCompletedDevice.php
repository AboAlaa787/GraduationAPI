<?php

namespace App\Listeners;

use App\Events\DeleteDevice;
use App\Models\Client;
use App\Models\CompletedDevice;
use App\Models\Device;
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

        $device = $event->Device;
        if ($device->deliver_to_client === true) {
            $client = $device->client;
            $user = $device->user;
            if ($client && $user) {
                $completedDevice = $device->toArray();
                $completedDevice['client_name'] = $client->name;
                $completedDevice['user_name'] = $user->name;
                $completedDevice = CompletedDevice::create($completedDevice);
                if ($completedDevice) {
                    $client->decrement('devices_count');
                }
                if ($device->deliver_to_customer === true) {
                    $device->delete();
                }
            }
        }
    }
}
