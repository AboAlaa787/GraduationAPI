<?php

namespace App\Http\Controllers;

use App\Events\AddDevice;
use App\Events\DeleteDevice;
<<<<<<< HEAD
use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
=======
use App\Events\NotificationEvents\DeviceNotifications;
use App\Http\Requests\Devices\CreateDeviceAndCustomerRequest;
use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Models\Customer;
>>>>>>> 612f2e305d8e32f7970dfc697857273af0d3d8c4
use App\Models\Device;
use App\Traits\CRUDTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Model;
>>>>>>> 612f2e305d8e32f7970dfc697857273af0d3d8c4
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Devices management
 */
class DeviceController extends Controller
{
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Device(), $request, str($request->with));
    }

    /**
     * @param integer $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Device.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Device(), $id, str($request->with));
    }

    /**
     * @param CreateDeviceRequest $request
     * @return JsonResponse
     */
    public function store(CreateDeviceRequest $request): JsonResponse
    {
        $response = $this->store_data($request, new Device());
        if ($response->isSuccessful()) {
            event(new AddDevice($request->client_id));
        }
        return $response;
    }

    /**
     * @param UpdateDeviceRequest $request
     * @param $id
     * @urlParam  id  integer required The ID of the Device.
     * @return JsonResponse
     */
    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
<<<<<<< HEAD
        return $this->update_data($request, $id, Device::class);;
=======
        $response = $this->update_data($request, $id, new Device());
        if ($response->isSuccessful()) {
            event(new ClientApproval($id));
            event(new DeleteDevice($id));
            event(new DeviceNotifications($id));
        }
        return $response;
>>>>>>> 612f2e305d8e32f7970dfc697857273af0d3d8c4
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Device.
     * @return JsonResponse
     */
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
