<?php

namespace App\Traits;



trait ApiResponseTrait
{
    public function apiResponse($body = null, $status = 200, $message = 'Successful')
    {
        $array['message']=$message;
        $array['body']=$body;
        $array['status']=$status;
        return response()->json($array);
    }
}
