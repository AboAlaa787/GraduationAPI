<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group Notifications management
 */
class NotificationController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all notifications for authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function allNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse($request->user()->notifications);
    }

    /**
     * Get read notifications for authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function readNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse($request->user()->readNotifications);
    }

    /**
     * Get unread notifications for authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unreadNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse($request->user()->unreadNotifications);
    }

    /**
     * Mark all unread notifications as read
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = $request->user();
        $unreadNotifications = $user->unreadNotifications;
        try {
            DB::transaction(static function () use ($unreadNotifications) {
                foreach ($unreadNotifications as $unreadNotification) {
                    $unreadNotification->markAsRead();
                }
            });
            return $this->apiResponse();
        } catch (Exception $ex) {
            return $this->apiResponse([], 422, $ex->getMessage());
        }
    }

    /**
     * Mark specific notification as read by id
     *
     * @param Request $request
     * @param $notificationId
     * @return JsonResponse
     */
    public function markAsRead(Request $request, $notificationId): JsonResponse
    {
        try {
            $user = $request->user();
            $unreadNotification = $user->notifications->findOrFail($notificationId);
            if ($unreadNotification->read()) {
                return $this->apiResponse(null, 409, "The message has already been read");
            }
            $unreadNotification->markAsRead();

            return $this->apiResponse();
        } catch (ModelNotFoundException) {
            return $this->apiResponse([], 404, "Notification Not Found");
        }
    }

    /**
     * Delete specific notification by id
     *
     * @param Request $request
     * @param integer $notificationId
     * @return JsonResponse
     */
    public function deleteNotification(Request $request, int $notificationId): JsonResponse
    {
        try {
            $user = $request->user();
            $notification = $user->notifications->findOrFail($notificationId);

            $notification->delete();
            return $this->apiResponse();
        } catch (ModelNotFoundException) {
            return $this->apiResponse([], 404, "Notification Not Found");
        }
    }

//    public function sendNotification(Request $request):JsonResponse
//    {
//        $this->validate($request,[
//            'message' => 'required',
//        ]);
//    }
}
