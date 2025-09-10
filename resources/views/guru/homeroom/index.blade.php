<x-app-layout>
    <x-slot name="header">
        Manajemen Kelas Wali: {{ $homeroomClass->name }}
    </x-slot>

    <div class="p-6 bg-white rounded-md shadow-md">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Siswa</h3>
                <p class="text-sm text-gray-500">Total: {{ $homeroomClass->students->count() }} siswa</p>
            </div>
            <a href="{{ route('teacher.homeroom.printAttendance') }}" target="_blank"
                class="inline-block px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                Cetak Daftar Hadir
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Siswa</th>
                        <th class="px-6 py-3 text-left">NISN</th>
                        <th class="px-6 py-3 text-left">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left">Kontak Orang Tua</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($homeroomClass->students as $student)
                        <tr>
                            <td class="px-6 py-4 font-medium">
                                <a href="{{ route('teacher.portfolio.show', $student) }}"
                                    class="text-indigo-600 hover:underline">
                                    {{ $student->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $student->nisn ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $student->gender }}</td>
                            <td class="px-6 py-4">{{ $student->parent_phone ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada siswa yang ditempatkan di kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
