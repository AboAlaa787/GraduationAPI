<?php

namespace App\Http\Controllers;

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
        $user->update(['device_token' => $device_token]);
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
        ]);
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');

        $devicesTokens = $request->get('devices_tokens');
        $title = $request->get('title');
        $body = $request->get('body');

        $data = [
            'registration_ids' => $devicesTokens,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        if ($response === false) {
            return $this->apiResponse(null, 422, 'Error: Failed to send notification.');
        }

        curl_close($ch);

        return $this->apiResponse($response, 200, 'Success: Notification sent.');
    }
}
