<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, Event $event)
    {
        $participants = $event->participant()
            ->whereNotNull('date_check_in')
            ->orderBy('date_check_in')
            ->get();

        return view('admin.list.index', [
            'participants' => $participants
        ]);
    }
}
