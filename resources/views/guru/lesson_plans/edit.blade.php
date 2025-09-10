<x-app-layout>
    <x-slot name="header">
        Edit Modul Ajar: {{ $lessonPlan->title }}
    </x-slot>

    <form action="{{ route('teacher.lesson-plans.update', $lessonPlan) }}" method="POST">
        @csrf
        @method('PUT') <!-- PENTING: Gunakan method PUT untuk update -->

        <div class="space-y-8">
            <!-- Informasi Umum -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">A. Informasi Umum</h3>
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Modul Ajar</label>
                        <input type="text" name="title" id="title" required class="block w-full mt-1" value="{{ old('title', $lessonPlan->title) }}">
                    </div>
                    <div>
                        <label for="duration_in_minutes" class="block text-sm font-medium text-gray-700">Alokasi Waktu (dalam menit)</label>
                        <input type="number" name="duration_in_minutes" id="duration_in_minutes" class="block w-full mt-1" value="{{ old('duration_in_minutes', $lessonPlan->duration_in_minutes) }}">
                    </div>
                </div>
            </div>

            <!-- Komponen Inti -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">B. Komponen Inti</h3>
                <div class="space-y-6">
                    <!-- Pilihan Tujuan Pembelajaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">1. Tujuan Pembelajaran (Pilih dari ATP)</label>
                        <div class="space-y-2 max-h-60 overflow-y-auto p-3 border rounded-md">
                            @foreach ($teachingFlow->learningObjectives as $objective)
                                <label class="flex items-center">
                                    <input type="checkbox" name="learning_objective_ids[]" value="{{ $objective->id }}" class="rounded" 
                                        {{ in_array($objective->id, $selectedObjectives) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700">{{ $objective->description }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <!-- Pemahaman Bermakna -->
                    <div>
                        <label for="meaningful_understanding" class="block text-sm font-medium text-gray-700">2. Pemahaman Bermakna</label>
                        <textarea name="meaningful_understanding" id="meaningful_understanding" rows="3" class="block w-full mt-1">{{ old('meaningful_understanding', $lessonPlan->meaningful_understanding) }}</textarea>
                    </div>
                    <!-- Pertanyaan Pemantik -->
                    <div>
                        <label for="essential_questions" class="block text-sm font-medium text-gray-700">3. Pertanyaan Pemantik</label>
                        <textarea name="essential_questions" id="essential_questions" rows="3" class="block w-full mt-1">{{ old('essential_questions', $lessonPlan->essential_questions) }}</textarea>
                    </div>
                    <!-- Kegiatan Pembelajaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">4. Kegiatan Pembelajaran</label>
                        <div id="learning-activities-container" class="space-y-4">
                            <!-- Langkah-langkah diisi oleh JavaScript -->
                        </div>
                        <button type="button" id="add-activity-btn" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Tambah Langkah Kegiatan</button>
                    </div>
                     <!-- Asesmen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">5. Asesmen / Penilaian</label>
                        <textarea name="assessment[description]" rows="4" class="block w-full mt-1">{{ old('assessment.description', $lessonPlan->assessment['description'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Lampiran -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">C. Lampiran</h3>
                <div class="space-y-4">
                    <div>
                        <label for="student_worksheet" class="block text-sm font-medium text-gray-700">Lembar Kerja Peserta Didik (LKPD)</label>
                        <textarea name="student_worksheet" id="student_worksheet" rows="5" class="block w-full mt-1">{{ old('student_worksheet', $lessonPlan->student_worksheet) }}</textarea>
                    </div>
                    <div>
                        <label for="reading_materials" class="block text-sm font-medium text-gray-700">Bahan Bacaan Guru & Siswa</label>
                        <textarea name="reading_materials" id="reading_materials" rows="5" class="block w-full mt-1">{{ old('reading_materials', $lessonPlan->reading_materials) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-8 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('learning-activities-container');
            const addBtn = document.getElementById('add-activity-btn');
            let activityIndex = 0;
            
            // Ambil data kegiatan yang sudah ada dari PHP
            const existingActivities = @json($lessonPlan->learning_activities ?? []);

            function addActivityStep(type = '', content = '') {
                const newStep = document.createElement('div');
                newStep.className = 'flex items-start gap-2 p-2 border rounded-md';
                newStep.innerHTML = `
                    <select name="learning_activities[${activityIndex}][type]" class="p-2 border-gray-300 rounded-md">
                        <option value="Pendahuluan" ${type === 'Pendahuluan' ? 'selected' : ''}>Pendahuluan</option>
                        <option value="Kegiatan Inti" ${type === 'Kegiatan Inti' ? 'selected' : ''}>Kegiatan Inti</option>
                        <option value="Penutup" ${type === 'Penutup' ? 'selected' : ''}>Penutup</option>
                    </select>
                    <textarea name="learning_activities[${activityIndex}][content]" rows="2" class="flex-1 border-gray-300 rounded-md" placeholder="Deskripsikan langkah kegiatan...">${content}</textarea>
                    <button type="button" class="p-2 text-red-500 remove-activity-btn">&times;</button>
                `;
                container.appendChild(newStep);
                activityIndex++;
            }

            // Isi container dengan data yang sudah ada
            if (existingActivities && existingActivities.length > 0) {
                existingActivities.forEach(activity => {
                    addActivityStep(activity.type, activity.content);
                });
            } else {
                // Jika tidak ada data, tambahkan langkah awal
                addActivityStep('Pendahuluan');
                addActivityStep('Kegiatan Inti');
                addActivityStep('Penutup');
            }

            addBtn.addEventListener('click', () => addActivityStep());

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-activity-btn')) {
                    e.target.closest('.flex').remove();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>