<?php

namespace App\Listeners\NotificationsListeners;
use App\Enums\DeviceStatus;
use App\Events\NotificationEvents\DeviceStateNotifications;
use App\Notifications\ClientApprovalNotification;
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
//        if (!$user || !$client) {
//            return;
//        }
//        switch ($device->status) {
//            case DeviceStatus::WaitingResponse:
//                Notification::send($client, new NotAgreeNotification($device->id, $device->user_id, $device->client_id, $device->problem, $device->cost));
//                break;
//            case DeviceStatus::InProgress:
//                Notification::send($user, new NotStartedNotification($device->id, $device->user_id,   $device->client_id));
//                break;
//            case DeviceStatus::Ready:
//            case DeviceStatus::NotAgree:
//                Notification::send($client, new ReadyNotification($device->id, $device->user_id,   $device->client_id));
//                break;
//            case DeviceStatus::NotMaintainable:
//                Notification::send($client, new NotMaintainableNotification($device->id, $device->user_id,  $device->client_id, $device->problem));
//                break;
//        }
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
        if(in_array($device->status, [
            DeviceStatus::NotAgree->value,
            DeviceStatus::NotReady->value,
            DeviceStatus::Ready->value,
            DeviceStatus::NotMaintainable->value,
        ])){
            $client->pushNotification(new DeviceStateNotification($device));
        }
    }
}
