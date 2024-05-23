<?php

namespace App\Mail;

use App\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DartsTournamentParticipantRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public Participant $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->bcc('darts@sf-bronnen.de')
            ->from('darts@sf-bronnen.de', 'Sportfreunde Bronnen - Darts')
            ->subject(sprintf('%s: Deine Anmeldung', $this->participant->event->name))
            ->view('mail.darts-participant');
    }
}
