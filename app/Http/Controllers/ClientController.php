<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Client::class);
    }
    public function store(Request $request)
    {
        return $this->store_data($request, Client::class);
    }
    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Client::class);
    }
    public function distroy($id)
    {
        return $this->delete_data($id, Client::class);
    }
}
