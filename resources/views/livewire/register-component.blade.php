<div>
    <div class="container mx-auto rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800">

        <script>
            function toTop() {
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
            }
        </script>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 mb-6" role="alert">
                <p class="font-bold">Fehler</p>
                <ul class="list-disc">
                @foreach ($errors->all() as $error)
                    <li class="text-sm ml-3">{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        @if ($events->count() > 0)
            <div class="bg-blue-100 border border-blue-500 text-blue-800 px-3 py-1 mb-3 text-xs" role="alert">
                {{ config('app.text_registration') }}
            </div>
            @if ($hasCookie && !$user)
                <div class="bg-blue-100 border border-blue-500 text-blue-800 px-3 py-1 mb-3 text-xs" role="alert">
                    Du warst schon mal bei uns. <a href="{{ route('registration', ['complete' => 1]) }}"><b>Klicke hier</b></a>, um Deine Daten vom letzten Besuch zu verwenden.
                </div>
            @endif
            <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full px-3 mb-6 @if ($this->selectedEvent->showRemainingQuota())md:w-9/12 @endif">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="select-event">
                        Veranstaltung
                    </label>
                    <div class="relative">
                        <select wire:model="selectedEventId" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-event" name="event">
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" @if (old('event', null) == $event->id) selected @endif>(@datetime($event->date_start) - {{ $event->name }})</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                @if ($this->selectedEvent->showRemainingQuota())
                    <div class="w-full md:w-3/12 px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="select-event">
                            Restplätze
                        </label>
                        <div class="block text-sm text-gray-500 mt-2 bg-gray-200 rounded py-3 px-4">
                            @if ($this->selectedEvent->getRemainingQuota() === 0)
                                <span class="text-red-400">Ausverkauft!</span>
                            @else
                                {{ $this->selectedEvent->getRemainingQuota() }}
                            @endif
                        </div>
                    </div>
                @endif
                @if ($this->selectedEvent->getRemainingQuota() || is_null($this->selectedEvent->getRemainingQuota()))
                    <div id="container-a" class="w-full px-3 mb-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-amount">
                            Personenzahl
                        </label>
                        <input wire:model.defer="amount" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('amount') border-red-500 @enderror" id="txt-amount" value="{{ old('amount', 1) }}" name="amount" type="number" min="1">
                        <span class="text-xs text-gray-500">Gilt nur, wenn die Personen im selben Haushalt leben!</span>
                    </div>
                @endif
            </div>
            @if ($this->selectedEvent->getRemainingQuota() || is_null($this->selectedEvent->getRemainingQuota()))
                <div id="container-b" class="flex flex-wrap -mx-3 md:mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-name">
                            Vorname
                        </label>
                        <input wire:model.defer="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white @error('name') border-red-500 @enderror" id="txt-name" name="name" type="text" placeholder="Max" value="{{ old('name', ($user ? $user['name'] : null)) }}">
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-last-name">
                            Nachname
                        </label>
                        <input wire:model.defer="last_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('last_name') border-red-500 @enderror" id="txt-last-name" name="last_name" type="text" placeholder="Mustermann" value="{{ old('last_name', ($user ? $user['last_name'] : null)) }}">
                    </div>
                </div>
                <div id="container-c" class="flex flex-wrap -mx-3 md:mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-phone">
                            Telefonnummer
                        </label>
                        <input wire:model.defer="phone" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('email') border-red-500 @enderror" id="txt-phone" name="phone" type="tel" placeholder="Telefonnummer" value="{{ old('phone', ($user ? $user['phone'] : null)) }}">
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-email">
                            E-Mail Adresse
                        </label>
                        <input wire:model.defer="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('email') border-red-500 @enderror" id="txt-email" name="email" type="text" placeholder="E-Mail" value="{{{ old('email', ($user ? $user['email'] : null)) }}}">
                        <span class="text-xs text-gray-500">Freiwillig, zum Versand des QR-Codes</span>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2 px-3">
                    <button wire:click="storeParticipant" onclick="toTop();" class="{{ config('app.colors.main') }} w-full hover:{{ config('app.colors.buttons') }} text-white font-bold py-2 px-4 rounded">
                        Anmeldung bestätigen
                    </button>
                </div>
            @endif
        @else
            <div class="flex items-center {{ config('app.colors.main') }} text-white text-sm px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>Aktuell sind keine geplanten Veranstaltungen bekannt.</p>
            </div>
        @endif

    </div>
</div>
