<x-app-layout>
    <x-slot name="header">
        Dasbor Siswa
    </x-slot>

    <div class="space-y-6">
        <!-- Kartu Asesmen Mendatang -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Asesmen Mendatang</h3>
            <div class="space-y-4">
                @forelse ($upcomingAssessments as $assessment)
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-blue-800">{{ $assessment->name }}</span>
                            <span
                                class="text-sm font-medium text-blue-600">{{ $assessment->assessment_date->isoFormat('dddd, D MMM') }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $assessment->subject->name }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center">Tidak ada asesmen dalam 7 hari ke depan. Selamat
                        belajar!</p>
                @endforelse
            </div>
        </div>

        <!-- Kartu Nilai Terbaru -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Nilai Terbaru</h3>
            <div class="space-y-4">
                @forelse ($recentGrades as $grade)
                    <div class="p-3 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-green-800">{{ $grade->assessment->name }}</span>
                            <span class="text-2xl font-bold text-green-600">{{ $grade->score }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $grade->assessment->subject->name }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center">Belum ada nilai yang diinput oleh guru.</p>
                @endforelse
            </div>
        </div>

        <!-- Kartu Info Sekolah -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Info Sekolah</h3>
            <div class="space-y-4">
                @forelse ($schoolEvents as $event)
                    <div class="p-3 bg-gray-50 border-l-4 border-gray-400 rounded-r-lg">
                        <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                        <p class="text-sm text-gray-600">{{ $event->start->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center">Tidak ada agenda sekolah dalam waktu dekat.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
