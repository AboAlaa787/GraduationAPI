<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Models\Order;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        return $this->get_data(Order::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): JsonResponse
    {
        return $this->show_data(Order::class, $id);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        return $this->store_data($request, Order::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateOrderRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Order::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Order::class);
    }
}
