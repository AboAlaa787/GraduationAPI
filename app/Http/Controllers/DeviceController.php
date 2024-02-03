<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Device::class);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, Device::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Device::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, Device::class);
    }
}
