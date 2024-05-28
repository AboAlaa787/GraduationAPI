<?php

namespace App\Http\Controllers;

use App\Models\Product_order;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Products_Orders management
 */
class ProductOrderController extends Controller
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
        return $this->index_data(new Product_order(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Product_order.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Product_order(), $id, str($request->with));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(),
            ['product_id' => 'required|exists:products,id|unique:product_orders,product_id,NULL,id,order_id,' . $request->input('order_id')
            , 'order_id' => 'required|exists:orders,id|unique:product_orders,order_id,NULL,id,product_id,' . $request->input('product_id')]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 400, 'Failed');
        }
        return $this->store_data($request, new Product_order());
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Product_order.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Product_order());
    }

    /**
     * @param Request $request
     * @param int $id
     * @urlParam  id  integer required The ID of the Products_Orders.
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        return $this->update_data($request, $id, new Product_order());
    }
}
