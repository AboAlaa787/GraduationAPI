<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;


trait ApiResponseTrait
{
    public function apiResponse($body = null, $status = 200, $message = 'Successful',$pagination=null): JsonResponse
    {
        $array['message']=$message;
        $array['body']=$body;
        if ($pagination) {
            $array['pagination'] = $pagination;
        }
        return response()->json($array,$status);
    }
}
