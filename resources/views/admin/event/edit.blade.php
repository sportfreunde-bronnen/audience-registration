@extends('layouts.app')

@section('title', 'Veranstaltung verwalten')

@section('content')
    <div class="container mx-auto">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 mb-6" role="alert">
                            <p class="font-bold">Fehler</p>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
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
                                    @if ($event->id)
                                        {{ $event->name }}
                                    @else
                                        Neue Veranstaltung
                                    @endif
                                </h3>
                            </div>
                        <div class="px-4 sm:px-6 py-2">
                            <form class="w-full" method="POST" action="@if ($event->id) {{ route('event.store', ['event' => $event->id]) }} @else {{ route('event.store.new') }} @endif">
                                @csrf
                                <div class="flex flex-wrap -mx-3 mb-2">
                                    <div class="w-full px-3 mb-6">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-amount">
                                            Name der Veranstaltung
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="txt-name" name="name" type="text" value="{{ old('name', $event->name) }}">
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-3 md:mb-6">
                                    <div class="w-1/2 px-3 mb-6 md:mb-0border-red-800">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 @error('date_start') text-red-500 @enderror" for="txt-name">
                                            Datum (Start) *
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white @error('date_start') border-red-500 @enderror" id="txt-date-start" name="date_start" type="date" value="{{ old('date_start', ($event->date_start ? $event->date_start->format('Y-m-d') : '')) }}">
                                    </div>
                                    <div class="w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 @error('date_start_time') text-red-500 @enderror" for="txt-last-name">
                                            Uhrzeit (Start) *
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('date_start_time') border-red-500 @enderror" id="txt-date-start-time" name="date_start_time" type="time" value="{{ old('date_start_time', ($event->date_start ? $event->date_start->format('H:i') : '')) }}">
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-3 md:mb-6">
                                    <div class="w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-name">
                                            Datum (Ende)
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="txt-date-end" name="date_end" type="date" value="{{ old('date_end', ($event->date_end ? $event->date_end->format('Y-m-d') : '')) }}">
                                    </div>
                                    <div class="w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-last-name">
                                            Uhrzeit (Ende)
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="txt-date-end-time" name="date_end_time" type="time" value="{{ old('date_end_time', ($event->date_end ? $event->date_end->format('H:i') : '')) }}">
                                    </div>
                                    <div class="w-full px-3 mb-6 md:mb-0">
                                        <span class="text-xs text-gray-500">Ein Endzeitpunkt ist nicht zwingend erforderlich.</span>
                                    </div>
                                </div>
                                <div class="md:flex md:justify-between">
                                    <button type="submit" class="w-full md:w-1/3 text-center py-2 px-4 mb-2 md:mb-0 bg-gray-800 hover:bg-gray-700 text-white rounded">
                                        Veranstaltung speichern
                                    </button>
                                    @if ($event->id)
                                        <a class="block md:w-1/3 text-center py-2 px-4 bg-red-600 hover:bg-red-400 text-white rounded" href="{{ route('event.delete', ['event' => $event]) }}" onclick="return confirm('Wirklich löschen? Beim Speichern alle angemeldeten/eingecheckten Besucher ebenfalls gelöscht!');">Veranstaltung löschen</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
