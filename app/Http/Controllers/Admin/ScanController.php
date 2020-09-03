<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Exceptions\ParticipantHasAlreadyCheckedInException;
use App\Exceptions\ParticipantHasAlreadyCheckedOutException;
use App\Exceptions\ParticipantHasNoCheckinException;
use App\Http\Controllers\Controller;
use App\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScanController extends Controller
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
        // Calculate numbers
        $countCheckedIn = Participant::where('event_id', $event->id)->whereNotNull('date_check_in')->sum('amount');
        $countNotCheckedIn = Participant::where('event_id', $event->id)->whereNull('date_check_in')->sum('amount');

        return view('admin.scan.entry', [
            'event' => $event,
            'countCheckedIn' => $countCheckedIn,
            'countNotCheckedIn' => $countNotCheckedIn
        ]);
    }

    public function code(Request $request, Event $event)
    {
        $secret = $request->post('secret');
        $participant = Participant::where('secret', $secret)->where('event_id', $event->id)->firstOrFail();

        // Get the mode (1 = Entry, 2 = Exit)
        $mode = (int)$request->post('mode', 1);

        // Calculate numbers
        $countCheckedIn = Participant::where('event_id', $event->id)->whereNotNull('date_check_in')->sum('amount');
        $countNotCheckedIn = Participant::where('event_id', $event->id)->whereNull('date_check_in')->sum('amount');

        try {

            switch ($mode) {
                case 1:
                    if ($participant->date_check_in instanceof Carbon) {
                        throw new ParticipantHasAlreadyCheckedInException('Dieser Besucher wurde bereits eingecheckt.');
                    }
                    $participant->date_check_in = Carbon::now();
                    $participant->save();
                    $countCheckedIn += $participant->amount;
                    $countNotCheckedIn -= $participant->amount;
                    break;
                case 2:
                    if (!$participant->date_check_in instanceof Carbon) {
                        throw new ParticipantHasNoCheckinException('Dieser Besucher wurde noch nicht eingecheckt.');
                    }
                    if ($participant->date_check_out instanceof Carbon) {
                        throw new ParticipantHasAlreadyCheckedOutException('Dieser Besucher wurde bereits ausgecheckt.');
                    }
                    $participant->date_check_out = Carbon::now();
                    $participant->save();
                    break;
            }

            return new JsonResponse([
                'status'    => 0,
                'message' => sprintf(
                    '%s %s %s (%s Person/en).',
                    $participant->name,
                    $participant->last_name,
                    ($mode === 1 ? 'eingecheckt' : 'ausgecheckt'),
                    $participant->amount
                ),
                'countCheckedIn' => $countCheckedIn,
                'countNotCheckedIn' => $countNotCheckedIn
            ], 200);

        } catch(ParticipantHasAlreadyCheckedInException | ParticipantHasAlreadyCheckedOutException | ParticipantHasNoCheckinException $e) {

            return new JsonResponse([
                'status' => 1,
                'message' => $e->getMessage(),
                'countCheckedIn' => $countCheckedIn,
                'countNotCheckedIn' => $countNotCheckedIn
            ], 200);

        } catch (\Throwable $e) {
            return new JsonResponse([
                'status' => 1,
                'message' => $e->getMessage(),
                'countCheckedIn' => $countCheckedIn,
                'countNotCheckedIn' => $countNotCheckedIn
            ], 200);
        }


    }
}
