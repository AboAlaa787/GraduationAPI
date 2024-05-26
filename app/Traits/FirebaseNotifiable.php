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

            $userDevicesTokens = $this->tokens()->whereNotNull('device_token')->distinct()->pluck('device_token')->values();
            if ($userDevicesTokens==null){
                return;
            }
            (new Firebase())->pushNotification(
                $userDevicesTokens->all(),
                $notifiableId,
                $notificationData
            );
        } catch (ModelNotFoundException $e) {
            return;
        }
    }

}
