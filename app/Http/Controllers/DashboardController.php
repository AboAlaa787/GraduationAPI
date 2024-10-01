<?php

namespace App\Http\Controllers;

use App\Enums\DeviceStatus;
use App\Enums\RuleNames;
use App\Models\Client;
use App\Models\CompletedDevice;
use App\Models\Device;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request): JsonResponse
    {
        try {
            if (auth()->user()->rule->name!==RuleNames::Admin->value){
                throw new UnauthorizedException("This action is unauthorized");
            }
            //Number of exist devices in the center
            $devicesCount = Device::
            where('repaired_in_center', true)
                ->where('deliver_to_client', false)
                ->count();
            $response['devices_count'] = $devicesCount;

            //Number of ready devices in the center
            $readyDevicesCount = Device::
            where('repaired_in_center', true)
                ->where('deliver_to_client', false)
                ->where('date_receipt','!=',null)
                ->where('status',DeviceStatus::Ready->value)
                ->count();
            $response['ready_devices_count'] = $readyDevicesCount;

            //Number of in progress devices in the center
            $inProgressDevicesCount = Device::
            where('repaired_in_center', true)
                ->where('date_receipt','!=',null)
                ->where('deliver_to_client', false)
                ->where('status',DeviceStatus::InProgress->value)
                ->count();
            $response['in_progress_devices_count'] = $inProgressDevicesCount;

            //Number of deliverable devices in the center
            $deliverableDevicesCount = Device::
            where('repaired_in_center', true)
                ->where('deliver_to_client', false)
                ->whereIn('status',
                    [
                        DeviceStatus::Ready,
                        DeviceStatus::NotReady,
                        DeviceStatus::NotAgree,
                        DeviceStatus::NotMaintainable
                    ])
                ->where('date_receipt','!=',null)
                ->count();
            $response['deliverable_devices_count'] = $deliverableDevicesCount;

            //Number of ready delivered devices
            $readyCompletedDevicesCount = CompletedDevice::
            where('repaired_in_center', true)
                ->where('date_receipt','!=',null)
                ->where('status',DeviceStatus::Ready->value)
                ->count();
            $response['ready_completed_devices_count'] = $readyCompletedDevicesCount;

            //Number of unready delivered devices
            $unreadyCompletedDevicesCount = CompletedDevice::
            where('repaired_in_center', true)
                ->where('date_receipt','!=',null)
                ->where('status',DeviceStatus::NotReady->value)
                ->orWhere('status',DeviceStatus::NotMaintainable->value)
                ->count();
            $response['unready_completed_devices_count'] = $unreadyCompletedDevicesCount;

            //Number of delivered devices in this month
            $inMonthCompletedDevicesCount = CompletedDevice::
            where('repaired_in_center', true)
                ->where('date_receipt','!=',null)
                ->whereYear('date_delivery_client',now()->year)
                ->whereMonth('date_delivery_client',now()->month)
                ->count();
            $response['completed_devices_count_in_this_month'] = $inMonthCompletedDevicesCount;

            //Get top 5 technicians and their successful job
            $techniciansWithReadyDevicesCount = User::
                whereHas('rule', function ($rule) {
                    $rule->where('name', RuleNames::Technician);
                })
                ->whereHas('completed_devices')
                ->withCount([
                    'completed_devices' => function ($completedDevices) {
                        $completedDevices->where('status', DeviceStatus::Ready->value)->whereMonth('date_delivery_client',now()->month);
                    }
                ])
                ->orderBy('completed_devices_count', 'desc')
                ->limit(5)
                ->get()
                ->select('name', 'last_name', 'completed_devices_count');
            $formattedTechnicians = $techniciansWithReadyDevicesCount->map(function ($technician) {
                return [
                    'name' => $technician['name'] . ' ' . $technician['last_name'],
                    'completed_devices_count' => $technician['completed_devices_count']
                ];
            });
            $response['technicians_with_ready_devices_count'] = $formattedTechnicians;

            //Get top 4 clients and their contributions in this month
            $clients = Client::query()
                ->select(['id','name'])
                ->selectSub(function ($query) {
                    $query->from('devices')
                        ->selectRaw('COUNT(*)')
                        ->whereColumn('client_id', 'clients.id')
                        ->whereRaw("repaired_in_center = 1")
                        ->whereRaw("deliver_to_client = 0")
                        ->whereRaw("MONTH(date_receipt) = MONTH(CURRENT_DATE())")
                        ->whereRaw("YEAR(date_receipt) = YEAR(CURRENT_DATE())");
                }, 'devices_count1')
                ->selectSub(function ($query) {
                    $query->from('completed_devices')
                        ->selectRaw('COUNT(*)')
                        ->whereColumn('client_id', 'clients.id')
                        ->whereRaw("MONTH(date_receipt) = MONTH(CURRENT_DATE())")
                        ->whereRaw("YEAR(date_receipt) = YEAR(CURRENT_DATE())");
                }, 'completed_devices_count')
                ->orderByRaw('devices_count1 + completed_devices_count DESC')
                ->limit(4)
                ->get();
            $clientsWithDevicesCount=[];
            foreach ($clients as $client) {
                $ss['name']=$client->name;
                $ss['first_week']=$this->getWeeklyDeviceCount(0,$client->id,7);
                $ss['second_week']=$this->getWeeklyDeviceCount(7,$client->id,14);
                $ss['third_week']=$this->getWeeklyDeviceCount(14,$client->id,21);
                $ss['fourth_week']=$this->getWeeklyDeviceCount(21,$client->id);
                $clientsWithDevicesCount[]=$ss;
            }
            $response['clients_with_devices_count']=$clientsWithDevicesCount;
            return $this->apiResponse($response);
        }catch (UnauthorizedException $e){
            return $this->apiResponse(null,403,$e->getMessage());
        }
    }

    function getWeeklyDeviceCount($startDay,$clientId, $endDay = null):int
    {
        $client=Client::find($clientId);
        $dateCondition = $endDay ? "DAYOFMONTH(date_receipt) > $startDay AND DAYOFMONTH(date_receipt) <= $endDay"
            : "DAYOFMONTH(date_receipt) > $startDay";
        $devicesCountInWeek=$client->devices()
            ->whereRaw("deliver_to_client = 0")
            ->whereRaw("repaired_in_center = 1")
            ->whereRaw("MONTH(date_receipt) = MONTH(CURRENT_DATE())")
            ->whereRaw("YEAR(date_receipt) = YEAR(CURRENT_DATE())")
            ->whereRaw($dateCondition)->count();
        $completedDevicesCountInWeek=$client->completed_devices()
            ->whereRaw("repaired_in_center = 1")
            ->whereRaw("MONTH(date_receipt) = MONTH(CURRENT_DATE())")
            ->whereRaw("YEAR(date_receipt) = YEAR(CURRENT_DATE())")
            ->whereRaw($dateCondition)->count();
        return $devicesCountInWeek+$completedDevicesCountInWeek;
    }
}
