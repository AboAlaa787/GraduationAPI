<?php

namespace App\Http\Controllers;

use App\Http\Requests\Centers\CreateCenterRequest;
use App\Http\Requests\Centers\UpdateCenterRequest;
use App\Models\Center;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Center::class,$request);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): JsonResponse
    {
        return $this->show_data(Center::class, $id);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateCenterRequest $request): JsonResponse
    {
        return $this->store_data($request, Center::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateCenterRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Center::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Center::class);
    }
}
