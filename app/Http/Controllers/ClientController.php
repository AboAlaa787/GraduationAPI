<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class ClientController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Client::class);
    }

    public function show($id)
    {
       return $this->show_data(Client::class,$id);
    }

    public function store(Request $request)
    {
        return $this->store_data($request, Client::class);
    }

    public function update(Request $request, $id)
    {
        return $this->update_data($request, $id, Client::class);
    }

    public function destroy($id)
    {
        return $this->delete_data($id, Client::class);
    }
}
