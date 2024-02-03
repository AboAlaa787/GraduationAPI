<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Order::class);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, Order::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Order::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, Order::class);
    }
}
