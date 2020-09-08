<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
    public function index(Request $request)
    {
        return view('admin.index', [

        ]);
    }

    public function select(Request $request)
    {
        $routeName = $request->get('type', 'scan');

        /** @var Builder $events */

        if ($routeName === 'scan.scan') {
            $events = Event::scannable()->orderBy('date_start', 'DESC')->get();
        } else {
            $events = Event::query()->orderBy('date_start', 'DESC')->get();
        }

        return view('admin.select', [
            'route' => $routeName,
            'events' => $events
        ]);
    }
}
