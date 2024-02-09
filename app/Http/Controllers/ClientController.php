<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Models\Client;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        return $this->get_data(Client::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, $with = []): JsonResponse
    {
        return $this->show_data(Client::class, $id, $with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateClientRequest $request): JsonResponse
    {
        return $this->store_data($request, Client::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
       return $this->update_data($request,$id,Client::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Client::class);
    }
}
