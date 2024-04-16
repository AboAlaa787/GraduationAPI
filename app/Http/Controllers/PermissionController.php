<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Permission(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Permission(), $id, str($request->with));
    }

    public function store(Request $request): JsonResponse
    {
        // return $this->store_data($request, new Permission());
        return $this->apiResponse([], 403, 'Adding a permission is not allowed');
    }

    public function update(Request $request, $id): JsonResponse
    {
        // return $this->update_data($request, $id, new Permission());
        return $this->apiResponse([], 403, 'Updating a permission is not allowed');
    }

    public function destroy($id): JsonResponse
    {
        // return $this->delete_data($id, new Permission());
        return $this->apiResponse([], 403, 'Deleting a permission is not allowed');

    }
}
