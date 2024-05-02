<?php

namespace App\Http\Controllers;

use App\Models\Permission_user;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Permissions_Users management
 */
class PermissionUserController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam page integer To specify the page number to be retrieved. Example:1
     * @queryParam per_page integer To specify the number of records per page. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Permission_user(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Permission_User.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Permission_user(), $id, str($request->with));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), ['permission_id' => 'required|exists:permissions,id|unique:permission_users,permission_id,NULL,id,user_id,' . $request->input('user_id'), 'user_id' => 'required|exists:users,id|unique:permission_users,user_id,NULL,id,permission_id,' . $request->input('permission_id')]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 404, 'Failed');
        }
        return $this->store_data($request, new Permission_user());
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Permission_User.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Permission_user());
    }
}
