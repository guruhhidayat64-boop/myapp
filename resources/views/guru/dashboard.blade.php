<x-app-layout>
    <x-slot name="header">
        Dashboard Guru
    </x-slot>

    <!-- Salam Pembuka -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">{{ $greeting }}, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600">Semoga harimu menyenangkan dan penuh inspirasi.</p>
    </div>

    <!-- Grid untuk Kartu Statistik -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Kartu Tujuan Pembelajaran (TP) -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Tujuan Pembelajaran</p>
                <p class="text-2xl font-bold text-gray-800">{{ $tpCount }}</p>
            </div>
        </div>

        <!-- Kartu Alur Tujuan Pembelajaran (ATP) -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Alur Tujuan Pembelajaran</p>
                <p class="text-2xl font-bold text-gray-800">{{ $atpCount }}</p>
            </div>
        </div>

        <!-- Kartu Rencana Pembelajaran (RP) -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Modul Ajar</p>
                <p class="text-2xl font-bold text-gray-800">{{ $rpCount }}</p>
            </div>
        </div>
    </div>

    <!-- ==================== PANEL BARU: PERLU TINJAUAN ==================== -->
    @if($flowsForRevision->isNotEmpty())
    <div class="mt-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-md">
        <h3 class="text-lg font-semibold text-red-800 mb-4">Perlu Tinjauan Anda</h3>
        <div class="space-y-3">
            @foreach($flowsForRevision as $flow)
            <a href="{{ route('teacher.teaching-flows.edit', $flow) }}" class="block p-3 bg-white rounded-md hover:shadow-lg transition-shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $flow->name }}</p>
                        <p class="text-sm text-gray-500">{{ $flow->subject->name }} / {{ $flow->gradeLevel->name }}</p>
                    </div>
                    <span class="text-sm font-medium text-red-600">Lihat Umpan Balik &rarr;</span>
                </div>
                @if($flow->feedback)
                <div class="mt-2 p-2 text-sm bg-red-100 border-t border-red-200 text-red-900 rounded-b-md">
                    <strong>Catatan dari Kepala Sekolah:</strong> {{ \Illuminate\Support\Str::limit($flow->feedback, 100) }}
                </div>
                @endif
            </a>
            @endforeach
        </div>
    </div>
    @endif
    <!-- ==================================================================== -->

    <!-- Kartu Aksi Cepat (dengan link yang sudah diperbaiki) -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('teacher.learning-objectives.create') }}" class="px-5 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                + Buat Tujuan Pembelajaran
            </a>
            <a href="{{ route('teacher.teaching-flows.index') }}" class="px-5 py-3 text-base font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                Lihat Semua Alur Pembelajaran
            </a>
             <a href="{{ route('teacher.lesson-plans.start') }}" class="px-5 py-3 text-base font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                + Buat Modul Ajar Baru
            </a>
        </div>
    </div>

</x-app-layout>
