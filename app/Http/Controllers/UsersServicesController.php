<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersServicesController extends Controller
{
    public function store(CreateUserRequest $request)
    {
       // $request->validate();
        $request['password'] = Hash::make($request['password']);
        $message['user'] = User::create($request->all());
        $message['token'] = $message['user']->plainTextToken;
        return response()->json($message);
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        // $request->session()->regenerate();
        $message['user'] = Auth::user();
        $message['token'] = Auth::user()->createToken('first')->plainTextToken;
        return response()->json($message);
    }
}
