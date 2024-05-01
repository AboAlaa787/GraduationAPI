<?php

namespace App\Http\Controllers;

use App\Models\Firebase;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FirebaseNotificationsController extends Controller
{
    use apiResponseTrait;

    /**
     * Store FCM token
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function storeToken(Request $request): JsonResponse
    {
        $this->validate($request, [
            'device_token' => 'required',
        ]);
        $device_token = $request->get('device_token');
        $user = $request->user();
        $currentAccessToken = $user->currentAccessToken()->token;
        $userDevicesTokens = ($user->tokens()->where('token', $currentAccessToken)->pluck('device_token')->first());
        if (is_null($userDevicesTokens)) {
            $user->tokens()->where('token', $currentAccessToken)->update(['device_token' => $device_token]);
            return $this->apiResponse($user, 200, 'Success: Device token stored successfully.');
        }
        return $this->apiResponse($user, 200, 'Success: Device token stored successfully.');

    }

    /**
     * Push notification to device
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function pushNotification(Request $request): JsonResponse
    {
        $this->validate($request, [
            'devices_tokens' => 'required|array',
            'title' => 'required|string',
            'body' => 'required|string',
            'notification_id' => 'required|string|exists:notifications,id'
        ]);
        $user = $request->user();
        $currentAccessToken = $user->currentAccessToken()->token;
        $senderDeviceTokens = ($user->tokens()->where('token', $currentAccessToken)->pluck('device_token')->first());
        if ($senderDeviceTokens == null) {
            return $this->apiResponse(null, 404, 'No devices tokens stored.');
        }
        return (new Firebase())->pushNotification(
            $request->get('devices_tokens'),
            $request->get('title'),
            $request->get('body'),
            $request->get('notification_id'),
            $senderDeviceTokens
        );
    }
}
