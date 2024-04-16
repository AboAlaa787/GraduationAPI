<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rules\CreateRuleRequest;
use App\Models\Rule;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Rule(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Rule(), $id, str($request->with));
    }

    public function store(CreateRuleRequest $request): JsonResponse
    {
        return $this->apiResponse([], 403, 'Adding a rule is not allowed');
    }

    public function update($id): JsonResponse
    {
        return $this->apiResponse([], 403, 'Updating a rule is not allowed');
    }

    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Rule());
    }
}
