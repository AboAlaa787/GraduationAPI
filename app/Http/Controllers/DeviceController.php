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
        return $this->get_data(Device::class);
    }

    public function show($id): JsonResponse
    {
        return $this->show_data(Device::class, $id);
    }

    public function store(CreateDeviceRequest $request): JsonResponse
    {
        return $this->store_data($request, Device::class);
    }

    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Device::class);
    }

    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Device::class);
    }
}
