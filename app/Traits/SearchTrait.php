<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

trait SearchTrait
{
    use ApiResponseTrait;
    /**
     * Display search result.
     *
     * @param Model $model
     * @param string $keyword
     * @return JsonResponse
     */
    public function get_search(Model $model, string $keyword): JsonResponse
    {
        $searchableColumns = $model->getSearchAbleColumns();

        $object = $model::where(function ($query) use ($keyword, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                $query->orWhere($column, 'LIKE', "%$keyword%");
            }
        })->get();

        return $this->apiResponse($object);
    }
}
