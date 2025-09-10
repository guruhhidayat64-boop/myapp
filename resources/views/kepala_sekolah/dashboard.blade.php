<x-app-layout>
    <x-slot name="header">
        Dashboard Supervisi
    </x-slot>

    <!-- Salam Pembuka -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">{{ $greeting }}, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600">Selamat datang di pusat pemantauan perencanaan pembelajaran.</p>
    </div>

    <!-- Grid untuk Kartu Statistik Utama -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Kartu Jumlah Guru -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-9-9"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Guru Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $teacherCount }}</p>
            </div>
        </div>

        <!-- Kartu Total ATP -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total ATP Dibuat</p>
                <p class="text-2xl font-bold text-gray-800">{{ $atpCount }}</p>
            </div>
        </div>

        <!-- Kartu Total Modul Ajar -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Modul Ajar</p>
                <p class="text-2xl font-bold text-gray-800">{{ $rpCount }}</p>
            </div>
        </div>

        <!-- Kartu Kelengkapan KKTP -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Kelengkapan KKTP</p>
                <p class="text-2xl font-bold text-gray-800">{{ $kktpPercentage }}%</p>
            </div>
        </div>
    </div>

    <!-- Kartu Menu Monitoring -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Menu Monitoring</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('headmaster.monitoring.atp') }}" class="px-5 py-3 text-base font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
    Monitoring ATP per Guru
</a>
            <a href="{{ route('headmaster.monitoring.lessonPlans') }}" class="px-5 py-3 text-base font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
    Monitoring Modul Ajar
</a>
            <!-- ... di dalam Kartu Menu Monitoring ... -->
<a href="{{ route('headmaster.report.atp') }}" class="px-5 py-3 text-base font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
    Laporan & Rekapitulasi
</a>
        </div>
    </div>
</x-app-layout>
