<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Permission::class);
    }

    public function show($id)
    {
        return $this->show_data(Permission::class, $id);
    }

    public function store(Request $request)
    {
        return $this->store_data($request, Permission::class);
    }

    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Permission::class);
    }

    public function destroy($id)
    {
        return $this->delete_data($id, Permission::class);
    }
}
