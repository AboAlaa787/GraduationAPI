<?php

namespace App\Http\Controllers;

use App\Models\Permission_user;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionUserController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Permission_user::class,$request);
    }
    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Permission_user::class, $id, $request->with);
    }
    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
       $validation =   Validator::make($request->all(), [
            'permission_id' => 'required|exists:permissions,id|unique:permission_users,permission_id,NULL,id,user_id,' . $request->input('user_id'),
            'user_id' => 'required|exists:users,id|unique:permission_users,user_id,NULL,id,permission_id,' . $request->input('permission_id')
        ]);
        if ($validation->fails()){
            return $this->apiResponse($validation->messages(),404,'Failed');
        }
        return  $this->store_data($request, Permission_user::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id,Permission_user::class);
    }
}
