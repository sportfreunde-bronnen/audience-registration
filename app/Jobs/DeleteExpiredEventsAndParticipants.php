<?php

namespace App\Jobs;

use App\Event;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DeleteExpiredEventsAndParticipants
{
    use Dispatchable;

    /**
     * Find expired events and delete them and the participants
     *
     * @return void
     */
    public function handle()
    {
        /** @var Collection $expiredEvents */
        $expiredEvents = Event::expired()->get();
        if ($expiredEvents->count() > 0) {
            $expiredEvents->each(function (Event $event) {
                try {
                    Log::info('DELETE PARTICIPANTS (Id: ' . $event->id . ')');
                    $event->participant()->forceDelete();
                    Log::info('DELETE EVENT (Id: ' . $event->id . ')');
                    $event->delete();
                } catch(\Throwable $e) {
                    Log::error("ERROR DURING EVENT DELETION!");
                    Log::error($e->getMessage());
                }
            });
        }
    }
}
