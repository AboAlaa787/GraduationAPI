<?php

namespace App\Http\Controllers;

use App\Enums\DeviceStatus;
use App\Models\CompletedDevice;
use App\Models\Device;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
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
            ->where('status',DeviceStatus::Ready)
            ->count();
        $response['ready_devices_count'] = $readyDevicesCount;

        //Number of in progress devices in the center
        $inProgressDevicesCount = Device::
        where('repaired_in_center', true)
            ->where('deliver_to_client', false)
            ->where('status',DeviceStatus::InProgress)
            ->count();
        $response['in_progress_devices_count'] = $inProgressDevicesCount;

        //Number of deliverable devices in the center
        $deliverableDevicesCount = Device::
        where('repaired_in_center', true)
            ->where('deliver_to_client', false)
            ->where('status',DeviceStatus::Ready)
            ->orWhere('status',DeviceStatus::NotReady)
            ->orWhere('status',DeviceStatus::NotAgree)
            ->orWhere('status',DeviceStatus::NotMaintainable)
            ->count();
        $response['deliverable_devices_count'] = $deliverableDevicesCount;

        //Number of ready delivered devices
        $readyCompletedDevicesCount = CompletedDevice::
        where('repaired_in_center', true)
            ->where('status',DeviceStatus::Ready)
            ->count();
        $response['ready_completed_devices_count'] = $readyCompletedDevicesCount;

        //Number of unready delivered devices
        $unreadyCompletedDevicesCount = CompletedDevice::
        where('repaired_in_center', true)
            ->where('status',DeviceStatus::NotReady)
            ->count();
        $response['unready_completed_devices_count'] = $unreadyCompletedDevicesCount;

        //Number of delivered devices in this month
        $inMonthCompletedDevicesCount = CompletedDevice::
        where('repaired_in_center', true)
            ->whereYear('date_delivery',now()->year)
            ->whereMonth('date_delivery',now()->month)
            ->count();
        $response['completed_devices_count_in_this_month'] = $inMonthCompletedDevicesCount;

        return $this->apiResponse($response);
    }
}
