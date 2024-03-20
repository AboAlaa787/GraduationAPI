<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Notifications\Auth\EmailVerificationNotification;

class ClientController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Client::class, $request, $request->with);
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
        $this->authorize('create', Client::class);
        $request['password'] = Hash::make($request['password']);
        $response['client'] = Client::create($request->all());
        $response['token'] = $response['client']->createToken('register')->plainTextToken;
        event(new Registered($response['client']));
        $response['client']->notify(new EmailVerificationNotification());
        return $this->apiResponse($response, 200, 'Successful and verification message has been sent');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Client::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Client::class);
    }
}
