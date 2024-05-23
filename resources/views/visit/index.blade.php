@extends('layouts.app')

@section('title', $participant->event->name)

@section('content')
    <div class="mx-1 md:mx-20 xl:mx-64 rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 content-center">
            <div>
                <p class="text-xl mb-6 py-3 text-center lg:text-left">Deine Anmeldung:</p>

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Veranstaltung</p>
                <p class="text-xs text-center lg:text-left">{{ $participant->event->name }} (@datetime($participant->event->date_start))</p>

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Name</p>
                <p class="text-xs text-center lg:text-left">{{ $participant->name }} {{ $participant->last_name }}</p>

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Personenzahl</p>
                <p class="text-xs text-center lg:text-left">{{ $participant->amount }}</p>

                @if ($participant->email)
                    <p class="text-sm font-bold mt-3 text-center lg:text-left">E-Mail</p>
                    <p class="text-xs text-center lg:text-left">{{ $participant->email }}</p>
                @endif

                @if ($participant->phone)
                    <p class="text-sm font-bold mt-3 text-center lg:text-left">Telefon</p>
                    <p class="text-xs text-center lg:text-left">{{ $participant->phone }}</p>
                @endif

                @if ($participant->nickname)
                    <p class="text-sm font-bold mt-3 text-center lg:text-left">Nickname</p>
                    <p class="text-xs text-center lg:text-left">{{ $participant->nickname }}</p>
                @endif

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Registrierung</p>
                <p class="text-xs text-center lg:text-left">@datetime($participant->created_at)</p>
            </div>
            <div class="flex flex-col justify-center">
                @if (!$participant->event->isDartsTournament())
                    <div class="flex justify-center">
                        <img src="/img/qr/{{ $participant->secret }}.png"/>
                    </div>
                    <div class="text-center text-xs text-gray-600 mt-3">
                        <b>Achtung:</b> Der QR-Code muss je nach Veranstaltung am Einlass vorgezeigt werden. Speichere ihn daher auf Deinem Handy ab, mache einen Screenshot von der aktuellen Seite oder setze Dir ein Lesezeichen
                        auf die angezeigte Seite. Im Notfall kannst Du diese Seite auch ausdrucken.
                        @if ($participant->email)<span class="block mt-2">Alternativ erhälst Du den QR-Code ebenfalls an Deine angegebene E-Mail Adresse und kannst dort jederzeit darauf zugreifen..</span>@endif
                        <!--
                        <div class="mt-3 bg-red-200 border-2 border-red-400 text-red-600 px-1 py-1">
                            Bitte lies Dir vor Deinem Besuch unser <b><a href="{{ config('app.hygiene_concept') }}">Hygienekonzept (Download)</a></b> durch
                            und halte Dich vor Ort an die Vorgaben. Herzlichen Dank!
                        </div>
                        -->
                    </div>
                @else
                    <div class="flex justify-center text-center">
                        Vielen Dank für Deine Anmeldung. Du erhälst zusätzlich eine Bestätigung an Deine angegebene E-Mail Adresse.
                        <br/><br/>
                        GAME ON!
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
