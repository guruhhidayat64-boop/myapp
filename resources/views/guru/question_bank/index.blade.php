<x-app-layout>
    <x-slot name="header">
        Bank Soal Pribadi
    </x-slot>

    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Soal</h3>
                <a href="{{ route('teacher.question-bank.create') }}"
                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    + Buat Soal Baru
                </a>
            </div>
            <!-- Filter -->
            <form action="{{ route('teacher.question-bank.index') }}" method="GET" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select name="subject_id" class="block w-full text-sm">
                        <option value="">Semua Mapel</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="grade_level_id" class="block w-full text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach ($gradeLevels as $g)
                            <option value="{{ $g->id }}" @selected(request('grade_level_id') == $g->id)>{{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 text-sm text-white bg-gray-600 rounded-md">Filter</button>
                </div>
            </form>

            <!-- Tabel Soal -->
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Soal</th>
                            <th class="px-6 py-3 text-left">Jenis</th>
                            <th class="px-6 py-3 text-left">Konteks</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($questions as $question)
                            <tr>
                                <td class="px-6 py-4">{!! \Illuminate\Support\Str::limit($question->question_text, 100) !!}</td>
                                <td class="px-6 py-4">{{ $question->type }}</td>
                                <td class="px-6 py-4 text-xs">{{ $question->subject->name }} /
                                    {{ $question->gradeLevel->name }}</td>
                                <td class="px-6 py-4 text-right"><a href="#" class="text-indigo-600">Edit</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada soal di bank
                                    data Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $questions->appends(request()->query())->links() }}</div>
        </div>
    </div>
</x-app-layout>
