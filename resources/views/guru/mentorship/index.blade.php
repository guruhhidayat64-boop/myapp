    <x-app-layout>
        <x-slot name="header">
            Bimbingan Wali: {{ $mentorshipGroup->name }}
        </x-slot>
        <div class="p-6 bg-white rounded-md shadow-md">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Murid Dampingan</h3>
            <p class="text-sm text-gray-500">Total: {{ $students->count() }} siswa</p>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($students as $student)
                    <div class="border rounded-lg p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">
                                <a href="{{ route('teacher.portfolio.show', $student) }}"
                                    class="text-indigo-600 hover:underline">
                                    {{ $student->name }}
                                </a>
                            </p>
                            <p class="text-sm text-gray-500">{{ $student->nisn ?? 'NISN belum diisi' }}</p>
                        </div>
                        <a href="{{ route('teacher.mentorship.student.show', $student) }}"
                            class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">Buka Jurnal &rarr;</a>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada siswa yang ditambahkan ke kelompok
                        bimbingan Anda.</p>
                @endforelse
            </div>
        </div>
    </x-app-layout>
