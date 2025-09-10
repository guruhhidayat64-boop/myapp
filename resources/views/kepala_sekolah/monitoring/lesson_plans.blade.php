<x-app-layout>
    <x-slot name="header">
        Monitoring Rencana Pembelajaran (Modul Ajar)
    </x-slot>

    <!-- Panel Filter -->
    <div class="p-6 mb-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Data</h3>
        <form action="{{ route('headmaster.monitoring.lessonPlans') }}" method="GET">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                <!-- Filter Guru -->
                <div>
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Guru</label>
                    <select name="teacher_id" id="teacher_id" class="block w-full mt-1">
                        <option value="">Semua Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Mata Pelajaran -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select name="subject_id" id="subject_id" class="block w-full mt-1">
                        <option value="">Semua Mapel</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Tingkat Kelas -->
                <div>
                    <label for="grade_level_id" class="block text-sm font-medium text-gray-700">Tingkat Kelas</label>
                    <select name="grade_level_id" id="grade_level_id" class="block w-full mt-1">
                        <option value="">Semua Kelas</option>
                        @foreach($gradeLevels as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade_level_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Tombol Aksi Filter -->
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Hasil Monitoring -->
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Judul Modul Ajar</th>
                        <th class="px-6 py-3 text-left">Guru Pembuat</th>
                        <th class="px-6 py-3 text-left">Konteks</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($lessonPlans as $plan)
                        <tr>
                            <td class="px-6 py-4 font-semibold">{{ $plan->title }}</td>
                            <td class="px-6 py-4">{{ $plan->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $plan->subject->name }} / {{ $plan->gradeLevel->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('teacher.lesson-plans.show', $plan) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data Modul Ajar yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Link Paginasi (dengan mempertahankan filter) -->
        <div class="mt-4">
            {{ $lessonPlans->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>
