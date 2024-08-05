<?php

namespace App\Models;


use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class Firebase
{
    use ApiResponseTrait;

    public function pushNotification(array $devicesTokens, int $notifiableId, $notificationData): JsonResponse
    {
        if (!is_array($notificationData) || !$notificationData) {
            return response()->json(['error' => 'Invalid data'], 422);
        }
        $notificationTitle = $notificationData['title'];
        $notificationBody = implode(' ', $notificationData['body']);
        $notificationActions = $notificationData['actions'] ?? [];
        $data = [
            'devicesTokens' => $devicesTokens,
            'title' => $notificationTitle,
            'body' => $notificationBody,
            'notifiableId' => $notifiableId,
            'actions' => $notificationActions,
        ];
        $rules = [
            'devicesTokens' => 'required|array',
            'title' => 'required|string',
            'body' => 'required|string',
            'notifiableId' => 'required|int',
            'actions' => 'array',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');

        $data = [
            'registration_ids' => $devicesTokens,
            'notification' => [
                'title' => $notificationTitle,
                'body' => $notificationBody,
                'sound' => 'default',
            ],
            "data" => [
                "actions" => $notificationActions,
                "notifiable_id" => $notifiableId,
            ] + ($notificationData['data'] ?? [])
        ];

        //new version

        // $data = [
        //     "message" => [
        //         "token" => $devicesTokens[0],
        //         'data' => [
        //             'notification' => json_encode([
        //                 'title' => $notificationTitle,
        //                 'body' => $notificationBody,
        //             ]),
        //             "actions" => json_encode($notificationActions),
        //             "notifiable_id" =>json_encode( $notifiableId),
        //         ]
        //     ]
        // ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        //new version
        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/firstproject-787/messages:send');

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
