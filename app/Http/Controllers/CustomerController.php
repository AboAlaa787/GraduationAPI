<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Customers\CreateCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;

class CustomerController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Customer::class, $request, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Customer::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateCustomerRequest $request): JsonResponse
    {
        return $this->store_data($request, Customer::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateCustomerRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Customer::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Customer::class);
    }
}
