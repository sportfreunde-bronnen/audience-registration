<?php

namespace App\Http\Controllers;

use App\Event;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;

class VisitController extends Controller
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
        $participant = Participant::where('secret', $request->route('secret'))->firstOrFail();

        return view('visit.index', [
            'participant' => $participant
        ]);
    }

    public function cancel(Request $request)
    {
        $participant = Participant::where('secret', $request->route('secret'))->firstOrFail();

        try {

            if (config('app.cancel_registration') === false) {
                abort(404);
            }

            if (!is_null($participant->date_check_in)) {
                $request->session()->flash('cancel_error', 'Du wurdest bereits eingecheckt und kannst Deine Anmeldung daher nicht mehr stornieren!');
            } else {
                $participant->delete();
                $request->session()->flash('cancel_success', 'Vielen Dank. Deine Anmeldung wurde erfolgreich storniert!');
            }
        } catch(\Throwable $e) {
            $request->session()->flash('cancel_error', 'Leider ist ein Fehler aufgetreten. Versuche es bitte erneut!');
        }

        return view('visit.cancel', [
            'participant' => $participant
        ]);
    }
}
