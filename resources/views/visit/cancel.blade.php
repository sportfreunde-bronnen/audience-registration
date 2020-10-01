@extends('layouts.app')

@section('title', $participant->event->name)

@section('content')
    <div class="mx-1 md:mx-20 xl:mx-64 rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800">
        @if (session('cancel_success'))
            <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 mb-6" role="alert">
                <p class="text-sm">{{ session('cancel_success') }}</p>
            </div>
        @endif
        @if (session('cancel_error'))
            <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 mb-6" role="alert">
                <p class="text-sm">{{ session('cancel_error') }}</p>
            </div>
        @endif
    </div>
@endsection
