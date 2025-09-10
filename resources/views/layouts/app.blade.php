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

<body class="font-sans antialiased">
    <div id="sidebar-wrapper" class="min-h-screen bg-gray-100 flex" x-data="{ open: true }">
        <!-- Sidebar -->
        <aside :class="{ 'w-64': open, 'w-20': !open }"
            class="bg-gray-800 text-white flex-shrink-0 transition-all duration-300">
            <!-- Logo/Brand -->
            <div class="h-16 flex items-center justify-center bg-gray-900">
                <a href="{{ route('dashboard') }}">
                    <h1 class="text-2xl font-bold" x-show="open">KurikulumApp</h1>
                    <h1 class="text-2xl font-bold" x-show="!open">KA</h1>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-5">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4" x-show="open">Dashboard</span>
                </a>

                <!-- Menu Dinamis berdasarkan Peran -->
                @include('layouts.partials.sidebar-menu')

            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow flex justify-between items-center p-4">
                <button @click="open = !open" class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center space-x-2 relative focus:outline-none">
                        <h2 class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</h2>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10" x-cloak>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-4 md:p-6">
                @if (isset($header))
                    <header class="mb-6">
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                            {{ $header }}
                        </h1>
                    </header>
                @endif

                {{ $slot }}
            </main>

            <!-- ==================== FOOTER BARU (TANPA GARIS) ==================== -->
            <footer class="mt-20">
                <div
                    class="container mx-auto px-6 py-8 text-center text-gray-500 flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-2">
                    <span>{{ date('Y') }} KurikulumApp | Dibuat dengan</span>
                    <svg class="w-5 h-5 text-red-500 inline-block" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>dan</span>
                    <svg class="w-5 h-5 text-yellow-500 inline-block" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18 8h-1V6a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a5 5 0 005 5h6a5 5 0 005-5v-6a2 2 0 00-2-2zm-7-2a3 3 0 016 0v2h-6V6zm7 10a3 3 0 01-3 3H9a3 3 0 01-3-3v-6h12v6z">
                        </path>
                    </svg>
                    <span>untuk Pendidikan Indonesia yang Lebih Maju | Tim IT SMPN 4 Gununghalu</span>
                </div>
            </footer>
            <!-- ======================================================================= -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @stack('scripts')
</body>

</html>
