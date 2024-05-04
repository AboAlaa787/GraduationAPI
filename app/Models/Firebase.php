<?php

namespace App\Models;


use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Validator;

class Firebase
{
    use ApiResponseTrait;

    public function pushNotification(array $devicesTokens, string $title, array|string $body, string $notificationId, string|null $senderDeviceToken): JsonResponse
    {
        $data = [
            'devicesTokens' => $devicesTokens,
            'title' => $title,
            'body' => $body,
            'notificationId' => $notificationId,
            'senderDeviceToken' => $senderDeviceToken
        ];
        $rules = [
            'devicesTokens' => 'required|array',
            'title' => 'required|string',
            'body' => 'required',
            'notificationId' => 'required|string|exists:notifications,id',
            'senderDeviceToken' => 'required|string'
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');

        $data = [
            'registration_ids' => $devicesTokens,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                "actions" => [
                    [
                        "title" => "Yes",
                        "action" => "yes_action"
                    ],
                    [
                        "title" => "No",
                        "action" => "no_action"
                    ]
                ]
            ],
            "data" => [
                "notification_id" => $notificationId,
                'sender_device_token' => $senderDeviceToken,
            ]
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
