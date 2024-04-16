<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Models\Order;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Order(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Order(), $id, str($request->with));
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        return $this->store_data($request, new Order());
    }

    public function update(UpdateOrderRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Order());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Order());
    }
}
