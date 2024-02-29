<?php

namespace App\Traits;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait CRUDTrait
{
    use ApiResponseTrait;

    /**
     * @throws AuthorizationException
     */
    public function get_data($model, Request $request): JsonResponse
    {
        try {
            $this->authorize('viewAny', $model);
        } catch (Exception $e) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }
        $table = (new $model())->getTable();
        $keys = $request->all();
        if (empty($keys)) {
            return $this->apiResponse($model::all());
        }
        $items = $model::query();
        $missingColumns = [];
        foreach ($request->all() as $key => $value) {
            if (Schema::hasColumn($table, $key)) {
                $items = $items->where($key, 'LIKE', '%' . $value . '%');
            } else {
                $missingColumns[] = $key;
            }
        }
        if (!empty($missingColumns)) {
            $missingColumnsString = implode(', ', $missingColumns);
            return $this->apiResponse(null, 422, 'The ' . $table . ' table does not contain column(s):' . $missingColumnsString);
        }
        $items = $items->get();
        return $this->apiResponse($items);
    }

    /**
     * @throws AuthorizationException
     */
    public function show_data($model, $id, $with = []): JsonResponse
    {
        try {
            $this->authorize('view', $model);
        } catch (Exception $e) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }

        $object = $model::find($id);

        if (!$object) {
            return $this->apiResponse(null, 404, "No item found with id: $id");
        }

        if (!empty($with)) {
            $with = explode(',', $with);
            $response = $this->validateRelations($object, $with);

            if ($response) {
                return $response;
            }

        } else {
            $with = [];
        }

        $data = $object->with($with)->where('id', $id)->get();
        return $this->apiResponse($data);
    }

    private function validateRelations($object, $with): ?JsonResponse
    {
        $relations = $object->getRelations();

        $invalidRelations = array_diff($with, $relations);

        if (!empty($invalidRelations)) {
            $invalidRelationsStr = implode(', ', $invalidRelations);
            return $this->apiResponse([], 400, "Invalid relations: $invalidRelationsStr");
        }
        return null;
    }

    /**
     * @throws AuthorizationException
     */
    public function store_data($request, $model): JsonResponse
    {
        try {
            $this->authorize('create', $model);
        } catch (Exception) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }
        return $this->apiResponse($model::create($request->all()), 201, 'Add successful');
    }

    /**
     * @throws AuthorizationException
     */
    public function update_data($request, $id, $model): JsonResponse
    {
        try {
            $this->authorize('update', $model);
        } catch (Exception $e) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }
        $object = $model::find($id);
        if (!$object) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        $columns = $request->keys();
        foreach ($columns as $column) {
            $object->$column = $request[$column];
        }
        $object->save();
        return $this->apiResponse($object, 201, 'Update successful');
    }

    /**
     * @throws AuthorizationException
     */
    public function delete_data($id, $model): JsonResponse
    {
        try {
            $this->authorize('delete', $model);
        } catch (Exception $e) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }
        $delete = $model::find($id);
        if (!$delete) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        $delete->destroy($id);
        return $this->apiResponse('Delete successfully', 200);
    }
}
