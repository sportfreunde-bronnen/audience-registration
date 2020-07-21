<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class ScanController extends Controller
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
    public function entry(Request $request, Event $event)
    {
        return view('admin.scan.entry', [
            'event' => $event
        ]);
    }
}
