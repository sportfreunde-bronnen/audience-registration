@extends('layouts.app')

@section('title', $participant->event->name)

@section('content')
    <div class="mx-1 md:mx-20 xl:mx-64 rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 content-center">
            <div>
                <p class="text-xl border-b border-gray-400 mb-6 py-3 text-center lg:text-left">Dein Ticket!</p>
                <p class="text-sm font-bold text-center lg:text-left">Name</p>
                <p class="text-xs text-center lg:text-left">{{ $participant->name }} {{ $participant->last_name }}</p>

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Veranstaltung</p>
                <p class="text-xs text-center lg:text-left">{{ $participant->event->name }} (@datetime($participant->event->date_start))</p>

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Personenzahl</p>
                <p class="text-xs text-center lg:text-left">{{ $participant->amount }}</p>

                <p class="text-sm font-bold mt-3 text-center lg:text-left">Registrierung</p>
                <p class="text-xs text-center lg:text-left">@datetime($participant->created_at)</p>
            </div>
            <div class="flex flex-col justify-center">
                <div class="flex justify-center">
                    <img src="/img/qr/{{ $participant->secret }}.png"/>
                </div>
                <div class="text-center text-xs text-gray-600 mt-3">
                    <b>Achtung:</b> Nur durch Vorzeigen des QR-Codes können wir Deinen Einlass garantieren. Speichere ihn daher auf Deinem Handy ab, mache einen Screenshot von der aktuellen Seite oder setze Dir ein Lesezeichen
                    auf die angezeigte Seite. Im Notfall kannst Du diese Seite auch ausdrucken.
                    @if ($participant->email)<span class="block mt-2">Alternativ erhälst Du den QR-Code ebenfalls an Deine angegebene E-Mail Adresse und kannst dort jederzeit darauf zugreifen..</span>@endif
                    <div class="mt-3 bg-red-200 border-2 border-red-400 text-red-600 px-1 py-1">
                        Bitte lies Dir vor Deinem Besuch unser <b><a href="https://sf-bronnen.de/content/2-gesamtverein/1-allgemeines/6-downloads/2020-08-28_sfb-hygienekonzept.pdf">Hygienekonzept (Download)</a></b> durch
                        und halte Dich vor Ort an die Vorgaben. Herzlichen Dank!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
