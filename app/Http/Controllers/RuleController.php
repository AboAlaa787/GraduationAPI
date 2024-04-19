<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rules\CreateRuleRequest;
use App\Models\Rule;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Rule management
 */
class RuleController extends Controller
{
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Rule(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Rule.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Rule(), $id, str($request->with));
    }

    /**
     * @param CreateRuleRequest $request
     * @return JsonResponse
     */
    public function store(CreateRuleRequest $request): JsonResponse
    {
        return $this->apiResponse([], 403, 'Adding a rule is not allowed');
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Rule.
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        return $this->apiResponse([], 403, 'Updating a rule is not allowed');
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Rule.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Rule());
    }
}
