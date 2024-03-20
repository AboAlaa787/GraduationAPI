<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rules\CreateRuleRequest;
use App\Http\Requests\Rules\UpdateRuleRequest;
use App\Models\Rule;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    use CRUDTrait;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Rule::class,$request, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Rule::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateRuleRequest $request): JsonResponse
    {
        return $this->store_data($request, Rule::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateRuleRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, Rule::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        return $this->delete_data($id, Rule::class);
    }
}
