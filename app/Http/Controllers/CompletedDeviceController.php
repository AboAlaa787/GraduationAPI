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

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new CompletedDevice(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new CompletedDevice(), $id, str($request->with));
    }

    public function store(CreateCompletedDeviceRequest $request): JsonResponse
    {
        return $this->store_data($request, new CompletedDevice());
    }

    public function update(UpdateCompletedDeviceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new CompletedDevice());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new CompletedDevice());
    }
}
