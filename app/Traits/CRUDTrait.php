<?php

namespace App\Traits;

trait CRUDTrait
{
    use ApiResponseTrait;

    public function get_data($model)
    {
        return $this->apiResponse($model::all());
    }

    public function show_data($model, $id)
    {
        $object = $model::find($id);
        if (!$object) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        return $this->apiResponse($object);
    }

    public function store_data($request, $model)
    {
        return $this->apiResponse($model::create($request->all()), 201, 'Add successful');
    }

    public function update_data($request, $id, $model)
    {
        $object = $model::find($id);
        if (!$object) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        $object->update($request->all());
        return $this->apiResponse($object, 201, 'Update successful');
    }

    public function delete_data($id, $model)
    {
        $delete = $model::find($id);
        if (!$delete) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        $delete->destroy($id);
        return $this->apiResponse('Delete successfully', 200);
    }
}
