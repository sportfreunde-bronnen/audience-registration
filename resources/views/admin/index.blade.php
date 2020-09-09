@extends('layouts.app')

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
                            Administration
                        </h3>
                    </div>
                    <div>
                        <div class="bg-gray-50 px-4 py-5">
                            <a href="{{ route('admin.select', ['type' => 'scan.scan']) }}" class="block text-center w-full {{ config('app.colors.buttons') }} hover:{{ config('app.colors.main') }} text-white py-2 px-4 border border-gray-400 rounded shadow">
                                Codes scannen
                            </a>
                            <a href="{{ route('admin.select', ['type' => 'list.index']) }}" class="block text-center w-full {{ config('app.colors.buttons') }} hover:{{ config('app.colors.main') }} text-white my-2 py-2 px-4 border border-gray-400 rounded shadow">
                                Besucherlisten
                            </a>
                            <a href="{{ route('admin.select', ['type' => 'event.edit']) }}" class="block text-center w-full {{ config('app.colors.buttons') }} hover:{{ config('app.colors.main') }} text-white py-2 px-4 border border-gray-400 rounded shadow">
                                Veranstaltungen
                            </a>
                            <a href="{{ route('auth.logout') }}" class="block text-center w-full {{ config('app.colors.buttons') }} hover:{{ config('app.colors.main') }} text-white mt-6 py-2 px-4 border border-gray-400 rounded shadow">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
