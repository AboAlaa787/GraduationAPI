<?php

namespace App\Http\Controllers;

use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Models\Device;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;

class DeviceController extends Controller
{
    use CRUDTrait;


    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Device::class);
        return $this->get_data(Device::class);
    }

    public function show($id): JsonResponse
    {
        $this->authorize('view', Device::class);
        return $this->show_data(Device::class, $id);
    }

    public function store(CreateDeviceRequest $request): JsonResponse
    {
        $this->authorize('create', Device::class);
        return $this->store_data($request, Device::class);
    }

    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
        $this->authorize('update', Device::class);
        return $this->update_data($request, $id, Device::class);
    }

    public function destroy($id): JsonResponse
    {
        $this->authorize('delete', Device::class);
        return $this->delete_data($id, Device::class);
    }
}
