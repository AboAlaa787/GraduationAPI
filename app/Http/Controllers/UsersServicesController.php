<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Permission;
use App\Models\User;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersServicesController extends Controller
{
    use CRUDTrait;

    public function index(): JsonResponse
    {
        return $this->get_data(User::class);
    }

    public function show($id): JsonResponse
    {
        return $this->show_data(User::class, $id);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return $this->apiResponse(null, 404, 'There is not item with id ' . $id);
        }
        if ($request['email']) {
            $user->email = $request['email'];
        }
        if ($request['name']) {
            $user->email = $request['name'];
        }
        if ($request['last_name']) {
            $user->email = $request['last_name'];
        }
        if ($request['password']) {
            $user->email = $request['password'];
        }
        if ($request['rule_id']) {
            $user->email = $request['rule_id'];
        }
        if ($request['phone']) {
            $user->email = $request['phone'];
        }
        if ($request['address']) {
            $user->email = $request['address'];
        }
        $user->save();
        return $this->apiResponse($user);
    }

    public function store(CreateUserRequest $request)
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
    public function login(LoginRequest $request)
    {
        $request->authenticate();
        //$request->session()->regenerate();
        $message['user'] = Auth::user();
        $message['token'] = Auth::user()->createToken('first')->plainTextToken;
        return $this->apiResponse($message);
    }
}
