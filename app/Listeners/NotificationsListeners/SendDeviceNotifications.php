<?php

namespace App\Listeners\NotificationsListeners;

use App\Enums\DeviceStatus;
use App\Events\NotificationEvents\DeviceStateNotifications;
use App\Models\CompletedDevice;
use App\Notifications\ClientApprovalNotification;
use App\Notifications\DeviceIsCheckedNotification;
use App\Notifications\DeviceStateNotification;

class SendDeviceNotifications
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
    public function handle(DeviceStateNotifications $event): void
    {
        $device = $event->Device;
        $client = $device->client;
        $user = $device->user;
        //Notify the technician
        if (
            in_array($device->status, [
                DeviceStatus::InProgress->value,
                DeviceStatus::NotAgree->value,
            ])
        ) {
            $user->pushNotification(new ClientApprovalNotification($device));
            return;
        }
        //Notify the client
        if (in_array($device->status, [
            DeviceStatus::NotAgree->value,
            DeviceStatus::NotReady->value,
            DeviceStatus::Ready->value,
            DeviceStatus::NotMaintainable->value,
        ])) {
            $client->pushNotification(new DeviceStateNotification($device));
        }

        if ($device->status == DeviceStatus::WaitingResponse) {
            $client->pushNotification(new DeviceIsCheckedNotification($device));
        }

        if ($device->status == DeviceStatus::Ready) {
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
            }
            return;
        }
    }
}
