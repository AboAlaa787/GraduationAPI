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
    public function show($id)
    {
        return $this->show_data(Product::class,$id);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, Product::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Product::class);
    }
    public function destroy($id)
    {
        return $this->delete_data($id, Product::class);
    }
}
