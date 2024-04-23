<?php

namespace App\Listeners\NotificationsListeners;

use App\Enums\DeviceStatus;
use App\Events\NotificationEvents\DeviceNotifications;
use App\Models\Client;
use App\Models\Device;
use App\Models\User;
use App\Notifications\DevicesStatus\NotAgreeNotification;
use App\Notifications\DevicesStatus\NotMaintainableNotification;
use App\Notifications\DevicesStatus\NotStartedNotification;
use App\Notifications\DevicesStatus\ReadyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
    public function handle(DeviceNotifications $event): void
    {
        $device = $event->Device;
        $client = $device->client;
        $user = $device->user;
        if (!$user || !$client) {
            return;
        }
        switch ($device->status) {
            case DeviceStatus::WaitingResponse:
                Notification::send($client, new NotAgreeNotification($device->id, $device->user_id, $device->client_id, $device->problem, $device->cost));
                break;
            case DeviceStatus::InProgress:
                Notification::send($user, new NotStartedNotification($device->id, $device->user_id,   $device->client_id));
                break;
            case DeviceStatus::Ready:
            case DeviceStatus::NotAgree:
                Notification::send($client, new ReadyNotification($device->id, $device->user_id,   $device->client_id));
                break;
            case DeviceStatus::NotMaintainable:
                Notification::send($client, new NotMaintainableNotification($device->id, $device->user_id,  $device->client_id, $device->problem));
                break;
        }
    }
}
