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

    public function show($id)
    {
        return $this->show_data(Order::class, $id);
    }

    public function store(Request $request)
    {
        return $this->store_data($request, Order::class);
    }

    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Order::class);
    }

    public function destroy($id)
    {
        return $this->delete_data($id, Order::class);
    }
}
