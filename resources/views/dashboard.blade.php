<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <p class="mb-4">Selamat Datang Kembali, <strong>{{ Auth::user()->name }}</strong>!</p>
            <p>Anda login sebagai: <span class="px-2 py-1 text-sm font-semibold rounded-full {{ 
                auth()->user()->role == 'admin' ? 'bg-red-200 text-red-800' : 
                (auth()->user()->role == 'guru' ? 'bg-blue-200 text-blue-800' : 'bg-green-200 text-green-800') 
            }}">{{ Str::title(str_replace('_', ' ', auth()->user()->role)) }}</span></p>
        </div>
    </div>
</x-app-layout>
