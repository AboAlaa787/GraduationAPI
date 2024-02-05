<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Models\Client;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    use CRUDTrait;

    public function index(): JsonResponse
    {
        return $this->get_data(Client::class);
    }

    public function show($id): JsonResponse
    {
        return $this->show_data(Client::class, $id);
    }

    public function store(CreateClientRequest $request): JsonResponse
    {
        return $this->store_data($request, Client::class);
    }

    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        $client = Client::find($id);
        if (!$client) {
            return $this->apiResponse(null, 404, 'There is not item with id ' . $id);
        }
        if ($request['center_name']) {
            $client->center_name = $request['center_name'];
        }
        if ($request['phone']) {
            $client->center_name = $request['phone'];
        }
        if ($request['devices_count']) {
            $client->center_name = $request['devices_count'];
        }
        if ($request['email']) {
            $client->center_name = $request['email'];
        }
        if ($request['name']) {
            $client->center_name = $request['name'];
        }
        if ($request['last_name']) {
            $client->center_name = $request['last_name'];
        }
        if ($request['rule_id']) {
            $client->center_name = $request['rule_id'];
        }
        if ($request['password']) {
            $client->center_name = $request['password'];
        }
        if ($request['address']) {
            $client->center_name = $request['address'];
        }
        $client->save();
        return $this->apiResponse($client);
    }

    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Client::class);
    }
}
