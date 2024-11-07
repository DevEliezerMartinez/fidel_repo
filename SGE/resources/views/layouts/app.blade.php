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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

     <!-- Agregar tus hojas de estilo -->

     <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">  <!-- Ruta completa -->
     <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">  <!-- Ruta completa -->
     <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">  <!-- Ruta completa -->

   
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   
</head>

<body class="">
    <div class="">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>