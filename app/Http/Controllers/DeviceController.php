<?php

namespace App\Http\Controllers;

use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Models\Client;
use App\Models\CompletedDevice;
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
        return $this->get_data(Device::class, $request, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Device::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateDeviceRequest $request): JsonResponse
    {
        $response = $this->store_data($request, Device::class);
        if ($response->isSuccessful()) {
            $client = Client::find($request->client_id);
            $client->devices_count++;
            $client->save();
        }
        return $response;
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
        $device=Device::find($id);
        $response = $this->delete_data($id, Device::class);
        if ($response->isSuccessful()) {
            $client = Client::find($device->client_id);
            $client->devices_count--;
            $client->save();
            CompletedDevice::create($device);
        }
        return $response;
    }
}
