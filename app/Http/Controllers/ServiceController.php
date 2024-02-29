<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Service::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Service::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateServiceRequest $request): JsonResponse
    {
        return $this->store_data($request, Service::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateServiceRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Service::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Service::class);
    }
}
