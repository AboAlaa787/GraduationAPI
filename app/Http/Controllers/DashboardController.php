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

class DashboardController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request): JsonResponse
    {
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
            ->where('status',DeviceStatus::Ready->value)
            ->count();
        $response['ready_devices_count'] = $readyDevicesCount;

        //Number of in progress devices in the center
        $inProgressDevicesCount = Device::
        where('repaired_in_center', true)
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
            ->count();
        $response['deliverable_devices_count'] = $deliverableDevicesCount;

        //Number of ready delivered devices
        $readyCompletedDevicesCount = CompletedDevice::
        where('repaired_in_center', true)
            ->where('status',DeviceStatus::Ready->value)
            ->count();
        $response['ready_completed_devices_count'] = $readyCompletedDevicesCount;

        //Number of unready delivered devices
        $unreadyCompletedDevicesCount = CompletedDevice::
        where('repaired_in_center', true)
            ->where('status',DeviceStatus::NotReady->value)
            ->count();
        $response['unready_completed_devices_count'] = $unreadyCompletedDevicesCount;

        //Number of delivered devices in this month
        $inMonthCompletedDevicesCount = CompletedDevice::
        where('repaired_in_center', true)
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
            ->withCount(['completed_devices' => function ($completedDevices) {
                $completedDevices->where('status', DeviceStatus::Ready->value);
            }])
            ->orderBy('completed_devices_count','desc')
            ->limit(5)
            ->get()
            ->select('name', 'completed_devices_count');

        $response['technicians_with_ready_devices_count'] = $techniciansWithReadyDevicesCount;

        //Get top 4 clients and their contributions in this month to 4 sections

        $currentDay = now()->day;
        $response['clients_with_devices_count'] = [
            'first_week' => $this->getWeeklyDeviceCount(0, 7)->map(function ($row) {
                $newRow['name'] = $row->name;
                $newRow['devices_count'] = $row->completed_devices_count + $row->devices_count;
                return $newRow;
            })->sortByDesc('devices_count')->take(4)->values(),
            'second_week' => $currentDay > 14 ? $this->getWeeklyDeviceCount(7, 14)->map(function ($row) {
                $newRow['name'] = $row->name;
                $newRow['devices_count'] = $row->completed_devices_count + $row->devices_count;
                return $newRow;
            })->sortByDesc('devices_count')->take(4)->values() : null,
            'third_week' => $currentDay > 21 ? $this->getWeeklyDeviceCount(14, 21)->map(function ($row) {
                $newRow['name'] = $row->name;
                $newRow['devices_count'] = $row->completed_devices_count + $row->devices_count;
                return $newRow;
            })->sortByDesc('devices_count')->take(4)->values() : null,
            'fourth_week' => $currentDay > 21 ? $this->getWeeklyDeviceCount(21)->map(function ($row) {
                $newRow['name'] = $row->name;
                $newRow['devices_count'] = $row->completed_devices_count + $row->devices_count;
                return $newRow;
            })->sortByDesc('devices_count')->take(4)->values() : null,
        ];


        return $this->apiResponse($response);
    }

    function getWeeklyDeviceCount($startDay, $endDay = null)
    {
        $dateCondition = $endDay ? "DAYOFMONTH(date_receipt) > $startDay AND DAYOFMONTH(date_receipt) <= $endDay"
            : "DAYOFMONTH(date_receipt) > $startDay";

        return Client::select('name')
            ->selectSub(function ($query) use ($dateCondition) {
                $query->from('devices')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('client_id', 'clients.id')
                    ->whereRaw("MONTH(date_receipt) = MONTH(CURRENT_DATE())")
                    ->whereRaw("YEAR(date_receipt) = YEAR(CURRENT_DATE())")
                    ->whereRaw($dateCondition);
            }, 'devices_count')
            ->selectSub(function ($query) use ($dateCondition) {
                $query->from('completed_devices')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('client_id', 'clients.id')
                    ->whereRaw("MONTH(date_receipt) = MONTH(CURRENT_DATE())")
                    ->whereRaw("YEAR(date_receipt) = YEAR(CURRENT_DATE())")
                    ->whereRaw($dateCondition);
            }, 'completed_devices_count')
            ->get();
    }
}
