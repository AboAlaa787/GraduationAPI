<?php

namespace App\Http\Controllers;

use App\Models\Permission_client;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionClientController extends Controller
{
    use ApiResponseTrait;
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Permission_client(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Permission_client(), $id, str($request->with));
    }

    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), ['permission_id' => 'required|exists:permissions,id|unique:permission_clients,permission_id,NULL,id,client_id,' . $request->input('client_id'), 'client_id' => 'required|exists:clients,id|unique:permission_clients,client_id,NULL,id,permission_id,' . $request->input('permission_id')]);
        if ($validation->fails()) {
            return $this->apiResponse($validation->messages(), 404, 'Failed');
        }
        return $this->store_data($request, new Permission_client());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Permission_client());
    }
}
