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

                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Veranstaltung wählen
                            </h3>
                        </div>
                        <div>
                            <div class="bg-gray-50 px-4 py-5">
                                <a href="{{ route('event.create') }}" class="w-full mb-5 block text-center bg-gray-800 hover:bg-gray-900 text-white py-2 px-4 border border-gray-400 rounded shadow">Neue Veranstaltung erstellen</a>
                                @foreach ($events as $event)
                                    <a href="{{ route($route, ['event' => $event]) }}" class="w-full block text-left text-sm md:text-center bg-gray-700 hover:bg-gray-800 text-white py-2 px-4 border border-gray-400 rounded shadow">{{ $event->date_start->format('d.m.Y H:i') }} - {{ $event->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
