<?php

namespace App\Listeners;

use App\Events\ParticipantRegistered;
use Illuminate\Support\Facades\Mail;

class SendEmailToRegisteredParticipant
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
        if ($event->participant->email) {
            Mail::to($event->participant)->send(new \App\Mail\ParticipantRegistered($event->participant));
        }
    }
}
