<?php

namespace App\Http\Controllers;

use App\Http\Requests\Centers\CreateCenterRequest;
use App\Http\Requests\Centers\UpdateCenterRequest;
use App\Models\Center;
use App\Traits\CRUDTrait;

class CenterController extends Controller
{
    use CRUDTrait;

    public function index()
    {
        return $this->get_data(Center::class);
    }

    public function show($id)
    {
        return $this->show_data(Center::class,$id);
    }

    public function store(CreateCenterRequest $request)
    {
        return $this->store_data($request, Center::class);
    }

    public function update(UpdateCenterRequest $request, $id)
    {
        $object = Center::find($id);
        if (!$object) {
            return $this->apiResponse(null, 404, 'There is no item with id ' . $id);
        }
        if ($request['status'])
            $object->status = $request['status'];
        if ($request['address'])
            $object->address = $request['address'];
        if ($request['start_work'])
            $object->start_work = $request['start_work'];
        if ($request['end_work'])
            $object->end_work = $request['end_work'];
        $object->save();
        return $this->apiResponse($object, 200, 'Update successful');
    }

    public function destroy($id)
    {
        return $this->delete_data($id, Center::class);
    }
}
