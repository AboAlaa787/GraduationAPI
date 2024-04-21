<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;


trait ApiResponseTrait
{
    public function apiResponse($body = null, $status = 200, $message = 'Successful'): JsonResponse
    {
        $array['message']=$message;
        $array['body']=$body;
        return response()->json($array,$status);
    }
}
