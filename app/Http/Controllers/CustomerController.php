<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers\CreateCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Models\Customer;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Customer(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Customer(), $id, str($request->with));
    }

    public function store(CreateCustomerRequest $request): JsonResponse
    {
        return $this->store_data($request, new Customer());
    }

    public function update(UpdateCustomerRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Customer());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Customer());
    }
}
