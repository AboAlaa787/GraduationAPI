<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletedDevices\CreateCompletedDeviceRequest;
use App\Http\Requests\CompletedDevices\UpdateCompletedDeviceRequest;
use App\Models\CompletedDevice;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Completed devices management
 */
class CompletedDeviceController extends Controller
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
}
