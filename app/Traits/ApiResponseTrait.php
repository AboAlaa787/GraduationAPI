<?php

namespace App\Traits;



trait ApiResponseTrait
{
    public function apiResponse($body = null, $status = 200, $message = 'Successful')
    {
        $array['message']=$message;
        $array['body']=$body;
        return response()->json($array,$status);
    }
}
