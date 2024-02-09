<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        return $this->get_data(Product::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): JsonResponse
    {
        return $this->show_data(Product::class, $id);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        return $this->store_data($request, Product::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Product::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Product::class);
    }
}
