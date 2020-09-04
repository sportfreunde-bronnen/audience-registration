@extends('layouts.app')

@section('title', 'Scan ' . $event->name)

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

                    <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5">
                        <div class="border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3 text-center md:text-left">
                                {{ $event->name }}
                            </h3>
                        </div>
                        <div>
                            <div class="grid grid-cols-1 gap-4 content-center">
                                <scanner init-count-checked-in="{{ $countCheckedIn }}" init-count-not-checked-in="{{ $countNotCheckedIn }}" init-count-checked-out="{{ $countCheckedOut }}" init-count-not-checked-out="{{ $countNotCheckedOut }}"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
