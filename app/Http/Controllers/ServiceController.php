<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Service(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Service(), $id, str($request->with));
    }

    public function store(CreateServiceRequest $request): JsonResponse
    {
        return $this->store_data($request, new Service());
    }

    public function update(UpdateServiceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Service());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Service());
    }
}
