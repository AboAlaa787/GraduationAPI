<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {        
        $notification = $this->collection;
        $notificationData = $notification['data'];
        $notifiableModel = $notification['notifiable_type'];
        $notifiableType = explode('\\', $notifiableModel);
        $notifiable = $notifiableModel::find($notification['notifiable_id']);
        return [
            'id' => $notification['id'],
            'title' => $notificationData['title'] ?? 'No title',
            'body' => $notificationData['body'] ?? 'No body',
            'notifiable_name' => "$notifiable->name $notifiable->last_name" ?? 'Unknown',
            'notifiable_type' => end($notifiableType),
            'read_at' => $notification['read_at'],
            'created_at' => $notification['created_at'],
        ];
    }
}
