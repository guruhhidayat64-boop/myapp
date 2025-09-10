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
        <div class="min-h-screen bg-gray-100 flex" x-data="{ open: true }">
            <!-- Sidebar -->
            <aside :class="{'w-64': open, 'w-20': !open}" class="bg-gray-800 text-white flex-shrink-0 transition-all duration-300">
                <!-- Logo/Brand -->
                <div class="h-16 flex items-center justify-center bg-gray-900">
                    <a href="{{ route('dashboard') }}">
                        <h1 class="text-2xl font-bold" x-show="open">KurikulumApp</h1>
                        <h1 class="text-2xl font-bold" x-show="!open">KA</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-5">
                    <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="ml-4" x-show="open">Dashboard</span>
                    </a>

                    <!-- === MENU ADMIN === -->
                    @if(auth()->user()->role == 'admin')
                        <h2 class="px-4 mt-4 mb-2 text-gray-400 uppercase tracking-wider" x-show="open">Admin</h2>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-9-9"></path></svg>
        <span class="ml-4" x-show="open">Kelola Pengguna</span>
    </a>
                        <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="ml-4" x-show="open">Profil Sekolah</span>
                        </a>
                        <!-- Tambahkan menu admin lainnya di sini -->
                    @endif

                    <!-- === MENU GURU === -->
                    @if(auth()->user()->role == 'guru')
                         <h2 class="px-4 mt-4 mb-2 text-gray-400 uppercase tracking-wider" x-show="open">Guru</h2>
                         <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span class="ml-4" x-show="open">Tujuan Pembelajaran</span>
                        </a>
                        <!-- Tambahkan menu guru lainnya di sini -->
                    @endif

                    <!-- === MENU KEPALA SEKOLAH === -->
                    @if(auth()->user()->role == 'kepala_sekolah')
                         <h2 class="px-4 mt-4 mb-2 text-gray-400 uppercase tracking-wider" x-show="open">Kepala Sekolah</h2>
                         <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="ml-4" x-show="open">Monitoring</span>
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white shadow flex justify-between items-center p-4">
                    <!-- Tombol untuk hide/show sidebar -->
                    <button @click="open = !open" class="text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 relative focus:outline-none">
                            <h2 class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</h2>
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10" x-cloak>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <!-- Logout Form -->
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
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="mb-6">
                            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                                {{ $header }}
                            </h1>
                        </header>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
