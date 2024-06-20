<?php

namespace App\Http\Controllers;

use App\Http\Requests\Centers\CreateCenterRequest;
use App\Http\Requests\Centers\UpdateCenterRequest;
use App\Models\Center;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        $centers=Center::all();
        return $this->apiResponse($centers);
    }

    public function show($id): JsonResponse
    {
        return $this->show_data(new Center(), $id);
    }

    public function store(CreateCenterRequest $request): JsonResponse
    {
        return $this->store_data($request, new Center());
    }

    public function update(UpdateCenterRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Center());
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Center());
    }
}
