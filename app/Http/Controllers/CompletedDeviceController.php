<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletedDevices\CreateCompletedDeviceRequest;
use App\Http\Requests\CompletedDevices\UpdateCompletedDeviceRequest;
use App\Models\CompletedDevice;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompletedDeviceController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(CompletedDevice::class);
    }

    public function show($id)
    {
        return $this->show_data(CompletedDevice::class,$id);
    }

    public function store(CreateCompletedDeviceRequest $request)
    {
        return $this->store_data($request, CompletedDevice::class);
    }

    public function update(UpdateCompletedDeviceRequest $request, $id)
    {
        return $this->update_data($request, $id, CompletedDevice::class);
    }

    public function destroy($id)
    {
        return $this->delete_data($id, CompletedDevice::class);
    }
}
