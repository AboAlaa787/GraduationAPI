<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerifyRequest;
use App\Notifications\Auth\EmailVerificationNotification;
use App\Traits\ApiResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    private $otp;
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->otp = new Otp();
    }

    public function sendEmailVerificationNotification(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->apiResponse(null, 403, 'The user has already been verified. Invalid process.');
        }

        $request->user()->notify(new EmailVerificationNotification());

        return $this->apiResponse('Verification message was sent successfully');
    }

    /**
     * Mark email as verified
     *
     * @param EmailVerifyRequest $request
     * @return JsonResponse
     */
    public function emailVerify(EmailVerifyRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->apiResponse(null, 403, 'The user has already been verified. Invalid process.');
        }

        $otpValidationResult = $this->otp->validate($user->email, $request->code);

        if (!$otpValidationResult->status) {
            return $this->apiResponse($otpValidationResult, 403, $otpValidationResult->message);
        }

        $emailVerifySuccess = $user->markEmailAsVerified();

        if ($emailVerifySuccess) {
            event(new Verified($user));
            return $this->apiResponse($user, 200, 'Verification successful');
        }
        return $this->apiResponse(null, 500, 'Failed to verify email. Please try again later.');
    }
}
