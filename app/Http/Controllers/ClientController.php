<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Models\Client;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Client::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Client::class, $id, $request->with);
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
