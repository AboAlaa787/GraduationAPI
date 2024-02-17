<?php

namespace App\Http\Controllers;

use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Models\Device;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use CRUDTrait;


    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Device::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): JsonResponse
    {
        return $this->show_data(Device::class, $id);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateDeviceRequest $request): JsonResponse
    {
        return $this->store_data($request, Device::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Device::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Device::class);
    }
}
