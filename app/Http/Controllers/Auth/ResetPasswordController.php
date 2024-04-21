<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Traits\ApiResponseTrait;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ResetPasswordController extends Controller
{
    use ApiResponseTrait;

    public function resetPasswordRequest(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'front_url' => 'required|url'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = Client::where('email', $request->email)->first();
            if (!$user) {
                return $this->apiResponse(null, 404, 'Invalid email');
            }
        }

        try {
            $token = Password::broker()->createToken($user);

            $resetLink = url($request->front_url . '/' . $token . '?email=' . $user->email);

            Mail::to($user)->send(new
                ResetPasswordMail($resetLink));

            return $this->apiResponse('Reset link sent to your email');
        } catch (\Exception $e) {
            return $this->apiResponse($e->getMessage(), 500, 'Failed to send email');
        }
    }

    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ];
    }


    protected function credentials(Request $request)
    {
        return $request->only(['email', 'password', 'password_confirmation', 'token']);
    }

    protected function resetPasswordConfirm(Request $request): JsonResponse
    {
        $validation =   validator::make($this->credentials($request), $this->rules());

        if ($validation->fails()) {
            return $this->apiresponse($validation->errors(), 400, 'validation failed');
        }
        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');
        $storedToken = DB::table('password_reset_tokens')
            ->where('email', $email)->get();
        if (!isNull($storedToken) && Hash::check($token, $storedToken->value('token'))) {
            $user = User::where('email', $email)->first();
            $client = Client::where('email', $email)->first();
            $auth = $user ?: $client;
            $auth->forcefill([
                'password' => hash::make($password),
                'remember_token' => str::random(60),
            ])->save();
            $response = [
                'user' => $auth,
                'token' => $auth->createToken('reset_password')->plainTextToken,
            ];
            DB::table('password_reset_tokens')
                ->where('email', $email)->delete();
            return $this->apiresponse($response, 200, 'password reset successfully');
        }

        return $this->apiresponse(['error' => 'unable to reset password'], 422, 'failed');
    }
}
