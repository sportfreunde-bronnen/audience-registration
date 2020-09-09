<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        if (config('app.remember_cookie') && Cookie::has('participant') && $request->get('complete', 0) == 1) {
            $user = unserialize(Cookie::get('participant'));
        } else {
            $user = null;
        }

        return view('registration.index', [
            'events' => $events,
            'user' => $user,
            'hasCookie' => Cookie::has('participant') && config('app.remember_cookie')
        ]);
    }
}
