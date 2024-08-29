<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Models\Client;
use App\Notifications\Auth\EmailVerificationNotification;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Clients management
 */
class ClientController extends Controller
{
    use CRUDTrait;
    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam withCount string To query the number of records for related data. No-example
     * @queryParam page integer To specify the page number to be retrieved, Default is 1. Example:1
     * @queryParam per_page integer To specify the number of records per page, Default is 20. Example:10
     * @queryParam all_data integer To ignore pagination process, Default is 0, Allowed values is 0,1. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Client(), $request, str($request->with));
    }

    /**
     * @param integer $id
     * @urlParam  id  integer required The ID of the Client.
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return $this->show_data(new Client(), $id, str($request->with));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateClientRequest $request): JsonResponse
    {
        try {
            // $this->authorize('create', new Client());
            $request['password'] = Hash::make($request['password']);
            $response['client'] = Client::create($request->all());
            $expiration = config('sanctum.expiration');
            $expires_at = now()->addMinutes($expiration);
            $response['token'] = $response['client']->createToken('register', ['*'], $expires_at)->plainTextToken;
            $response['client']->notify(new EmailVerificationNotification());
            return $this->apiResponse($response, 200, 'Successful and verification message has been sent');
        } catch (AuthorizationException $e) {
            return $this->apiResponse(null, 403, 'Error: ' . $e->getMessage());
        }
    }

    /**
     * @param UpdateClientRequest $request
     * @urlParam  id  integer required The ID of the Client.
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateClientRequest $request, int $id): JsonResponse
    {
        return $this->update_data($request, $id, new Client());
    }

    /**
     * @urlParam  id  integer required The ID of the Client.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->destroy_data($id, new Client());
    }
}
