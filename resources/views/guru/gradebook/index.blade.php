<x-app-layout>
    <x-slot name="header">
        Buku Nilai: {{ $class->name }} - {{ $subject->name }}
    </x-slot>

    <div class="p-6 bg-white rounded-md shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Nilai Siswa</h3>
            <button x-data @click="$dispatch('open-modal', 'create-assessment-modal')"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Buat Penilaian Baru
            </button>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">{!! session('success') !!}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="sticky left-0 bg-gray-50 px-4 py-2 text-left z-10 w-52 border">Nama Siswa</th>
                        @foreach ($assessments as $assessment)
                            <th class="px-4 py-2 border whitespace-nowrap">{{ $assessment->name }}</th>
                        @endforeach
                        @if ($assessments->isEmpty())
                            <th class="px-4 py-2 border">Belum ada penilaian.</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="sticky left-0 bg-white hover:bg-gray-50 px-4 py-2 font-medium z-10 w-52 border">
                                {{ $student->name }}</td>
                            @foreach ($assessments as $assessment)
                                <td class="border text-center p-0">
                                    <input type="text"
                                        class="w-full h-full text-center border-0 focus:ring-2 focus:ring-blue-300 grade-input"
                                        value="{{ $grades[$student->id][$assessment->id]->score ?? '' }}"
                                        data-student-id="{{ $student->id }}" data-assessment-id="{{ $assessment->id }}"
                                        placeholder="-">
                                </td>
                            @endforeach
                            @if ($assessments->isEmpty())
                                <td class="px-4 py-2 border"></td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $assessments->count() + 1 }}"
                                class="px-4 py-2 text-center text-gray-500 border">Belum ada siswa di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk Membuat Penilaian Baru -->
    <x-modal name="create-assessment-modal" :show="false" focusable>
        <form action="{{ route('teacher.gradebook.assessment.store') }}" method="post" class="p-6">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            <h2 class="text-lg font-medium text-gray-900">Buat Penilaian Baru</h2>
            <div class="mt-6 space-y-4">
                <div>
                    <x-input-label for="name" value="Nama Penilaian" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        placeholder="Contoh: Ulangan Harian Bab 1" required />
                </div>
                <div>
                    <x-input-label for="type" value="Jenis Penilaian" />
                    <select name="type" id="type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Formatif">Formatif</option>
                        <option value="Sumatif">Sumatif</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="assessment_date" value="Tanggal Penilaian (Opsional)" />
                    <x-text-input id="assessment_date" name="assessment_date" type="date"
                        class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label value="Tujuan Pembelajaran yang Diukur" />
                    <div class="mt-2 space-y-2 max-h-48 overflow-y-auto p-3 border rounded-md">
                        @forelse ($learningObjectives as $objective)
                            <label class="flex items-center">
                                <input type="checkbox" name="learning_objective_ids[]" value="{{ $objective->id }}"
                                    class="rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $objective->description }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500">Tidak ada Tujuan Pembelajaran yang relevan untuk mata
                                pelajaran dan tingkat kelas ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan Penilaian</x-primary-button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const gradeInputs = document.querySelectorAll('.grade-input');

                gradeInputs.forEach(input => {
                    let originalValue = input.value;

                    input.addEventListener('focus', () => {
                        originalValue = input.value;
                    });

                    input.addEventListener('blur', function() {
                        // Hanya simpan jika nilainya berubah
                        if (this.value !== originalValue) {
                            saveGrade(this);
                        }
                    });

                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            this.blur(); // Panggil event blur untuk menyimpan
                        }
                    });
                });

                async function saveGrade(inputElement) {
                    const studentId = inputElement.dataset.studentId;
                    const assessmentId = inputElement.dataset.assessmentId;
                    const score = inputElement.value;

                    inputElement.classList.add('bg-yellow-100'); // Tanda sedang menyimpan

                    try {
                        const response = await fetch("{{ route('teacher.gradebook.grade.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                student_id: studentId,
                                assessment_id: assessmentId,
                                score: score
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Gagal menyimpan nilai.');
                        }

                        const data = await response.json();
                        if (data.success) {
                            inputElement.classList.remove('bg-yellow-100');
                            inputElement.classList.add('bg-green-100');
                            setTimeout(() => inputElement.classList.remove('bg-green-100'), 1500);
                        } else {
                            throw new Error('Server merespons tanpa sukses.');
                        }

                    } catch (error) {
                        console.error(error);
                        inputElement.classList.remove('bg-yellow-100');
                        inputElement.classList.add('bg-red-200');
                        alert('Gagal menyimpan nilai. Periksa koneksi Anda dan coba lagi.');
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
