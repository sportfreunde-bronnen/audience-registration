<?php

namespace App\Http\Controllers;

use App\Event;
use App\Exceptions\ParticipantHasAlreadyCheckedInException;
use App\Exceptions\ParticipantHasAlreadyCheckedOutException;
use App\Exceptions\ParticipantHasNoCheckinException;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, Event $event)
    {
        return view('admin.scan.entry', [
            'event' => $event
        ]);
    }

    public function code(Request $request, Event $event)
    {
        $secret = $request->post('secret');
        $participant = Participant::where('secret', $secret)->firstOrFail();

        // Get the mode (1 = Entry, 2 = Exit)
        $mode = (int)$request->post('mode', 1);

        try {

            switch ($mode) {
                case 1:
                    if ($participant->date_check_in instanceof Carbon) {
                        throw new ParticipantHasAlreadyCheckedInException('Dieser Besucher wurde bereits eingecheckt.');
                    }
                    $participant->date_check_in = Carbon::now();
                    break;
                case 2:
                    if (!$participant->date_check_in instanceof Carbon) {
                        throw new ParticipantHasNoCheckinException('Dieser Besucher wurde noch nicht eingecheckt.');
                    }
                    if ($participant->date_check_out instanceof Carbon) {
                        throw new ParticipantHasAlreadyCheckedOutException('Dieser Besucher wurde bereits ausgecheckt.');
                    }
                    $participant->date_check_out = Carbon::now();
                    break;
            }

            $participant->save();

            return new JsonResponse([
                'status'    => 0,
                'message' => sprintf('%s %s %s.', $participant->name,
                    $participant->last_name,
                    ($mode === 1 ? 'eingecheckt' : 'ausgecheckt'))
            ], 200);

        } catch(ParticipantHasAlreadyCheckedInException | ParticipantHasAlreadyCheckedOutException | ParticipantHasNoCheckinException $e) {

            return new JsonResponse([
                'status' => 1,
                'message' => $e->getMessage()
            ], 200);

        } catch (\Throwable $e) {
            return new JsonResponse([
                'status' => 1,
                'message' => $e->getMessage(),
            ], 200);
        }


    }
}
