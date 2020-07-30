@extends('layouts.app')

@section('content')
    <div class="mx-1 md:mx-20 xl:mx-64 rounded bg-gray-100 text-sm shadow-xs px-5 py-1 text-gray-800">
        <div class="my-3 text-center">
            <h2 class="font-bold">{{ $event->name }}</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 content-center">
            <scanner init-count-checked-in="{{ $countCheckedIn }}" init-count-not-checked-in="{{ $countNotCheckedIn }}"/>
        </div>
    </div>
@endsection
