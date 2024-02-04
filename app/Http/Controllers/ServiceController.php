<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Service::class);
    }

    public function show($id)
    {
        return $this->show_data(Service::class, $id);
    }

    public function store(Request $request)
    {
        return $this->store_data($request, Service::class);
    }

    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Service::class);
    }

    public function destroy($id)
    {
        return $this->delete_data($id, Service::class);
    }
}
