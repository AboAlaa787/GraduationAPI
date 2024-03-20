<?php

namespace App\Listeners\NotificationsListeners;

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
        $device = Device::find($event->id)->first();
        if ($device) {;
            $client = $device->client;
            $user = $device->user;
            if (!$user || !$client) {
                return;
            }
            switch ($device->status) {
                case 'NotAgree':
                    Notification::send($client, new NotAgreeNotification($event->id, $device->user_id, $device->client_id, $device->problem, $device->cost));
                    break;
                case 'NotStarted':
                    if ($device->client_approval === true) {
                        Notification::send($user, new NotStartedNotification($event->id, $device->user_id,   $device->client_id));
                    }
                    break;
                case 'Ready':
                    Notification::send($client, new ReadyNotification($event->id, $device->user_id,   $device->client_id));
                    break;
                case 'NotMaintainable':
                    Notification::send($client, new NotMaintainableNotification($event->id, $device->user_id,  $device->client_id, $device->problem));
                    break;
            }
        }
    }
}
