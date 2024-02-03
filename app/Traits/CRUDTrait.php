<?php

namespace App\Traits;

use Illuminate\Http\Request;


trait CRUDTrait
{
    use ApiResponseTrait;
    public function get_data($model)
    {
        return $this->apiResponse($model::all());
    }
    public function store_data(Request $request, $model)
    {
        $new_data = $model::create($request->all());
        if ($new_data) {
            return $this->apiResponse($new_data, 201);
        }
        return $this->apiResponse($new_data, 400);
    }
    public function update_data(Request $request, $id, $model)
    {
        $new_data = $model::find($id);
        if (!$new_data) {
            return $this->apiResponse(null, 404);
        }
        $new_data->update($request->all());
        return $this->apiResponse($new_data, 201);
    }
    public function delete_data($id, $model)
    {
        $delete = $model::find($id);
        if (!$delete) {
            return $this->apiResponse(null, 404);
        }
        $delete->destroy($id);
        if ($delete) {
            return $this->apiResponse(null, 200);
        }
    }
}
