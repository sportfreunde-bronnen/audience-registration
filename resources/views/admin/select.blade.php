@extends('layouts.app')

@section('title', 'Scan - Veranstaltung wählen')

@section('content')
    <div class="container mx-auto">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('event_success'))
                        <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 mb-6" role="alert">
                            <p class="text-sm">{{ session('event_success') }}</p>
                        </div>
                    @endif

                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Veranstaltung wählen
                            </h3>
                        </div>
                        <div>
                            <div class="bg-gray-50 px-4 py-5">
                                <a href="{{ route('event.create') }}" class="w-full mb-5 block text-center {{ config('app.colors.main') }} hover:{{ config('app.colors.main_darker') }} text-white py-2 px-4 border border-gray-400 rounded shadow">Neue Veranstaltung erstellen</a>
                                @foreach ($events as $event)
                                    <a href="{{ route($route, ['event' => $event]) }}" class="w-full text-sm block text-center {{ config('app.colors.buttons') }} hover:{{ config('app.colors.main') }} text-white py-2 px-4 border border-gray-400 rounded shadow">
                                        <span class="block text-sm">{{ $event->name }}</span>
                                        <span class="inline text-xs">{{ $event->date_start->format('d.m.Y H:i') }}</span>
                                        @if ($event->date_end)
                                            <span class="inline text-xs">
                                                - {{ $event->date_end->format($event->date_start->diff($event->date_end)->days === 0 ? 'H:i' : 'd.m.Y H:i') }}
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
