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
        $user->rule;
        $expiration=config('sanctum.expiration');
        $expires_at=now()->addMinutes($expiration);
        $token = $request->user()->createToken('login',['*'],$expires_at);

        $message['auth'] = $user;
        $message['token'] = $token->plainTextToken;
        return $this->apiResponse($message);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {

        $user = auth()->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return $this->apiResponse();
    }

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
