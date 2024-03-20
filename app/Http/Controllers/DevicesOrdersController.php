<?php

namespace App\Http\Controllers;

use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use App\Models\Devices_orders;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DevicesOrdersController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Devices_orders::class,$request, $request->with);
    }
    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Devices_orders::class, $id, $request->with);
    }
    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $validation =   Validator::make($request->all(), [
            'device_id' => 'required|exists:devices,id|unique:devices_orders,device_id,NULL,id,order_id,' . $request->input('order_id'),
            'order_id' => 'required|exists:orders,id|unique:devices_orders,order_id,NULL,id,device_id,' . $request->input('device_id')
        ]);
        if ($validation->fails()){
            return $this->apiResponse($validation->messages(),404,'Failed');
        }
        return  $this->store_data($request, Devices_orders::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id,Devices_orders::class);
    }
}
