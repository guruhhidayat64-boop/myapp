<x-app-layout>
    <x-slot name="header">
        Portofolio Digital: {{ $student->name }}
    </x-slot>

    <div class="space-y-8">
        <!-- Panel Informasi Siswa -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Profil Siswa</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <dt class="font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-gray-900 font-semibold">{{ $student->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">NISN</dt>
                    <dd class="mt-1 text-gray-900">{{ $student->nisn ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Jenis Kelamin</dt>
                    <dd class="mt-1 text-gray-900">{{ $student->gender }}</dd>
                </div>
            </div>
        </div>

        <!-- Panel Rekapitulasi Nilai per Mata Pelajaran -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Rekapitulasi Hasil Asesmen</h3>

            @forelse ($gradesBySubject as $subjectName => $grades)
                <div class="mb-6 border-b last:border-b-0 pb-4">
                    <h4 class="text-lg font-bold text-gray-700">{{ $subjectName }}</h4>

                    <div class="mt-4 space-y-4">
                        @foreach ($grades->groupBy('assessment.name') as $assessmentName => $assessmentGrades)
                            <div class="border rounded-md p-4">
                                <div class="flex justify-between items-center">
                                    <p class="font-semibold">{{ $assessmentName }}</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $assessmentGrades->first()->score }}
                                    </p>
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    <p><strong>Jenis:</strong> {{ $assessmentGrades->first()->assessment->type }}</p>
                                    <p><strong>TP yang Diukur:</strong></p>
                                    <ul class="list-disc list-inside pl-2">
                                        @foreach ($assessmentGrades->first()->assessment->learningObjectives as $objective)
                                            <li>{{ $objective->description }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Siswa ini belum memiliki nilai.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
