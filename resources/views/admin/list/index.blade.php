@extends('layouts.app')

@section('content')
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">
                                Besucherliste
                            </h3>
                            @foreach ($participants as $participant)
                                {{ $participant->name }} {{ $participant->last_name }} ({{ $participant->date_check_in }})<br/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
