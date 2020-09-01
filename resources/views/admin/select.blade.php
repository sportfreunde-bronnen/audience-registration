@extends('layouts.app')

@section('title', 'Scan - Veranstaltung wählen')

@section('content')
<div class="bg-gray-50 px-4 py-5">
    @foreach ($events as $event)
        <a href="{{ route($route, ['event' => $event]) }}" class="w-full block text-center bg-gray-700 hover:bg-gray-800 text-white py-2 px-4 border border-gray-400 rounded shadow">{{ $event->name }}</a>
    @endforeach
</div>
@endsection
