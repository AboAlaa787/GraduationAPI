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
        $device = Device::find($event->id);
        if ($device) {
            if ($device->deliver_to_client === true) {
                $client = $device->client;
                if ($client) {
                    $completedDevice = CompletedDevice::create([
                        'model' => $device->model,
                        'imei' => $device->imei,
                        'client_id' => $device->client_id,
                        'user_id' => $device->user_id,
                        'info' => $device->info,
                        'problem' => $device->problem,
                        'cost' => $device->cost,
                        'status' => $device->status,
                        'fix_steps' => $device->fix_steps,
                        'date_receipt' => $device->date_receipt,
                    ]);
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
}
