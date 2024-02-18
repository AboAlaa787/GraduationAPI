<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use function auth;

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
        $token = $user->createToken('first')->plainTextToken;

        $message['auth'] = $user;
        $message['token'] = $token;
        return $this->apiResponse($message);
    }

    /**
     * Destroy an authenticated session.
     */
    /*    public function destroy(Request $request): Response
        {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->noContent();
        }*/
}
