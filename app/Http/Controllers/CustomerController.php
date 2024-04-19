<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers\CreateCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Models\Customer;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Customers management
 */
class CustomerController extends Controller
{
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Customer(), $request, str($request->with));
    }

    /**
     * @param integer $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Customer.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return $this->show_data(new Customer(), $id, str($request->with));
    }

    /**
     * @param CreateCustomerRequest $request
     * @return JsonResponse
     */
    public function store(CreateCustomerRequest $request): JsonResponse
    {
        return $this->store_data($request, new Customer());
    }

    /**
     * @param UpdateCustomerRequest $request
     * @param int $id
     * @urlParam  id  integer required The ID of the Customer.
     * @return JsonResponse
     */
    public function update(UpdateCustomerRequest $request,int $id): JsonResponse
    {
        return $this->update_data($request, $id, new Customer());
    }

    /**
     * @param int $id
     * @urlParam  id  integer required The ID of the Customer.
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->destroy_data($id, new Customer());
    }
}
