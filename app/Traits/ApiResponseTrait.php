<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $status = null)
    {
        $array = [
            'data' => $data,
            'status' => $status,
        ];
        return response($array, $status);
    }
}
