<?php

namespace App\Http\Controllers;

use App\Http\Requests\Devices\CreateDeviceAndCustomerRequest;
use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Models\Customer;
use App\Models\Device;
use App\Traits\CRUDTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @queryParam page integer To specify the page number to be retrieved, Default is 1. Example:1
     * @queryParam per_page integer To specify the number of records per page, Default is 20. Example:10
     * @queryParam all_data integer To ignore pagination process, Default is 0, Allowed values is 0,1. No-example
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
        return $this->store_data($request, new Device());
    }

    /**
     * @param UpdateDeviceRequest $request
     * @param $id
     * @urlParam  id  integer required The ID of the Device.
     * @return JsonResponse
     */
    public function update(UpdateDeviceRequest $request, $id): JsonResponse
    {
        try {
            if ($request->exists('client_priority')) {
                $device = Device::findOrFail($id);
                $client = $device->client;
                $oldPriority = $device->client_priority;
                $newPriority = $request->get('client_priority');
                $device->client_priority = null;
                $device->save();
                if ($oldPriority > $newPriority) {
                    if ($client->devices()->where('client_priority', $newPriority)->exists()) {
                        $devicesToUpdate = $client->devices()->where('client_priority', '>=', $newPriority)
                            ->where('client_priority', '<', $oldPriority)
                            ->get()
                            ->sortByDesc('client_priority');
                        foreach ($devicesToUpdate as $deviceToUpdate) {
                            $deviceToUpdate->update(['client_priority' => $deviceToUpdate->client_priority + 1]);
                        }
                    }
                } else {
                    $maxPriority = $client->devices()->max('client_priority');

                    if ($newPriority > $maxPriority) {
                        if ($oldPriority>$maxPriority){
                            $newPriority = $maxPriority + 1;
                        }else{
                            $newPriority=$maxPriority;
                        }
                    }
                    $devicesToUpdate = $client->devices()->where('client_priority', '<=', $newPriority)
                        ->where('client_priority', '>', $oldPriority)
                        ->get()->sortBy('client_priority');
                    foreach ($devicesToUpdate as $deviceToUpdate) {
                        $deviceToUpdate->update(['client_priority' => $deviceToUpdate->client_priority - 1]);
                    }
                }
                $device->client_priority = $newPriority;
                $device->save();
            }

        } catch (ModelNotFoundException  $exception) {
            $model = explode('\\', $exception->getModel());
            $model = end($model);
            $id = $exception->getIds()[0];
            return $this->apiResponse(null, 404, "Error: $model with ID $id not found.");
        }
        catch (Exception $exception){
            return $this->apiResponse(null, 500, $exception->getMessage());
        }
        return $this->update_data($request, $id, new Device());
    }

    /**
     * @param $id
     * @urlParam  id  integer required The ID of the Device.
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return  $this->destroy_data($id, new Device());
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
