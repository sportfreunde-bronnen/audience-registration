<?php

namespace App\Listeners;

use App\Events\ParticipantRegistered;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class CreateParticipantQrCode
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
        if ($event->participant->event->isDartsTournament()) {
            return;
        }

        $qrOptions = new QROptions([
            'version' => 2,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'imageTransparent' => false,
        ]);

        $participant = $event->participant;

        $qrCode = new QRCode($qrOptions);
        $qrCode->render($participant->secret, __DIR__ . '/../../public/img/qr/' . $participant->secret . '.png');
    }
}
