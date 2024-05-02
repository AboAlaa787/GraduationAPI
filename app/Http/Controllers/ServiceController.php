<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Services management
 */
class ServiceController extends Controller
{
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam page integer To specify the page number to be retrieved. Example:1
     * @queryParam per_page integer To specify the number of records per page. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Service(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Service.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Service(), $id, str($request->with));
    }

    /**
     * @param CreateServiceRequest $request
     * @urlParam  id  integer required The ID of the Service.
     * @return JsonResponse
     */
    public function store(CreateServiceRequest $request): JsonResponse
    {
        return $this->store_data($request, new Service());
    }

    /**
     * @param UpdateServiceRequest $request
     * @param $id
     * @urlParam  id  integer required The ID of the Service.
     * @return JsonResponse
     */
    public function update(UpdateServiceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Service());
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Service.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Service());
    }
}
