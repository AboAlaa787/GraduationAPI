<?php

namespace App\Http\Controllers;

use App\Models\Devices_orders;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DevicesOrdersController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Devices_orders(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Devices_orders(), $id, str($request->with));
    }

    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), ['device_id' => 'required|exists:devices,id|unique:devices_orders,device_id,NULL,id,order_id,' . $request->input('order_id'), 'order_id' => 'required|exists:orders,id|unique:devices_orders,order_id,NULL,id,device_id,' . $request->input('device_id')]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 404, 'Failed');
        }
        return $this->store_data($request, new Devices_orders());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Devices_orders());
    }
}
