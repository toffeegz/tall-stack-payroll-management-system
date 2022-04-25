<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        {{-- <script src="{{ asset('js/init-alpine.js') }}"></script> --}}

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script src="{{ asset('js/init-alpine.js') }}"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />

        <style>
            [x-cloak] { display: none !important; }
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
        <script src="{{ asset('js/charts-lines.js') }}" defer></script>
        <script src="{{ asset('js/charts-pie.js') }}" defer></script>

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-white " :class="{ 'overflow-hidden': isSideMenuOpen }">

            @include('layouts.navigation')
            <div class="w-0 md:w-64">
            </div>
            <main class="flex flex-col flex-1 w-full">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
        @include('layouts.partial.scripts')

    </body>
</html>