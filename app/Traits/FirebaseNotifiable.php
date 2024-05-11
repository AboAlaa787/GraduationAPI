<?php

namespace App\Traits;


use App\Models\Firebase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\DatabaseNotification;

trait FirebaseNotifiable
{
    public function pushNotification($notification): void
    {
        try {
            $this->notify($notification);
            $notifiableId = $this->id;
            $notificationData = $notification->toArray($this);
            $notification = DatabaseNotification::where('notifiable_id', $notifiableId)->where('notifiable_type', get_class($this))->latest('id')->firstOrFail();
            $notificationId = $notification->id;

            $userDevicesTokens = $this->tokens()->whereNotNull('device_token')->distinct()->pluck('device_token')->values();
            if ($userDevicesTokens==null){
                return;
            }
            $sender=auth()->user() ? auth()->user() : auth('clients')->user();
            $senderCurrentToken=$sender->currentAccessToken()->token;
            $senderDeviceToken=$sender->tokens()->where('token',$senderCurrentToken)->pluck('device_token')->first();
            (new Firebase())->pushNotification(
                $userDevicesTokens->all(),
                $notificationId,
                $notificationData,
            );
        } catch (ModelNotFoundException) {
            return;
        }
    }

}