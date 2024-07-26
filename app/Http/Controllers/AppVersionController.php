<?php

namespace App\Http\Controllers;

use App\Models\Version;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AppVersionController extends Controller
{
    use ApiResponseTrait;
    public function getLatestVersion(Request $request): JsonResponse
    {
        $this->validate($request, [
            'current_version' => 'required',
        ]);
        $currentVersion = $request->get('current_version');
        $currentVersionIsWork = Version::where('version',$currentVersion)->first()?->is_work;
        $latestVersion = Version::latest('created_at')->first();
        $response['latest_version']=$latestVersion?->version;
        $response['current_version_is_work']=$currentVersionIsWork;
        return $this->apiResponse($response);
    }
}
