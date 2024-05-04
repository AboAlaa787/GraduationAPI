<?php

namespace App\Providers;

use App\Events\AddDevice;
use App\Events\ClientApproval;
use App\Events\DeleteDevice;
use App\Events\NotificationEvents\DeviceStateNotifications;
use App\Listeners\AddCompletedDevice;
use App\Listeners\IncreaseCountDevice;
use App\Listeners\ModificationsAfterClientApproval;
use App\Listeners\NotificationsListeners\SendDeviceNotifications;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AddDevice::class => [
            IncreaseCountDevice::class,
        ],
        DeleteDevice::class => [
            AddCompletedDevice::class,
        ],
        DeviceStateNotifications::class => [
            SendDeviceNotifications::class,
        ],
        ClientApproval::class => [
            ModificationsAfterClientApproval::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
