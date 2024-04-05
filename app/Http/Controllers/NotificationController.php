<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    function allNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse($request->user()->notifications);
    }

    function readNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse($request->user()->readNotifications);
    }

    function unreadNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse($request->user()->unreadNotifications);
    }

    function markAllAsRead(Request $request): JsonResponse
    {
        $user = $request->user();
        $unreadNotifications = $user->unreadNotifications;
        try {
            DB::transaction(function () use ($unreadNotifications) {
                foreach ($unreadNotifications as $unreadNotification) {
                    $unreadNotification->markAsRead();
                }
            });
            return $this->apiResponse([], 200, 'Successful');
        } catch (\PDOException $ex) {
            return $this->apiResponse([], 422, $ex->getMessage());
        }
    }

    function markAsRead(Request $request, $notificationId): JsonResponse
    {
        $user = $request->user();
        $unreadNotification = $user->notifications->where('id', $notificationId);
        if (!$unreadNotification) {
            return $this->apiResponse(null, 404, "No item found with id: $notificationId");
        }
        if ($unreadNotification->read()) {
            return $this->apiResponse(null, 409, "The message has already been read");
        }
        $unreadNotification->markAsRead();
        return $this->apiResponse([], 200, 'Successful');
    }

    function deleteNotification(Request $request, $notificationId): JsonResponse
    {
        $user = $request->user();
        $notification = $user->notifications->where('id', $notificationId)->first();
        if (!$notification) {
            return $this->apiResponse(null, 404, "No item found with id: $notificationId");
        }

        $notification->delete();
        return $this->apiResponse([], 200, 'Successful');
    }
}
