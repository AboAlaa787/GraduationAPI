<?php

namespace App\Http\Controllers\Auth;

use function auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

/**
 * @group Sessions management
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    use ApiResponseTrait;

    /**
     * Login
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     * @unauthenticated
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = auth()->user() ?? auth('clients')->user();

        $user->load('rule', 'permissions', 'rule.permissions');
        $expiration=config('sanctum.expiration');
        $expires_at=now()->addMinutes($expiration);
        $token = $user->createToken('login',['*'],$expires_at);

        $message = [
            'auth' => $user,
            'token' => $token->plainTextToken
        ];
        return $this->apiResponse($message);
    }

    /**
     * Logout
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        $currentAccessToken = $user->currentAccessToken()->token;

        $user->tokens()->where('token', $currentAccessToken)->delete();

        return $this->apiResponse('Logout successfully');
    }

    /**
     * Refresh token
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh_token(Request $request): JsonResponse
    {
        $user = $request->user();
        $oldTokenId = $request->user()->currentAccessToken()->id;
        $expiration=config('sanctum.expiration');
        $expires_at=now()->addMinutes($expiration);
        $token = $request->user()->createToken('refresh-token',['*'],$expires_at);
        $user->tokens()->where('id', $oldTokenId)->delete();
        return $this->apiResponse(['token' => $token->plainTextToken]);
    }
}
