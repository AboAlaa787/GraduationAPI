<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangePasswordRequest;
use function auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
        $expiration = config('sanctum.expiration');
        $expires_at = now()->addMinutes($expiration);
        $token = $user->createToken('login', ['*'], $expires_at);

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
        $expiration = config('sanctum.expiration');
        $expires_at = now()->addMinutes($expiration);
        $token = $request->user()->createToken('refresh-token', ['*'], $expires_at);
        $user->tokens()->where('id', $oldTokenId)->delete();
        return $this->apiResponse(['token' => $token->plainTextToken]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return $this->apiResponse(['Error Current password does not match'], 422, 'كلمة المرور الحالية غير صحيحة');
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return $this->apiResponse([], 200, 'Password changed successfully');
    }
}
