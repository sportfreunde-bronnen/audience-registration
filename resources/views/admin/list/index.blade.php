@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">
                                Besucherliste
                            </h3>
                            <div class="mt-3">
                                @if ($participants->count() > 0)
                                    <div class="text-xs bg-blue-100 px-2 py-2 border-blue-300 text-blue-800 mb-3">Die Exportfunktion ist in Arbeit!</div>
                                    <ul class="list-unstyled">
                                    @foreach ($participants as $indexKey => $participant)
                                        <li class="align-middle mb-1 pb-1 p-2 odd:bg-gray-200">
                                            <span class="text-sm block">{{ $indexKey + 1 }} - {{ $participant->name }} {{ $participant->last_name }}</span>
                                            <span class="text-sm block">Person/en: {{ $participant->amount }}</span>
                                            <span class="text-xs block">Check-In: {{ $participant->date_check_in->format('d.m.Y H:i') }}</span>
                                            @if ($participant->email)
                                                <span class="text-xs block">E-Mail: {{ $participant->email }}</span>
                                            @endif
                                            @if ($participant->phone)
                                                <span class="text-xs block">Telefon: {{ $participant->phone }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span class="text-sm">Keine eingecheckten Besucher_innen</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
