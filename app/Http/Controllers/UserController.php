<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Client;
use App\Models\User;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

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
            return $this->get_data(User::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, User::class);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $request['password'] = Hash::make($request['password']);
        $message['user'] = User::create($request->all());
        $message['token'] = $message['user']->createToken('any')->plainTextToken;
        event(new Registered($message['user']));
        return $this->apiResponse($message);
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $message['user'] = Auth::user();
        $message['token'] = $message['user']->createToken('first')->plainTextToken;
        return $this->apiResponse($message);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id):JsonResponse
    {
        return $this->delete_data($id,User::class);
    }
}
