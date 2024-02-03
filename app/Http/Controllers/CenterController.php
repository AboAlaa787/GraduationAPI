<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Center::class);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, Center::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Center::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, Center::class);
    }
}
