<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

trait CRUDTrait
{
    use ApiResponseTrait;

    /**
     * @throws AuthorizationException
     */
    public function get_data($model): JsonResponse
    {
        $this->authorize('viewAny', $model);
        return $this->apiResponse($model::all());
    }

    /**
     * @throws AuthorizationException
     */
    public function show_data($model, $id, $with = []): JsonResponse
    {
        $this->authorize('view', $model);
        $object = $model::find($id);
        if (!$object) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        if ($with) {
            $with = explode(',', $with);
            foreach ($with as $item) {
                $validator = Validator::make(
                    ['relation' => $item],
                    ['relation' => 'in:' . implode(",", $object->getRelations())],
                );
                if ($validator->fails()) {
                    return $this->apiResponse([], 400, 'There is no relation to the name ' . $item);
                }
            }
        }
        return $this->apiResponse($object->with($with)->where('id', $id)->get());
    }

    /**
     * @throws AuthorizationException
     */
    public function store_data($request, $model): JsonResponse
    {
        $this->authorize('create', $model);
        return $this->apiResponse($model::create($request->all()), 201, 'Add successful');
    }

    /**
     * @throws AuthorizationException
     */
    public function update_data($request, $id, $model): JsonResponse
    {
        $this->authorize('update', $model);
        $object = $model::find($id);
        if (!$object) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        $columns = $request->keys();
        foreach ($columns as $column) {
            $object->$column = $request[$column];
        }
        return $this->apiResponse($object, 201, 'Update successful');
    }

    /**
     * @throws AuthorizationException
     */
    public function delete_data($id, $model): JsonResponse
    {
        $this->authorize('delete', $model);
        $delete = $model::find($id);
        if (!$delete) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        $delete->destroy($id);
        return $this->apiResponse('Delete successfully', 200);
    }
}
