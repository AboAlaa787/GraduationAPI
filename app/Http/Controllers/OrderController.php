<?php

namespace App\Http\Controllers;

use App\Enums\RuleNames;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Models\Client;
use App\Models\Device;
use App\Models\Devices_orders;
use App\Models\Order;
use App\Models\Product;
use App\Models\Product_order;
use App\Models\User;
use App\Traits\CRUDTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * @group Orders management
 */
class OrderController extends Controller
{
    use CRUDTrait;

    /**
     * @param Request $request
     * @queryParam with string To query related data. No-example
     * @queryParam orderBy To sort data. No-example
     * @queryParam dir To determine the direction of the sort, default is asc. Example:[asc,desc]
     * @queryParam withCount string To query the number of records for related data. No-example
     * @queryParam page integer To specify the page number to be retrieved. Example:1
     * @queryParam per_page integer To specify the number of records per page. No-example
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->index_data(new Order(), $request, str($request->with));
    }

    /**
     * @param $id
     * @param Request $request
     * @urlParam  id  integer required The ID of the Order.
     * @queryParam with string To query related data. No-example
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        return $this->show_data(new Order(), $id, str($request->with));
    }

    /**
     * @param CreateOrderRequest $request
     * @bodyParam products_ids integer[] Product numbers to be added to the order.
     * @bodyParam devices_ids integer[] devices numbers to be added to the order.
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', Order::class);
            $products_ids = $request->get('products_ids', []);
            $devices_ids = $request->get('devices_ids', []);

            $delivery = $this->getDelivery();

            if (is_null($delivery)) {
                return $this->apiResponse(null, 422, 'Sorry, there are no delivery customers at the moment!');
            }

            if (empty($products_ids) && empty($devices_ids)) {
                return $this->apiResponse(null, 400, 'Error: At least one of device_id or product_id is required.');
            }

            return DB::transaction(function () use ($request, $products_ids, $devices_ids, $delivery) {
                $client = Client::findOrFail($request->client_id);
                $oldOrder = $client->orders()->where('deliver_to_user', false)->first();
                $order = $oldOrder ?: $client->orders()->create(['client_id' => $request->client_id]);

                if (!empty($devices_ids)) {
                    $this->authorize('create', Devices_orders::class);
                    $this->attachItemsToOrder($devices_ids, Device::class, $order, 'devices');
                }

                if (!empty($products_ids)) {
                    $this->authorize('create', Product_order::class);
                    $this->attachItemsToOrder($products_ids, Product::class, $order, 'products');
                }

                $order->user_id = $delivery->id;
                $order->load(['devices', 'products']);
                $order->save();
                return $this->apiResponse($order);
            });
        } catch (InvalidArgumentException  $exception) {
            return $this->apiResponse(null, 400, 'Error: ' . $exception->getMessage());

        } catch (ModelNotFoundException  $exception) {
            $model = explode('\\', $exception->getModel());
            $model = end($model);
            $id = $exception->getIds()[0];
            return $this->apiResponse(null, 404, "Error: $model with ID $id not found.");

        } catch (AuthorizationException $exception) {
            return $this->apiResponse(null, 403, 'Error: ' . $exception->getMessage());
        }
    }

    protected function attachItemsToOrder($items, $modelClass, $order, $relation): void
    {
        if (!is_array($items)) {
            throw new InvalidArgumentException($relation . '_ids must be an array.');
        }
        foreach ($items as $item_id) {
            $item = $modelClass::findOrFail($item_id);

            if ($order->{$relation}->contains($item->id)) {
                throw new InvalidArgumentException('Error: id ' . $item_id . ' in ' . $relation . '_id is already attached to the order.');
            }
        }
        $order->{$relation}()->syncWithoutDetaching($items);
    }

    protected function getDelivery(): ?User
    {
        $deliveriesWithDevicesCount = User::withCount('devices')->where('at_work', true)->whereHas('rule', function ($query) {
            $query->where('name', RuleNames::Delivery);
        })->get();
        if (!$deliveriesWithDevicesCount) {
            $minDevicesCount = $deliveriesWithDevicesCount->min('devices_count');
            return $deliveriesWithDevicesCount->where('devices_count', $minDevicesCount)->shuffle()->first();
        }
        return null;
    }

    /**
     * @param UpdateOrderRequest $request
     * @param $id
     * @urlParam  id  integer required The ID of the Order.
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, $id): JsonResponse
    {
        return $this->update_data($request, $id, new Order());
    }

    /**
     * @param $id
     * @return JsonResponse
     * @urlParam  id  integer required The ID of the Order.
     */
    public function destroy($id): JsonResponse
    {
        return $this->destroy_data($id, new Order());
    }
}
