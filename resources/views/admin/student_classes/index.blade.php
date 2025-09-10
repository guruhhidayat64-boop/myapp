<x-app-layout>
    <x-slot name="header">
        Manajemen Kelas Siswa
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Panel Filter -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Kelas & Tahun Ajaran</h3>
            <form action="{{ route('admin.student_classes.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="academic_year" class="block text-sm font-medium">Tahun Ajaran</label>
                        <input type="text" name="academic_year" id="academic_year" class="block w-full mt-1"
                            value="{{ $academicYear }}" placeholder="Contoh: 2025/2026">
                    </div>
                    <div>
                        <label for="class_id" class="block text-sm font-medium">Pilih Kelas</label>
                        <select name="class_id" id="class_id" required class="block w-full mt-1">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Tampilkan Siswa
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if ($selectedClass)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Panel Kiri: Siswa Belum Ditempatkan -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Siswa Belum Ditempatkan</h3>
                    <div class="max-h-96 overflow-y-auto">
                        <table class="min-w-full">
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($studentsNotInClass as $student)
                                    <tr>
                                        <td class="py-2">{{ $student->name }}</td>
                                        <td class="py-2 text-right">
                                            <form action="{{ route('admin.student_classes.assign') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <input type="hidden" name="academic_year" value="{{ $academicYear }}">
                                                <button type="submit"
                                                    class="text-sm text-green-600 hover:text-green-900">Tambahkan
                                                    &rarr;</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-4 text-center text-gray-400">Semua siswa sudah memiliki kelas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Panel Kanan: Siswa di Kelas -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Siswa di Kelas {{ $selectedClass->name }}</h3>
                    <div class="max-h-96 overflow-y-auto">
                        <table class="min-w-full">
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($studentsInClass as $student)
                                    <tr>
                                        <td class="py-2">{{ $student->name }}</td>
                                        <td class="py-2 text-right">
                                            <form action="{{ route('admin.student_classes.unassign') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <input type="hidden" name="academic_year" value="{{ $academicYear }}">
                                                <button type="submit"
                                                    class="text-sm text-red-600 hover:text-red-900">&larr;
                                                    Keluarkan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-4 text-center text-gray-400">Belum ada siswa di kelas ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
