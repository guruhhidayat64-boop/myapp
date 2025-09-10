<x-app-layout>
    <x-slot name="header">
        Daftar Tujuan Pembelajaran Saya
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <!-- Tombol Tambah -->
        <div class="mb-4">
            <a href="{{ route('teacher.learning-objectives.create') }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Buat Tujuan Pembelajaran Baru
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Tujuan Pembelajaran -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Deskripsi Tujuan Pembelajaran</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Konteks</th>
                        <!-- KOLOM BARU -->
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status KKTP</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($learningObjectives as $objective)
                        <tr>
                            <td class="px-6 py-4">{{ $objective->description }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $objective->subject->name }} / {{ $objective->gradeLevel->name }} ({{ $objective->phase->name }})
                            </td>
                            <!-- STATUS BARU -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($objective->kktp)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sudah Dibuat
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Belum Dibuat
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('teacher.kktp.index', $objective) }}" class="text-green-600 hover:text-green-900">
                                    {{ $objective->kktp ? 'Lihat/Edit KKTP' : 'Buat KKTP' }}
                                </a>
                                <!-- Tombol Edit TP bisa ditambahkan di sini nanti -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                Anda belum membuat Tujuan Pembelajaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Link Paginasi -->
        <div class="mt-4">
            {{ $learningObjectives->links() }}
        </div>
    </div>
</x-app-layout>
