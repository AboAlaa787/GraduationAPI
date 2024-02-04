<?php

namespace App\Http\Controllers;

use App\Http\Requests\ruleRequest;
use App\Models\Rule;
use App\Traits\CRUDTrait;

use function PHPUnit\Framework\returnSelf;

class RuleController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Rule::class);
    }
    public function show($id)
    {
        return $this->show_data(Rule::class,$id);
    }
    public function store(ruleRequest $request)
    {
        return $this->store_data($request, Rule::class);
    }
    public function update(ruleRequest $request, $id)
    {
        return $this->update_data($request, $id, Rule::class);
    }
    public function destroy($id)
    {
        return $this->delete_data($id, Rule::class);
    }
}
