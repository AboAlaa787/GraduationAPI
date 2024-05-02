<?php

namespace App\Http\Controllers;

use App\Models\Devices_orders;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Devices_Orders management
 */
class DevicesOrdersController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam page integer To specify the page number to be retrieved, Default is 1. Example:1
     * @queryParam per_page integer To specify the number of records per page, Default is 20. Example:10
     * @queryParam all_data integer To ignore pagination process, Default is 0, Allowed values is 0,1. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Devices_orders(), $request, str($request->with));
    }

    /**
     * @param integer $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Devices_Orders.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return $this->show_data(new Devices_orders(), $id, str($request->with));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(),
            ['device_id' => 'required|exists:devices,id|unique:devices_orders,device_id,NULL,id,order_id,' . $request->input('order_id'),
                'order_id' => 'required|exists:orders,id|unique:devices_orders,order_id,NULL,id,device_id,' . $request->input('device_id')]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 404, 'Failed');
        }
        return $this->store_data($request, new Devices_orders());
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Devices_Orders.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Devices_orders());
    }
}
