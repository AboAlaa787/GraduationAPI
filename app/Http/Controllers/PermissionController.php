<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Permissions management
 */
class PermissionController extends Controller
{
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam withCount string To query the number of records for related data. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Permission(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Permission.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Permission(), $id, str($request->with));
    }

    /**
     * Adding a permission is not allowed
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // return $this->store_data($request, new Permission());
        return $this->apiResponse([], 403, 'Adding a permission is not allowed');
    }

    /**
     * Updating a permission is not allowed
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @urlParam  id  integer required The ID of the Permission.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // return $this->update_data($request, $id, new Permission());
        return $this->apiResponse([], 403, 'Updating a permission is not allowed');
    }

    /**
     * Deleting a permission is not allowed
     * @param $id
     * @return JsonResponse
     * @urlParam  id  integer required The ID of the Permission.
     */
    public function destroy($id): JsonResponse
    {
        // return $this->delete_data($id, new Permission());
        return $this->apiResponse([], 403, 'Deleting a permission is not allowed');

    }
}
