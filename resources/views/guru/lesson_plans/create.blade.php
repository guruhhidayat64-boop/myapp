<x-app-layout>
    <x-slot name="header">
        Buat Modul Ajar Baru (dengan Bantuan AI)
    </x-slot>

    <form action="{{ route('teacher.lesson-plans.store') }}" method="POST">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $teachingFlow->subject_id }}" id="subject_id_hidden">
        <input type="hidden" name="grade_level_id" value="{{ $teachingFlow->grade_level_id }}" id="grade_level_id_hidden">

        <div class="space-y-8">
            <!-- ======================= 1. IDENTIFIKASI ======================= -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">1. Identifikasi</h3>
                <div class="space-y-6">
                    <div>
                        <label for="initial_assessment" class="block text-sm font-medium text-gray-700">Asesmen pada Awal Pembelajaran (Opsional)</label>
                        <textarea name="initial_assessment" id="initial_assessment" rows="3" class="block w-full mt-1" placeholder="Tuliskan strategi penilaian yang digunakan pada awal pembelajaran dan tindak lanjut hasil asesmen awal."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dimensi Profil Lulusan</label>
                        @php
                            $profiles = ['Beriman dan Bertakwa', 'Mandiri', 'Kolaborasi', 'Kesehatan', 'Kritis', 'Kreatif', 'Kemandirian', 'Komunikasi'];
                        @endphp
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                            @foreach($profiles as $profile)
                                <label class="flex items-center">
                                    <input type="checkbox" name="graduate_profile_dimensions[]" value="{{ $profile }}" class="rounded">
                                    <span class="ml-2 text-gray-700">{{ $profile }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================= 2. DESAIN PEMBELAJARAN ======================= -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">2. Desain Pembelajaran</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan Pembelajaran (Pilih dari ATP)</label>
                        <div id="tp-checkbox-container" class="space-y-2 max-h-60 overflow-y-auto p-3 border rounded-md">
                            @foreach ($teachingFlow->learningObjectives as $objective)
                                <label class="flex items-center">
                                    <input type="checkbox" name="learning_objective_ids[]" value="{{ $objective->id }}" class="rounded tp-checkbox">
                                    <span class="ml-2 text-gray-700">{{ $objective->description }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label for="pedagogical_practices" class="block text-sm font-medium text-gray-700">Praktik Pedagogis</label>
                        <div class="relative">
                            <textarea name="pedagogical_practices" id="pedagogical_practices" rows="3" class="block w-full mt-1 pr-10" placeholder="Tuliskan Model/Strategi/Metode..."></textarea>
                            <button type="button" class="absolute top-2 right-2 p-1 text-gray-400 hover:text-blue-600 ai-helper-btn" data-section="pedagogical_practices" title="Minta bantuan AI">🪄</button>
                        </div>
                    </div>
                    <div>
                        <label for="partnership" class="block text-sm font-medium text-gray-700">Kemitraan (Opsional)</label>
                        <textarea name="partnership" id="partnership" rows="3" class="block w-full mt-1" placeholder="Tuliskan kegiatan kemitraan atau kolaborasi..."></textarea>
                    </div>
                </div>
            </div>

            <!-- ======================= 3. PENGALAMAN BELAJAR ======================= -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">3. Pengalaman Belajar</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Memahami</label>
                        <div class="relative">
                            <textarea name="learning_activities[memahami][description]" id="memahami" rows="4" class="block w-full mt-1 pr-10" placeholder="Tuliskan kegiatan untuk membangun pemahaman..."></textarea>
                            <button type="button" class="absolute top-2 right-2 p-1 text-gray-400 hover:text-blue-600 ai-helper-btn" data-section="memahami" title="Minta bantuan AI">🪄</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mengaplikasi</label>
                        <div class="relative">
                            <textarea name="learning_activities[mengaplikasi][description]" id="mengaplikasi" rows="4" class="block w-full mt-1 pr-10" placeholder="Tuliskan kegiatan untuk aplikasi kontekstual..."></textarea>
                            <button type="button" class="absolute top-2 right-2 p-1 text-gray-400 hover:text-blue-600 ai-helper-btn" data-section="mengaplikasi" title="Minta bantuan AI">🪄</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Merefleksi</label>
                        <div class="relative">
                            <textarea name="learning_activities[merefleksi][description]" id="merefleksi" rows="4" class="block w-full mt-1 pr-10" placeholder="Tuliskan kegiatan untuk refleksi..."></textarea>
                            <button type="button" class="absolute top-2 right-2 p-1 text-gray-400 hover:text-blue-600 ai-helper-btn" data-section="merefleksi" title="Minta bantuan AI">🪄</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================= 4. ASESMEN ======================= -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">4. Asesmen Pembelajaran</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Asesmen Formatif</label>
                         <div class="relative">
                            <textarea name="assessment[formatif]" id="assessment_formatif" rows="4" class="block w-full mt-1 pr-10" placeholder="Tuliskan teknik dan instrumen penilaian formatif..."></textarea>
                            <button type="button" class="absolute top-2 right-2 p-1 text-gray-400 hover:text-blue-600 ai-helper-btn" data-section="assessment_formatif" title="Minta bantuan AI">🪄</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Asesmen Sumatif</label>
                        <div class="relative">
                            <textarea name="assessment[sumatif]" id="assessment_sumatif" rows="4" class="block w-full mt-1 pr-10" placeholder="Tuliskan teknik dan instrumen penilaian sumatif..."></textarea>
                            <button type="button" class="absolute top-2 right-2 p-1 text-gray-400 hover:text-blue-600 ai-helper-btn" data-section="assessment_sumatif" title="Minta bantuan AI">🪄</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ======================= INFORMASI UMUM (VERSI BARU) ======================= -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Umum & Judul</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Modul Ajar</label>
                        <input type="text" name="title" id="title" required class="block w-full mt-1" placeholder="Contoh: Modul Ajar - Pengenalan Aljabar">
                    </div>
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                        <input type="text" name="academic_year" id="academic_year" required class="block w-full mt-1" placeholder="Contoh: 2025/2026">
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select name="semester" id="semester" required class="block w-full mt-1">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div>
                        <label for="duration_in_minutes" class="block text-sm font-medium text-gray-700">Alokasi Waktu (dalam menit)</label>
                        <input type="number" name="duration_in_minutes" id="duration_in_minutes" class="block w-full mt-1" placeholder="Contoh: 120">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-8 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Simpan Modul Ajar
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const aiHelperButtons = document.querySelectorAll('.ai-helper-btn');
        const tpCheckboxContainer = document.getElementById('tp-checkbox-container');

        aiHelperButtons.forEach(button => {
            button.addEventListener('click', async function() {
                const section = this.dataset.section;
                const targetTextarea = document.getElementById(section);
                
                const selectedTpCheckboxes = tpCheckboxContainer.querySelectorAll('.tp-checkbox:checked');
                if (selectedTpCheckboxes.length === 0) {
                    alert('Harap pilih minimal satu Tujuan Pembelajaran terlebih dahulu.');
                    return;
                }
                let objectivesText = '';
                selectedTpCheckboxes.forEach(cb => {
                    objectivesText += '- ' + cb.nextElementSibling.textContent.trim() + '\n';
                });

                const subjectName = "{{ $teachingFlow->subject->name }}";
                const gradeLevelName = "{{ $teachingFlow->gradeLevel->name }}";
                
                this.textContent = '🧠';
                this.disabled = true;
                targetTextarea.value = 'AI sedang merancang, mohon tunggu...';

                try {
                    const response = await fetch("{{ route('teacher.lesson-plans.generateAiSection') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            section: section,
                            objectives: objectivesText,
                            subject: subjectName,
                            grade_level: gradeLevelName
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Gagal mendapatkan respons dari server.');
                    }

                    const data = await response.json();
                    
                    if (data.text) {
                        targetTextarea.value = data.text;
                    } else {
                        throw new Error(data.error || 'AI tidak memberikan hasil yang valid.');
                    }

                } catch (error) {
                    targetTextarea.value = 'Terjadi kesalahan: ' + error.message;
                } finally {
                    this.textContent = '🪄';
                    this.disabled = false;
                }
            });
        });
    });
    </script>
    @endpush
</x-app-layout>
