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
}
