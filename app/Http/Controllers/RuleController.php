<?php

namespace App\Http\Controllers;

use App\Http\Requests\ruleRequest;
use App\Models\Rule;
use App\Traits\ApiResponseTrait;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class RuleController extends Controller
{
    use CRUDTrait;
    use ApiResponseTrait;

    public function index()
    {
        return $this->get_data(Rule::class);
    }
    public function store(ruleRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|min:2|max:6'
        // ]);
        // if ($validator->fails()) {
        //     return $this->apiResponse(null, 400);
        // }
        return $this->store_data($request, Rule::class);
    }
    public function update(ruleRequest $request, $id)
    {
        return $this->update_data($request, $id, Rule::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, Rule::class);
    }
}
