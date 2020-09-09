<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
            'event' => $event,
            'participants' => $participants
        ]);
    }

    public function export(Request $request, Event $event)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . sprintf('%s_%s_Besucherliste.csv', date('Y-m-d_His'), config('app.secret_prefix')),
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $participants = $event->participant()->whereNotNull('date_check_in')->orderBy('date_check_in', 'ASC')->get();
        $columns = ['Nachname', 'Name', 'E-Mail', 'Telefon', 'Anzahl Personen', 'Check-In-Datum', 'Check-Out-Datum'];

        $callback = function() use ($participants, $columns, $event)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Veranstaltung: ' . $event->name, optional($event->date_start)->format('d.m.Y H:i'), optional($event->date_end)->format('d.m.Y H:i')]);
            fputcsv($file, $columns);
            foreach($participants as $participant) {
                fputcsv($file, [
                    $participant->last_name,
                    $participant->name,
                    $participant->email,
                    $participant->phone,
                    $participant->amount,
                    optional($participant->date_check_in)->format('d.m.Y H:i:s'),
                    optional($participant->date_check_out)->format('d.m.Y H:i:s')
                ]);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
