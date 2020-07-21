@extends('layouts.app')

@section('content')
    <div class="mx-1 md:mx-20 xl:mx-64 rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800">
        <div class="my-3 text-center">
            <h2 class="font-bold">Scan für {{ $event->name }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 content-center">
            <scanner/>
        </div>
    </div>
@endsection
