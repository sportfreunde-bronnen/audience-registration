<?php

namespace App\Http\Livewire;

use App\Event;
use App\Events\ParticipantRegistered;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Livewire\Component;

class RegisterComponent extends Component
{
    public Collection $events;

    public $selectedEventId;

    public bool $hasCookie = true;

    public ?array $user = null;

    public $name;

    public $last_name;

    public $event;

    public $email;

    public $nickname;

    public $phone;

    public $amount = 1;

    public function mount(Request $request)
    {
        $this->selectedEventId = optional($this->events->first())->id;
        if ($this->user) {
            $this->name = $this->user['name'];
            $this->last_name = $this->user['last_name'];
            $this->phone = $this->user['phone'];
            $this->email = $this->user['email'];
            $this->nickname = $this->user['nickname'];
        }
    }

    public function storeParticipant()
    {
        $validationRules = [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required_without:phone',
            'nickname' => 'nullable|string',
            'phone' => 'required_without:email',
            'amount' => 'required'
        ];

        $selectedEvent = $this->getSelectedEventProperty();

        if ($selectedEvent->getRemainingQuota()) {
            $validationRules['amount'] .= '|lte:' . $selectedEvent->getRemainingQuota();
        }

        if ($selectedEvent->isDartsTournament()) {
            $validationRules['email'] = 'required|email';
            $validationRules['phone'] = 'required';
            $validationRules['nickname'] = 'required|string';
        }

        $validatedData = $this->validate($validationRules);

        $participant = new Participant($validatedData);
        $participant->event_id = $selectedEvent->id;
        $participant->secret = strtoupper(uniqid(config('app.secret_prefix')));
        $participant->save();

        event(new ParticipantRegistered($participant));

        return redirect()->route('visit.index', ['secret' => $participant->secret]);
    }

    /**
     * Get the currently selected event
     *
     * @return Event
     */
    public function getSelectedEventProperty()
    {
        $search = clone $this->events;
        $eventId = $this->selectedEventId;
        return $search->filter(function (Event $event) use ($eventId) {
            return $event->id == $eventId;
        })->first();
    }

    public function render()
    {
        return view('livewire.register-component');
    }
}
