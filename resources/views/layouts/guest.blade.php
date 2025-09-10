<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Kolom Kiri: Form Login -->
            <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    {{ $slot }}
                </div>
            </div>

            <!-- Kolom Kanan: Gambar (disembunyikan di layar kecil) -->
            <div class="hidden lg:block relative flex-1">
                <img class="absolute inset-0 h-full w-full object-cover" 
     src="{{ asset('images/background-login.jpg') }}" 
     alt="Suasana belajar di sekolah"
                     onerror="this.onerror=null;this.src='https://placehold.co/1080x1920/6366f1/ffffff?text=KurikulumApp';">
            </div>
        </div>
    </body>
</html>
