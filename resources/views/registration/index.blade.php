@extends('layouts.app')
@section('title', 'Anmeldung')

@section('content')

    @push('scripts')
        <script>
            function showEventQuota() {
                var event = document.getElementById("select-event");
                var selectedEvent = event.options[event.selectedIndex]
                var quotaHints = document.getElementsByClassName('quota-view');
                if (quotaHints.length > 0) {
                    for (var i = 0; i < quotaHints.length; i++) {
                        quotaHints[i].classList.add('hidden');
                    }
                }
                if (parseInt(selectedEvent.dataset.quota) === 0) {
                    document.getElementById('btn-submit').disabled = "disabled";
                    hideForm();
                } else {
                    showForm();
                    document.getElementById('btn-submit').disabled = "";
                }
                document.getElementById('quota-hint-' + selectedEvent.value).classList.remove('hidden');
            }
            window.onload = function() {
                showEventQuota();
            }
            function hideForm() {
                document.getElementById('btn-submit').classList.add('hidden');
                document.getElementById('container-a').classList.add('hidden');
                document.getElementById('container-b').classList.add('hidden');
                document.getElementById('container-c').classList.add('hidden');
            }
            function showForm() {
                document.getElementById('btn-submit').classList.remove('hidden');
                document.getElementById('container-a').classList.remove('hidden');
                document.getElementById('container-b').classList.remove('hidden');
                document.getElementById('container-c').classList.remove('hidden');
            }
        </script>
    @endpush

    <div class="container mx-auto rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800">


        @if ($errors->any())
            <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 mb-6" role="alert">
                <p class="font-bold">Fehler</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
            </div>
        @endif

        @if ($events->count() > 0)
            <div class="bg-blue-100 border border-blue-500 text-blue-800 px-3 py-1 mb-3 text-xs" role="alert">
                Wir behalten uns vor, Deine Daten beim Einlass auf Richtigkeit zu überprüfen. Sei daher bitte so vernünftig und mach richtige Angaben.
                Wir nutzen sie ausschließlich zur Nachverfolgung möglicher Infektionsketten und löschen sie nach vier Wochen automatisch.
            </div>
            @if ($hasCookie && !$user)
                <div class="bg-blue-100 border border-blue-500 text-blue-800 px-3 py-1 mb-3 text-xs" role="alert">
                    Du warst schon mal bei uns. <a href="{{ route('registration', ['complete' => 1]) }}"><b>Klicke hier</b></a>, um Deine Daten vom letzten Besuch zu verwenden.
                </div>
            @endif
            <form class="w-full" method="POST" action="{{ route('registration.store') }}">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="select-event">
                            Veranstaltung
                        </label>
                        <div class="relative">
                            <select onchange="showEventQuota();" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-event" name="event">
                                @foreach ($events as $event)
                                    <option data-quota="{{ $event->getRemainingQuota() }}" value="{{ $event->id }}">(@datetime($event->date_start) - {{ $event->name }})</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        <div>
                            @foreach ($events as $event)
                                @if ($event->quota)
                                    @if ($event->getRemainingQuota() === 0)
                                        <span id="quota-hint-{{ $event->id }}" class="pl-0 lg:pl-5 hidden block mt-1 text-sm text-red-500 text-center lg:text-left quota-view">Ausverkauft!</span>
                                    @else
                                        <span id="quota-hint-{{ $event->id }}" class="pl-0 lg:pl-5 hidden block mt-1 text-sm text-gray-500 text-center lg:text-left quota-view">Restplätze: {{ $event->getRemainingQuota() }}</span>
                                    @endif
                                @else
                                    <span id="quota-hint-{{ $event->id }}" class="pl-0 lg:pl-5 hidden block mt-1 text-sm text-gray-500 text-center lg:text-left quota-view">Restplätze: unbegrenzt</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="container-a" class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-amount">
                            Personenzahl
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('amount') border-red-500 @enderror" id="txt-amount" value="{{ old('amount', 1) }}" name="amount" type="number" min="1" value="1">
                        <span class="text-xs text-gray-500">Gilt nur, wenn die Personen im selben Haushalt leben!</span>
                    </div>
                </div>
                <div id="container-b" class="flex flex-wrap -mx-3 md:mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-name">
                            Vorname
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="txt-name" name="name" type="text" placeholder="Max" required value="{{ old('name', ($user ? $user['name'] : null)) }}">
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-last-name">
                            Nachname
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="txt-last-name" name="last_name" type="text" placeholder="Mustermann" required value="{{ old('last_name', ($user ? $user['last_name'] : null)) }}">
                    </div>
                </div>
                <div id="container-c" class="flex flex-wrap -mx-3 md:mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-phone">
                            Telefonnummer
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('email') border-red-500 @enderror" id="txt-phone" name="phone" type="tel" placeholder="Telefonnummer" value="{{ old('phone', ($user ? $user['phone'] : null)) }}">
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-email">
                            E-Mail Adresse
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('email') border-red-500 @enderror" id="txt-email" name="email" type="text" placeholder="E-Mail" value="{{{ old('email', ($user ? $user['email'] : null)) }}}">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2 px-3">
                    <button id="btn-submit" type="submit" class="bg-gray-800 w-full hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Anmeldung bestätigen
                    </button>
                </div>
            </form>
        @else
            <div class="flex items-center bg-gray-800 text-white text-sm px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>Aktuell sind keine geplanten Veranstaltungen bekannt.</p>
            </div>
        @endif

    </div>
@endsection
