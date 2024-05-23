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
                                    <div class="flex justify-end align-middle text-xs px-2 py-2 border-blue-300 mb-3">
                                        <a class="{{ config('app.colors.main') }} text-white rounded px-2 py-2 w-3/6  sm:w-2/6 md:w-2/6 lg:w-1/6" href="{{ route('list.export', ['event' => $event->id]) }}">
                                            <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg> Export (CSV)
                                        </a>
                                    </div>
                                    <ul class="list-unstyled">
                                    @foreach ($participants as $indexKey => $participant)
                                        <li class="align-middle mb-1 pb-1 p-2 odd:bg-gray-200">
                                            <span class="text-sm block">{{ $indexKey + 1 }} - {{ $participant->name }} {{ $participant->last_name }}</span>
                                            <span class="text-xs block">Person/en: {{ $participant->amount }}</span>
                                            @if ($participant->date_check_in)
                                                <span class="text-xs block">Check-In: {{ $participant->date_check_in->format('d.m.Y H:i') }}</span>
                                            @endif
                                            @if ($participant->date_check_out)
                                                <span class="text-xs block">Check-Out: {{ $participant->date_check_out->format('d.m.Y H:i') }}</span>
                                            @endif
                                            @if ($participant->email)
                                                <span class="text-xs block">E-Mail: {{ $participant->email }}</span>
                                            @endif
                                            @if ($participant->phone)
                                                <span class="text-xs block">Telefon: {{ $participant->phone }}</span>
                                            @endif
                                            @if ($participant->nickname)
                                                <span class="text-xs block">Nickname: {{ $participant->nickname }}</span>
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
