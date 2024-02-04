<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Models\User;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersServicesController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(User::class);
    }

    public function show($id)
    {
        return $this->show_data(User::class, $id);
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
