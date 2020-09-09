@extends('layouts.app')

@section('content')
    <div class="mx-1 rounded bg-gray-100 text-sm shadow-xs px-5 py-3 text-gray-800 max-w-lg md:mx-auto">
        @error('email')
        <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 mb-6" role="alert">
            <p class="font-bold">Fehler</p>
            <p class="text-sm">{{ $message }}</p>
        </div>
        @enderror
        <form method="POST" action="{{ route('login') }}" class="w-full">
            @csrf
            <div class="flex flex-wrap -mx-3">
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-email">
                        Benutzername
                    </label>
                    <input id="txt-email" name="email" required class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" type="text" value="{{ old('email') }}">
                </div>
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="txt-password">
                        Passwort
                    </label>
                    <input id="txt-password" name="password" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="password">
                </div>
            </div>
            <div class="flex mb-6">
                <label class="block text-gray-500 font-bold">
                    <input class="mr-2 leading-tight" type="checkbox" id="radio-remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="text-xs">
                        Eingeloggt bleiben
                    </span>
                </label>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2 px-3">
                <button type="submit" class="{{ config('app.colors.main') }} hover:{{ config('app.colors.buttons') }} text-white font-bold py-2 px-4 rounded">
                    Einloggen
                </button>
            </div>
        </form>
    </div>
    <!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">111{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->
@endsection
