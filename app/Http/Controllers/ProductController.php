<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Product::class);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, Product::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Product::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, Product::class);
    }
}
