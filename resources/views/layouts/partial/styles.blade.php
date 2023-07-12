<!-- Fonts -->
<link rel="stylesheet" href="{{ asset('fonts/Nunito/fonts.css') }}">

{{-- Font Awesome --}}
<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<script src="{{ asset('js/init-alpine.js') }}"></script>

<style>
    [x-cloak] { display: none !important; }
</style>

<script src="{{ asset('js/charts-lines.js') }}" defer></script>
<script src="{{ asset('js/charts-pie.js') }}" defer></script>
@yield('page-style')