<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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

class ResetPasswordController extends Controller
{
    use ApiResponseTrait;

    public function requestPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'front_url' => 'required|url'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->apiResponse(null, 404, 'Invalid email');
        }

        $token = Password::broker()->createToken($user);

        $resetLink = url($request->front_url);

        Mail::to($user)->send(new ResetPasswordMail($resetLink));

        return $this->apiResponse('Reset link sent to your email');
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    function showResetForm($token, Request $request)
    {
        $email = $request->email;
        return response()->view('new_password', ['email' => $email, 'token' => $token]);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ];
    }


    protected function credentials(Request $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    protected function resetPasswordConfirm(Request $request)
    {
        $validation =   Validator::make($this->credentials($request), $this->rules());

        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 404, 'Failed');
        }

        $new_password = Password::reset(
            $this->credentials($request),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($new_password == Password::PASSWORD_RESET) {

            $user = User::where('email', $request->email)->first();

            $response['user'] = $user;

            $response['token'] = $response['user']->createToken('reset_password')->plainTextToken;

            return $this->apiResponse($response, 200, 'Password reset successfully');
        } else {
            return $this->apiResponse(['error' => 'Unable to reset password'], 422, 'Failed');
        }
    }


    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
