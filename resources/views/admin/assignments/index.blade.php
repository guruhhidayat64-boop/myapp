<x-app-layout>
    <x-slot name="header">
        Penugasan Guru (berdasarkan Kelas Spesifik)
    </x-slot>

    <div class="space-y-8">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- ======================= 1. MANAJEMEN WALI KELAS ======================= -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Manajemen Wali Kelas</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Kelas</th>
                            <th class="px-4 py-2 text-left">Wali Kelas Saat Ini</th>
                            <th class="px-4 py-2 text-left">Tetapkan Wali Kelas Baru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($classes as $class)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $class->name }}</td>
                                <td class="px-4 py-3">
                                    @if ($class->homeroomTeacher)
                                        <span class="font-semibold">{{ $class->homeroomTeacher->name }}</span>
                                    @else
                                        <span class="text-gray-400 italic">Belum Ditetapkan</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.assignments.storeHomeroom') }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                                        <select name="teacher_id" required
                                            class="block w-full max-w-xs text-sm border-gray-300 rounded-md shadow-sm">
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======================= 2. MANAJEMEN GURU MATA PELAJARAN ======================= -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Manajemen Guru Mata Pelajaran</h3>

            <div class="mb-8 p-4 border rounded-md bg-gray-50">
                <h4 class="font-semibold mb-2">Tambah Penugasan Mengajar Baru</h4>
                <form action="{{ route('admin.assignments.storeTeaching') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Pilih Guru</label>
                            <select name="teacher_id" required
                                class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Pilih Mata Pelajaran</label>
                            <select name="subject_id" required
                                class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Pilih Kelas (bisa lebih dari satu)</label>
                            <div class="mt-1 p-2 border bg-white rounded-md max-h-32 overflow-y-auto">
                                @foreach ($classes as $class)
                                    <label class="flex items-center text-sm">
                                        <input type="checkbox" name="class_ids[]" value="{{ $class->id }}"
                                            class="rounded">
                                        <span class="ml-2">{{ $class->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">Tambah
                            Penugasan</button>
                    </div>
                </form>
            </div>

            <div>
                <h4 class="font-semibold mb-2">Daftar Penugasan Saat Ini</h4>
                <div class="space-y-4">
                    @forelse($teachingAssignments as $teacherName => $assignments)
                        <div class="border rounded-md p-3">
                            <h5 class="font-bold">{{ $teacherName }}</h5>
                            <ul class="mt-2 list-disc list-inside pl-4 text-sm space-y-1">
                                @foreach ($assignments->groupBy('subject_name') as $subjectName => $subjectAssignments)
                                    <li>
                                        <strong>{{ $subjectName }}</strong> di kelas:
                                        @foreach ($subjectAssignments as $assignment)
                                            <span class="inline-flex items-center bg-gray-100 rounded-full px-2 py-0.5">
                                                {{ $assignment->class_name }}
                                                <form
                                                    action="{{ route('admin.assignments.destroyTeaching', [$assignment->user_id, $assignment->subject_id, $assignment->class_id]) }}"
                                                    method="POST" class="inline-block ml-1"
                                                    onsubmit="return confirm('Hapus tugas ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700">&times;</button>
                                                </form>
                                            </span>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 italic">Belum ada penugasan mengajar yang dibuat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
