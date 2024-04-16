<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Product(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Product(), $id, str($request->with));
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        return $this->store_data($request, new Product());
    }

    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Product());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Product());
    }
}
