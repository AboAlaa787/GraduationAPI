<?php

namespace App\Http\Controllers;

use App\Models\Permission_rule;
use App\Models\Service_order;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Service_order::class,$request);
    }
    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Service_order::class, $id, $request->with);
    }
    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $validation =   Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id|unique:service_orders,service_id,NULL,id,order_id,' . $request->input('order_id'),
            'order_id' => 'required|exists:orders,id|unique:service_orders,order_id,NULL,id,service_id,' . $request->input('service_id')
        ]);
        if ($validation->fails()){
            return $this->apiResponse($validation->messages(),404,'Failed');
        }
        return  $this->store_data($request, Service_order::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id,Service_order::class);
    }
}
