<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletedDevices\CreateCompletedDeviceRequest;
use App\Http\Requests\CompletedDevices\UpdateCompletedDeviceRequest;
use App\Models\CompletedDevice;
use App\Traits\CRUDTrait;
use App\Traits\SearchTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Completed devices management
 */
class CompletedDeviceController extends Controller
{
    use CRUDTrait;
    use SearchTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam page integer To specify the page number to be retrieved, Default is 1. Example:1
     * @queryParam per_page integer To specify the number of records per page, Default is 20. Example:10
     * @queryParam all_data integer To ignore pagination process, Default is 0, Allowed values is 0,1. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new CompletedDevice(), $request, str($request->with));
    }

    /**
     * @param integer $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Completed Device.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return $this->show_data(new CompletedDevice(), $id, str($request->with));
    }

    /**
     * @param CreateCompletedDeviceRequest $request
     * @return JsonResponse
     */
    public function store(CreateCompletedDeviceRequest $request): JsonResponse
    {
        return $this->store_data($request, new CompletedDevice());
    }

    /**
     * @param UpdateCompletedDeviceRequest $request
     * @param int $id
     * @urlParam  id  integer required The ID of the Completed Device.
     * @return JsonResponse
     */
    public function update(UpdateCompletedDeviceRequest $request, int $id): JsonResponse
    {
        return $this->update_data($request, $id, new CompletedDevice());
    }

    /**
     * @param int $id
     * @urlParam  id  integer required The ID of the Completed Device.
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->destroy_data($id, new CompletedDevice());
    }

    /**
     * @param $keyword
     * @urlParam Keyword string required for search
     * @return JsonResponse
     */
    public function search(string $keyword): JsonResponse
    {
        return $this->get_search(new CompletedDevice(), $keyword);
    }
}
