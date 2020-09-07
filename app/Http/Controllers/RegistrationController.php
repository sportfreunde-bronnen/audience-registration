<?php

namespace App\Http\Controllers;

use App\Event;
use App\Events\ParticipantRegistered;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\Cookie;

class RegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $events = Event::all()->where('date_start', '>=', Carbon::now()->subMinutes(200)->format('Y-m-d H:i:s'));

        $user = null;

        if (config('app.remember_cookie') && Cookie::has('participant') && $request->get('complete', 0) == 1) {
            $user = unserialize(Cookie::get('participant'));
        }

        return view('registration.index', [
            'events' => $events,
            'hasCookie' => Cookie::has('participant') && config('app.remember_cookie'),
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $events = Event::all()
            ->where('date_start', '>=', Carbon::now()->subMinutes(200)->format('Y-m-d H:i:s'));

        /** @var Event $event */
        $event = Event::findOrFail($request->post('event'));

        $validationRules = [
            'name' => 'required',
            'last_name' => 'required',
            'event' => 'required',
            'email' => 'required_without:phone',
            'phone' => 'required_without:email',
            'amount' => 'required'
        ];

        if ($event->getRemainingQuota()) {
            $validationRules['amount'] .= '|lte:' . $event->getRemainingQuota();
        }

        $validatedData = $request->validate($validationRules);

        $qrOptions = new QROptions([
            'version' => 2,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'imageTransparent' => false
        ]);

        try {

            $participant = new Participant($validatedData);
            $participant->event_id = $validatedData['event'];
            $participant->secret = strtoupper(uniqid(config('constants.participant.secretPrefix', 'BES')));
            $participant->save();

            $qrCode = new QRCode($qrOptions);
            $qrCode->render($participant->secret, __DIR__ . '/../../../public/img/qr/' . $participant->secret . '.png');

            event(new ParticipantRegistered($participant));

            return redirect()->route('visit.index', ['secret' => $participant->secret]);

        } catch(\Throwable $e) {}

        return view('registration.index', [
            'events' => $events
        ]);
    }
}
