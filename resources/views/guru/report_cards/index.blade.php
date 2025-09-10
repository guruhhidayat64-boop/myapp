<x-app-layout>
    <x-slot name="header">
        Laporan Rapor Kelas Wali: {{ $homeroomClass->name }}
    </x-slot>
    <div class="p-6 bg-white rounded-md shadow-md">
        <h3 class="text-lg font-semibold text-gray-800">Pilih Siswa</h3>
        <p class="text-sm text-gray-500">Pilih siswa untuk melihat dan mengenerate deskripsi rapor.</p>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($homeroomClass->students as $student)
                <a href="{{ route('teacher.report-cards.show', $student) }}"
                    class="block border rounded-lg p-4 hover:bg-gray-50">
                    <p class="font-semibold">{{ $student->name }}</p>
                    <p class="text-sm text-gray-500">{{ $student->nisn ?? 'NISN belum diisi' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
