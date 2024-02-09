<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        return $this->get_data(Service::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): JsonResponse
    {
        return $this->show_data(Service::class, $id);
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
