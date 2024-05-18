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
        $notifiables = $this->collection->pluck('notifiable_id', 'notifiable_type')
            ->mapWithKeys(function ($ids, $type) {
                return [$type => $type::findMany($ids)->keyBy('id')];
            });

        return $this->collection->get()->map(function ($notification) use ($notifiables) {
            $notificationData = json_decode($notification->data);
            $notifiableType = explode('\\', $notification->notifiable_type);
            $notifiableType = end($notifiableType);
            $notifiable = $notifiables[$notification->notifiable_type][$notification->notifiable_id] ?? null;

            return [
                'id' => $notification->id,
                'title' => $notificationData->title ?? 'No title',
                'body' => $notificationData->body ?? 'No body',
                'notifiable_name' => $notifiable->name ?? 'Unknown',
                'notifiable_type' => $notifiableType,
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        })->toArray();
    }
}
