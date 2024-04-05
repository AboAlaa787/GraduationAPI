<?php

namespace App\Http\Controllers;

use App\Events\AddDevice;
use App\Events\ClientApproval;
use App\Events\DeleteDevice;
use App\Events\NotificationEvents\DeviceNotifications;
use App\Http\Requests\Devices\CreateDeviceAndCustomerRequest;
use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Models\Customer;
use App\Models\Device;
use App\Traits\CRUDTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use CRUDTrait;


    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        return $this->get_data(Device::class, $request, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(Device::class, $id, $request->with);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CreateDeviceRequest $request): JsonResponse
    {
        $response = $this->store_data($request, Device::class);
        if ($response->isSuccessful()) {
            event(new AddDevice($request->client_id));
        }
        return $response;
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
        $response = $this->update_data($request, $id, Device::class);
        if ($response->isSuccessful()) {
            event(new ClientApproval($id));
            event(new DeleteDevice($id));
            event(new DeviceNotifications($id));
        }
        return $response;
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        $device = Device::find($id);
        $response = $this->delete_data($id, Device::class);
        if ($response->isSuccessful()) {
            event(new DeleteDevice($id));
        }
        return $response;
    }

    function storeDeviceAndCustomer(CreateDeviceAndCustomerRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', Device::class);
            $this->authorize('create', Customer::class);
        } catch (Exception) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }
        $customer = Customer::firstOrCreate(['national_id' => $request->national_id], $request->all());
        $request['customer_id']=$customer->id;
        $device = Device::create($request->all());
        return $this->apiResponse([
            'device' => $device,
            'customer' => $customer
        ]);
    }
}
