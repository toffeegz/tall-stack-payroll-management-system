<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @include('layouts.partial.styles')
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