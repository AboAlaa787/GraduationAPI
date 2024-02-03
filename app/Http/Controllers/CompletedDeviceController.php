<?php

namespace App\Http\Controllers;

use App\Models\CompletedDevice;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class CompletedDeviceController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(CompletedDevice::class);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, CompletedDevice::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, CompletedDevice::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, CompletedDevice::class);
    }
}
