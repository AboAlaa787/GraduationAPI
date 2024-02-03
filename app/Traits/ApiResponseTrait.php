<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $status = 200)
    {
        $array = [
            'data' => $data,
            'status' => $status,
        ];
        return response($array, $status);
    }
}
