<?php

namespace App\Events;

use App\Participant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantRegistered
{
    use Dispatchable, SerializesModels;

    public Participant $participant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }
}
