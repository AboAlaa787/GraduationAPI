<?php

namespace App\Http\Controllers\Auth;

use function auth;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    use ApiResponseTrait;

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $user = auth('clients')->user();

        if (!$user) {
            $user = auth()->user();
        }
        $token = $user->createToken('login')->plainTextToken;

        $message['auth'] = $user;
        $message['token'] = $token;
        return $this->apiResponse($message);
    }

    /**
     * Destroy an authenticated session.
     */
        public function destroy(Request $request)
        {

            $user= auth()->user();

            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

            return $this->apiResponse();
        }
}
