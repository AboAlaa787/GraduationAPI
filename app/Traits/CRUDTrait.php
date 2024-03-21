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
    public function get_data($model, Request $request, $with = ''): JsonResponse
    {
        try {
            $this->authorize('viewAny', $model);
        } catch (Exception $e) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }

        $relations = $this->parseRelations($with);

        if ($relations === false) {
            return $this->apiResponse(null, 422, "Invalid relations format");
        }

        $response = $this->validateRelations((new $model()), $relations);

        if ($response) return $response;

        $table = (new $model())->getTable();
        $keys = $request->except(['orderBy', 'dir', 'with']);
        $customKeys = [];
        foreach ($keys as $key => $value) {
            if (strpos($key, '*') !== false) {
                $newKey = str_replace('*', '.', $key);
                $customKeys[$newKey] = $value;
                unset($keys[$key]);
            }
        }
        $orderBy = $request->get('orderBy');
        $orderDirection = $request->get('dir', 'asc');
        $model = $model::query();

        return $this->filterAndOrder($model, $table, $keys, $orderBy, $orderDirection, $relations, $customKeys);
    }

    private function handleOrdering($model, $table, $orderBy, $orderDirection, $relations,$customKeys)
    {
        if (empty($orderBy)) {
            if(empty($customKeys))
              return $this->apiResponse($model->with($relations)->get());

              $model =  $model->with($relations)->get();
              foreach ($customKeys as $customKey => $value) {
                  $model = $model->where($customKey, $value);
              }
              return $this->apiResponse($model);
        }

        if (!$this->validateColumn($table, $orderBy)) {
            return $this->apiResponse(['error' => 'Invalid column: ' . $orderBy], 422, 'Failed');
        }

        if (!in_array($orderDirection, ['asc', 'desc'])) {
            if(empty($customKeys))
            return $this->apiResponse($model->orderBy($orderBy, 'asc')->with($relations)->get());

            $model =  $model->orderBy($orderBy, 'asc')->with($relations)->get();
            foreach ($customKeys as $customKey => $value) {
                $model = $model->where($customKey, $value);
            }
            return $this->apiResponse($model);
        }
        if(empty($customKeys))
        return $this->apiResponse($model->orderBy($orderBy, $orderDirection)->with($relations)->get());

        $model =  $model->orderBy($orderBy, $orderDirection)->with($relations)->get();
        foreach ($customKeys as $customKey => $value) {
            $model = $model->where($customKey, $value);
        }
        return $this->apiResponse($model);
    }

    private function filterAndOrder($model, $table, $keys, $orderBy, $orderDirection, $relations, $customKeys)
    {
        $missingColumns = [];

        foreach ($keys as $key => $value) {
            if ($this->validateColumn($table, $key)) {
                $model->where($key, 'LIKE', '%' . $value . '%');
            } else {
                $missingColumns[] = $key;
            }
        }

        if (!empty($missingColumns)) {
            return $this->apiResponse(null, 422, 'Missing columns: ' . implode(', ', $missingColumns));
        }

        return $this->handleOrdering($model, $table, $orderBy, $orderDirection, $relations,$customKeys);
    }

    private function validateColumn($table, $column)
    {
        return Schema::hasColumn($table, $column);
    }

    /**
     * @throws AuthorizationException
     */
    public function show_data($model, $id, $with = ''): JsonResponse
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


        $relations = $this->parseRelations($with);

        if ($relations === false) {
            return $this->apiResponse(null, 422, "Invalid relations format");
        }

        $response = $this->validateRelations($object, $relations);

        if ($response) {
            return $response;
        }

        $data = $object->load($relations);
        return $this->apiResponse($data);
    }

    private function parseRelations($with)
    {
        if (empty($with)) {
            return [];
        }

        $relations = explode(',', $with);

        return $relations;
    }

    private function validateRelations($object, $relations): ?JsonResponse
    {
        try {
            $modelRelations = $object->getRelations();

            $invalidRelations = array_diff($relations, $modelRelations);

            if (!empty($invalidRelations)) {
                $invalidRelationsStr = implode(', ', $invalidRelations);
                return $this->apiResponse([], 400, "Invalid relations: $invalidRelationsStr");
            }
            return null;
        } catch (Exception $ex) {
            return $this->apiResponse(['error' => $ex->getMessage()], 422, 'Failed');
        }
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
