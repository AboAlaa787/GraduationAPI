<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Notifications management
 */
class NotificationController extends Controller
{
    use ApiResponseTrait,CRUDTrait;

    /**
     * Get all notifications for authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function allNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse(NotificationResource::collection($request->user()->notifications));
    }

    /**
     * Get read notifications for authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function readNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse(NotificationResource::collection($request->user()->readNotifications));
    }

    /**
     * Get unread notifications for authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unreadNotifications(Request $request): JsonResponse
    {
        return $this->apiResponse(NotificationResource::collection($request->user()->unreadNotifications));
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
     * @param string $notificationId
     * @return JsonResponse
     */
    public function markAsRead(Request $request, string $notificationId): JsonResponse
    {
        try {
            $user = $request->user();
            $unreadNotification = $user->notifications->find($notificationId);
            if ($unreadNotification == null) {
                return $this->apiResponse([], 404, "Notification Not Found");
            }
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
     * @param string $notificationId
     * @return JsonResponse
     */
    public function deleteNotification(Request $request, string $notificationId): JsonResponse
    {
        try {
            $user = $request->user();
            $notification = $user->notifications->find($notificationId);
            if ($notification == null) {
                return $this->apiResponse([], 404, "Notification Not Found");
            }
            $notification->delete();
            return $this->apiResponse();
        } catch (Exception $exception) {
            return $this->apiResponse([], 422, "Error: " . $exception->getMessage());
        }
    }

    public function adminNotification(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->rule->name == "مدير") {
            $rules = [
                'page' => 'integer|min:1',
                'per_page' => 'integer|min:1',
                'all_data' => 'integer|in:1,0'
            ];
            $data = [
                'page' => $request->get('page', 1),
                'per_page' => $request->get('per_page', 20),
                'all_data' => $request->get('all_data', 0)
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $data=$this->index_data(new DatabaseNotification(),$request,'');
            $hh=$data->getData();
            $d=DatabaseNotification::hydrate($hh->body);
            $r=NotificationResource::collection($d);
            $b=$r->jsonSerialize();
            if ($b) {
                $b=$b[0];
            }
            return $this->apiResponse($b,200,"success",$hh->pagination);
        }
        return $this->apiResponse(null, 403, 'Unauthorized');
    }
}
