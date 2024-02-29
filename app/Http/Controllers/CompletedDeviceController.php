<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletedDevices\CreateCompletedDeviceRequest;
use App\Http\Requests\CompletedDevices\UpdateCompletedDeviceRequest;
use App\Models\CompletedDevice;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompletedDeviceController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(CompletedDevice::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(CompletedDevice::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateCompletedDeviceRequest $request): JsonResponse
    {
        return $this->store_data($request, CompletedDevice::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateCompletedDeviceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, CompletedDevice::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, CompletedDevice::class);
    }
}
