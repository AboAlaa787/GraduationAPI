<?php

namespace App\Http\Controllers;

use App\Models\Permission_rule;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionRuleController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Permission_rule::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $validation =   Validator::make($request->all(), [
            'permission_id' => 'required|exists:permissions,id|unique:permission_rules,permission_id,NULL,id,rule_id,' . $request->input('rule_id'),
            'rule_id' => 'required|exists:rules,id|unique:permission_rules,rule_id,NULL,id,permission_id,' . $request->input('permission_id')
        ]);
        if ($validation->fails()){
            return $this->apiResponse($validation->messages(),404,'Failed');
        }
        return  $this->store_data($request, Permission_rule::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id,Permission_rule::class);
    }
}
