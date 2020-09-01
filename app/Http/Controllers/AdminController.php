<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

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

        return view('admin.select', [
            'route' => $routeName,
            'events' => Event::all()
        ]);
    }
}
