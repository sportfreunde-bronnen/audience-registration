<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function create(Request $request)
    {
        return view('admin.event.edit', [
            'event' => new Event()
        ]);
    }

    public function store(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'date_start' => 'required|date',
            'date_start_time' => 'required',
            'date_end' => 'date',
            'date_end_time' => 'required_with:date_end'
        ]);

        $event->name = $validatedData['name'];
        $event->date_start = sprintf('%s %s', $validatedData['date_start'], $validatedData['date_start_time']);

        if ($validatedData['date_end']) {
            $event->date_end = sprintf('%s %s', $validatedData['date_end'], $validatedData['date_end_time']);
        }

        $event->save();

        return Redirect::route('event.edit', ['event' => $event]);
    }

    /**
     * @param Request $request
     * @param Event   $event
     */
    public function edit(Request $request, Event $event)
    {
        return view('admin.event.edit', [
            'event' => $event
        ]);
    }
}