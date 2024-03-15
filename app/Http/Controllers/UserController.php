<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\CRUDTrait;
use \Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Notifications\Auth\EmailVerificationNotification;

class UserController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(User::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(User::class, $request);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, User::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $request['password'] = Hash::make($request['password']);
        $response['user'] = User::create($request->all());
        $response['token'] = $response['user']->createToken('register')->plainTextToken;
        event(new Registered($response['user']));
        $response['user']->notify(new EmailVerificationNotification());
        return $this->apiResponse($response, 200, 'Successful and verification message has been sent');
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

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, User::class);
    }
}
