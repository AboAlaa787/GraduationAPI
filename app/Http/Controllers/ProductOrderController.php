<?php

namespace App\Http\Controllers;

use App\Models\Permission_rule;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductOrderController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Permission_rule(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Permission_rule(), $id, str($request->with));
    }

    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), ['product_id' => 'required|exists:products,id|unique:product_orders,product_id,NULL,id,order_id,' . $request->input('order_id'), 'order_id' => 'required|exists:orders,id|unique:product_orders,order_id,NULL,id,product_id,' . $request->input('product_id')]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 404, 'Failed');
        }
        return $this->store_data($request, new Permission_rule());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Permission_rule());
    }
}
