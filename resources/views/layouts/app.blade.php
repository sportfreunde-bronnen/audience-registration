<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Start') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div>
            <nav class="bg-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-white">
                                <span class="text-lg"><a href="/">{{ config('app.club_name') }}</a></span>
                                <span class="text-xs block">Besucheranmeldung</span>
                            </div>
                            @auth
                            <div class="block">
                                <div class="ml-10 flex items-baseline">
                                    <a href="{{ route('admin') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-gray-900 focus:outline-none focus:text-white">Administration</a>
                                </div>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Replace with your content -->
                    <div class="px-4 py-6 sm:px-0">
                        <div class="">
                            @yield('content')
                        </div>
                    </div>
                    <!-- /End replace -->
                </div>
            </main>
        </div>
    </div>
    <footer>
        <div class="w-full text-center text-xs text-gray-500 mb-8">
            <a href="https://sf-bronnen.de/home/impressum">Impressum</a> | <a href="https://sf-bronnen.de/home/datenschutz">Datenschutz</a> @guest| <a href="{{ route('login') }}">Login</a>@endguest @auth| <a href="{{ route('admin') }}">Administration</a>@endauth
        </div>
    </footer>
    <script src="/js/html5-qrcode.min.js"></script>
    <script src="/js/no-sleep.min.js"></script>
</body>
</html>
