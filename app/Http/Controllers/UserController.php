<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Auth\EmailVerificationNotification;
use App\Traits\CRUDTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

/**
 * @group Users management
 */
class UserController extends Controller
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
        return $this->index_data(new User(), $request, str($request->with));
    }


    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the User.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new User(), $id, str($request->with));
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @urlParam  id  integer required The ID of the User.
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new User());
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', User::class);
            $request['password'] = Hash::make($request['password']);
            $response['user'] = User::create($request->all());
            $expiration = config('sanctum.expiration');
            $expires_at = now()->addMinutes($expiration);
            $response['token'] = $response['user']->createToken('register', ['*'], $expires_at)->plainTextToken;
            $response['user']->notify(new EmailVerificationNotification());
            return $this->apiResponse($response, 200, 'Successful and verification message has been sent');
        } catch (AuthorizationException $e) {
            return $this->apiResponse(null, 403, $e->getMessage());
        } catch (Exception $e) {
            return $this->apiResponse(null, 400, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the User.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new User());
    }
    function areThereDelivery(): JsonResponse
    {
        try {
            $this->authorize('create', new Order());

            $delivery = User::getDelivery();

            if (is_null($delivery)) {
                return $this->apiResponse([]);
            }
            return $this->apiResponse(['There are delivery']);
        } catch (AuthorizationException $e) {
            return $this->apiResponse(null, 403, 'Error: ' . $e->getMessage());
        }
    }
}
