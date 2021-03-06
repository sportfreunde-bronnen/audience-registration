<?php

namespace App\Providers;

use App\Events\ParticipantRegistered;
use App\Listeners\CreateParticipantQrCode;
use App\Listeners\SendEmailToRegisteredParticipant;
use App\Listeners\StoreParticipantDataIntoCookie;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ParticipantRegistered::class => [
            CreateParticipantQrCode::class,
            SendEmailToRegisteredParticipant::class,
            StoreParticipantDataIntoCookie::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
