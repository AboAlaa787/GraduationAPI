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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use CRUDTrait;

    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Device(), $request, str($request->with));
    }

    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Device(), $id, str($request->with));
    }

    public function store(CreateDeviceRequest $request): JsonResponse
    {
        $response = $this->store_data($request, new Device());
        if ($response->isSuccessful()) {
            event(new AddDevice($request->client_id));
        }
        return $response;
    }

    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
        $response = $this->update_data($request, $id, new Device());
        if ($response->isSuccessful()) {
            event(new ClientApproval($id));
            event(new DeleteDevice($id));
            event(new DeviceNotifications($id));
        }
        return $response;
    }

    public function destroy($id): JsonResponse
    {
        $response = $this->destroy_data($id, new Device());
        if ($response->isSuccessful()) {
            event(new DeleteDevice($id));
        }
        return $response;
    }

    /**
     * @param CreateDeviceAndCustomerRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function storeDeviceAndCustomer(CreateDeviceAndCustomerRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', Device::class);
            $this->authorize('create', Customer::class);
            $customer = Customer::firstOrCreate(['national_id' => $request->national_id], $request->all());
            $request['customer_id']=$customer->id;
            $device = Device::create($request->all());
            return $this->apiResponse([
                'device' => $device,
                'customer' => $customer
            ]);
        } catch (AuthorizationException $e) {
            return $this->apiResponse(null, 403, 'Error: ' . $e->getMessage());
        }
        catch (Exception $e){
            return $this->apiResponse(null, 500, 'Error: ' . $e->getMessage());
        }
    }
}
