<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!-- Scripts -->
    @vite([ 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/eventos_Master.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/detallesEvento.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminUsuarios.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminEventos.css') }}"> <!-- Ruta completa -->
    <link rel="stylesheet" href="{{ asset('assets/css/reservacionEvento.css') }}"> <!-- Ruta completa -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body class="">

    @include('layouts.navigation')

    <main>
        {{ $slot }}
    </main>

</body>

</html>