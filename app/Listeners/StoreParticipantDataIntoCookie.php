<?php

namespace App\Listeners;

use App\Events\ParticipantRegistered;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class StoreParticipantDataIntoCookie
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ParticipantRegistered $event)
    {
        $cookieData = [
            'name' => $event->participant->name,
            'last_name' => $event->participant->last_name,
            'email' => $event->participant->email,
            'phone' => $event->participant->phone
        ];
        Cookie::queue('participant', serialize($cookieData), (60 * 24 * 60));
    }
}
