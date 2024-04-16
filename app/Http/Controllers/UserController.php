<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
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
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use CRUDTrait;

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new User(), $id, str($request->with));
    }

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new User(), $request, str($request->with));
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new User());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', User::class);
            $request['password'] = Hash::make($request['password']);
            $response['user'] = User::create($request->all());
            $response['token'] = $response['user']->createToken('register')->plainTextToken;
            event(new Registered($response['user']));
            $response['user']->notify(new EmailVerificationNotification());
            return $this->apiResponse($response, 200, 'Successful and verification message has been sent');
        } catch (AuthorizationException $e) {
            return $this->apiResponse(null, 403, $e->getMessage());
        } catch (Exception $e) {
            return $this->apiResponse(null, 400, $e->getMessage());
        }
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $response['user'] = Auth::user();
        $response['token'] = $response['user']->createToken('login')->plainTextToken;
        return $this->apiResponse($response);
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new User());
    }
}
