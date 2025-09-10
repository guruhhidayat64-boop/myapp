<x-app-layout>
    <x-slot name="header">
        Buat Tujuan Pembelajaran (TP) Baru
    </x-slot>

    <div class="space-y-6">
        <!-- Bagian 1: Form Pilihan -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Langkah 1: Tentukan Konteks Pembelajaran</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Dropdown Fase -->
                <div>
                    <label for="phase_id" class="block text-sm font-medium text-gray-700">Fase</label>
                    <select id="phase_id" name="phase_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Fase --</option>
                        @foreach ($phases as $phase)
                            <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Dropdown Tingkat Kelas (Awalnya disembunyikan) -->
                <div id="grade-level-wrapper" class="hidden">
                    <label for="grade_level_id" class="block text-sm font-medium text-gray-700">Tingkat Kelas</label>
                    <select id="grade_level_id" name="grade_level_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <!-- Opsi diisi oleh JavaScript -->
                    </select>
                </div>
                <!-- Dropdown Mata Pelajaran (Awalnya disembunyikan) -->
                <div id="subject-wrapper" class="hidden">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select id="subject_id" name="subject_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <!-- Opsi diisi oleh JavaScript -->
                    </select>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Pilihan Elemen & CP (Awalnya disembunyikan) -->
        <div id="element-cp-wrapper" class="hidden p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Langkah 2: Pilih Elemen & Capaian Pembelajaran</h3>
            <div id="element-selection" class="space-y-4">
                <!-- Checkbox Elemen diisi oleh JavaScript -->
            </div>
            <div id="cp-display" class="mt-4 p-4 bg-gray-50 rounded-md border border-gray-200 hidden">
                <h4 class="font-semibold text-gray-700">Deskripsi Capaian Pembelajaran Terpilih:</h4>
                <div id="cp-description" class="mt-2 text-gray-600 prose max-w-none"></div>
            </div>
        </div>

        <!-- Bagian 3: Ruang Lingkup & Tombol Generate (Awalnya disembunyikan) -->
        <div id="scope-wrapper" class="hidden p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Langkah 3: Masukkan Ruang Lingkup Materi & Generate</h3>
            <div>
                <label for="scope" class="block text-sm font-medium text-gray-700">Ruang Lingkup Materi</label>
                <textarea id="scope" name="scope" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Operasi penjumlahan dan pengurangan bilangan cacah sampai 1000, pengenalan nilai tempat, dan perbandingan bilangan."></textarea>
            </div>
            <button id="generate-ai-btn" class="inline-flex items-center px-4 py-2 mt-4 text-white bg-green-600 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                Generate dengan AI
            </button>
        </div>

        <!-- Bagian 4: Hasil Generate AI (Awalnya disembunyikan) -->
        <div id="result-wrapper" class="hidden p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Langkah 4: Review dan Simpan Tujuan Pembelajaran</h3>
            <div id="loading-indicator" class="hidden my-4 text-center">
                <p class="text-gray-600">AI sedang berpikir... Mohon tunggu sebentar.</p>
                <div class="mt-2 w-16 h-16 border-4 border-blue-400 border-dashed rounded-full animate-spin mx-auto"></div>
            </div>
            <div id="error-message" class="hidden p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"></div>
            
            <form id="save-form" action="{{ route('teacher.learning-objectives.store') }}" method="POST">
                @csrf
                <!-- Input tersembunyi untuk data konteks -->
                <input type="hidden" name="phase_id" id="hidden_phase_id">
                <input type="hidden" name="grade_level_id" id="hidden_grade_level_id">
                <input type="hidden" name="subject_id" id="hidden_subject_id">
                <input type="hidden" name="scope" id="hidden_scope">

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Deskripsi Tujuan Pembelajaran (Bisa Diedit)</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="result-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Hasil generate AI akan muncul di sini -->
                        </tbody>
                    </table>
                </div>
                <button type="submit" id="save-btn" class="inline-flex items-center px-4 py-2 mt-4 text-white bg-blue-600 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Simpan Semua Tujuan Pembelajaran
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua elemen DOM yang dibutuhkan
            const phaseSelect = document.getElementById('phase_id');
            const gradeLevelWrapper = document.getElementById('grade-level-wrapper');
            const gradeLevelSelect = document.getElementById('grade_level_id');
            const subjectWrapper = document.getElementById('subject-wrapper');
            const subjectSelect = document.getElementById('subject_id');
            const elementCpWrapper = document.getElementById('element-cp-wrapper');
            const elementSelection = document.getElementById('element-selection');
            const cpDisplay = document.getElementById('cp-display');
            const cpDescription = document.getElementById('cp-description');
            const scopeWrapper = document.getElementById('scope-wrapper');
            const generateBtn = document.getElementById('generate-ai-btn');
            const resultWrapper = document.getElementById('result-wrapper');
            const loadingIndicator = document.getElementById('loading-indicator');
            const errorMessage = document.getElementById('error-message');
            const resultTableBody = document.getElementById('result-table-body');
            const saveForm = document.getElementById('save-form');

            // Fungsi untuk mereset dan menyembunyikan elemen
            function resetAndHide(...elements) {
                elements.forEach(el => {
                    el.classList.add('hidden');
                    if (el.tagName === 'SELECT') {
                        el.innerHTML = '';
                    } else if (el.id === 'element-selection' || el.id === 'cp-description') {
                        el.innerHTML = '';
                    }
                });
            }

            // Event listener untuk dropdown Fase
            phaseSelect.addEventListener('change', async function () {
                const phaseId = this.value;
                resetAndHide(gradeLevelWrapper, subjectWrapper, elementCpWrapper, scopeWrapper, resultWrapper);

                if (phaseId) {
                    const response = await fetch(`/api/grade-levels/${phaseId}`);
                    const gradeLevels = await response.json();
                    
                    gradeLevelSelect.innerHTML = '<option value="">-- Pilih Tingkat Kelas --</option>';
                    gradeLevels.forEach(grade => {
                        gradeLevelSelect.innerHTML += `<option value="${grade.id}">${grade.name}</option>`;
                    });
                    gradeLevelWrapper.classList.remove('hidden');
                }
            });

            // Event listener untuk dropdown Tingkat Kelas
            gradeLevelSelect.addEventListener('change', async function () {
                const gradeLevelId = this.value;
                resetAndHide(subjectWrapper, elementCpWrapper, scopeWrapper, resultWrapper);
                
                if (gradeLevelId) {
                    const response = await fetch(`/api/subjects`);
                    const subjects = await response.json();

                    subjectSelect.innerHTML = '<option value="">-- Pilih Mata Pelajaran --</option>';
                    subjects.forEach(subject => {
                        subjectSelect.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                    });
                    subjectWrapper.classList.remove('hidden');
                }
            });

            // Event listener untuk dropdown Mata Pelajaran
            subjectSelect.addEventListener('change', async function () {
                const subjectId = this.value;
                const phaseId = phaseSelect.value;
                resetAndHide(elementCpWrapper, scopeWrapper, resultWrapper);
                elementSelection.innerHTML = ''; // Kosongkan pilihan elemen
                cpDisplay.classList.add('hidden');

                if (subjectId && phaseId) {
                    const response = await fetch(`/api/elements-and-cp?phase_id=${phaseId}&subject_id=${subjectId}`);
                    const learningOutcomes = await response.json();
                    
                    if (learningOutcomes.length > 0) {
                        learningOutcomes.forEach(outcome => {
                            // ==================== PERUBAHAN DI SINI ====================
                            // value dari checkbox diisi dengan element_id
                            // ==========================================================
                            elementSelection.innerHTML += `
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                           name="learning_outcomes[]" 
                                           value="${outcome.element_id}" 
                                           data-cp="${outcome.description.replace(/"/g, '&quot;')}">
                                    <span class="ml-2 text-gray-700">${outcome.element.name}</span>
                                </label>
                            `;
                        });
                        elementCpWrapper.classList.remove('hidden');
                    } else {
                        elementSelection.innerHTML = '<p class="text-gray-500">Tidak ada data Elemen & CP untuk kombinasi Fase dan Mata Pelajaran ini.</p>';
                        elementCpWrapper.classList.remove('hidden');
                    }
                }
            });

            // Event listener untuk area pemilihan elemen (menggunakan event delegation)
            elementSelection.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox') {
                    const selectedCheckboxes = elementSelection.querySelectorAll('input[type="checkbox"]:checked');
                    let combinedCp = '';
                    
                    selectedCheckboxes.forEach(checkbox => {
                        combinedCp += `<li>${checkbox.dataset.cp}</li>`;
                    });

                    if (combinedCp) {
                        cpDescription.innerHTML = `<ul>${combinedCp}</ul>`;
                        cpDisplay.classList.remove('hidden');
                        scopeWrapper.classList.remove('hidden');
                    } else {
                        cpDisplay.classList.add('hidden');
                        scopeWrapper.classList.add('hidden');
                    }
                }
            });

            // Event listener untuk tombol Generate AI
            generateBtn.addEventListener('click', async function() {
                const selectedCheckboxes = elementSelection.querySelectorAll('input[type="checkbox"]:checked');
                const scopeText = document.getElementById('scope').value;

                if (selectedCheckboxes.length === 0 || !scopeText.trim()) {
                    alert('Harap pilih minimal satu Elemen dan isi Ruang Lingkup Materi.');
                    return;
                }

                let combinedCpText = '';
                selectedCheckboxes.forEach(checkbox => {
                    combinedCpText += checkbox.dataset.cp + '\n';
                });

                // Tampilkan loading & sembunyikan pesan error lama
                loadingIndicator.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                resultWrapper.classList.remove('hidden');
                resultTableBody.innerHTML = ''; // Kosongkan tabel hasil sebelumnya

                try {
                    const response = await fetch("{{ route('teacher.learning-objectives.generateAi') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            capaian_pembelajaran: combinedCpText,
                            scope: scopeText
                        })
                    });

                    loadingIndicator.classList.add('hidden');
                    
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.error || 'Terjadi kesalahan pada server.');
                    }

                    const data = await response.json();
                    
                    if (data.objectives && data.objectives.length > 0) {
                        data.objectives.forEach(obj => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="px-6 py-4">
                                    <div contenteditable="true" class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">${obj.description}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="text-red-600 hover:text-red-900 delete-row-btn">Hapus</button>
                                </td>
                            `;
                            resultTableBody.appendChild(row);
                        });
                    } else {
                         throw new Error('AI tidak memberikan hasil yang diharapkan.');
                    }

                } catch (error) {
                    errorMessage.textContent = 'Error: ' + error.message;
                    errorMessage.classList.remove('hidden');
                }
            });

            // Event listener untuk tombol hapus baris (delegation)
            resultTableBody.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-row-btn')) {
                    e.target.closest('tr').remove();
                }
            });

            // Event listener untuk form penyimpanan
            saveForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Hentikan submit standar

                // Kumpulkan semua deskripsi dari tabel hasil
                const objectiveElements = resultTableBody.querySelectorAll('div[contenteditable="true"]');
                if (objectiveElements.length === 0) {
                    alert('Tidak ada Tujuan Pembelajaran untuk disimpan.');
                    return;
                }
                
                // Hapus input lama jika ada
                const oldInputs = saveForm.querySelectorAll('input[name="objectives[]"]');
                oldInputs.forEach(input => input.remove());
                
                const oldElementInputs = saveForm.querySelectorAll('input[name="learning_outcomes[]"]');
                oldElementInputs.forEach(input => input.remove());

                // Tambahkan input baru yang berisi deskripsi TP
                objectiveElements.forEach(el => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'objectives[]';
                    hiddenInput.value = el.textContent;
                    saveForm.appendChild(hiddenInput);
                });

                // Tambahkan input untuk element_id yang dipilih
                const selectedCheckboxes = elementSelection.querySelectorAll('input[type="checkbox"]:checked');
                selectedCheckboxes.forEach(checkbox => {
                    const hiddenElementInput = document.createElement('input');
                    hiddenElementInput.type = 'hidden';
                    hiddenElementInput.name = 'learning_outcomes[]';
                    hiddenElementInput.value = checkbox.value; // value ini sudah berisi element_id
                    saveForm.appendChild(hiddenElementInput);
                });


                // Isi input tersembunyi dengan data konteks
                document.getElementById('hidden_phase_id').value = phaseSelect.value;
                document.getElementById('hidden_grade_level_id').value = gradeLevelSelect.value;
                document.getElementById('hidden_subject_id').value = subjectSelect.value;
                document.getElementById('hidden_scope').value = document.getElementById('scope').value;

                // Submit form
                saveForm.submit();
            });
        });
    </script>
    @endpush
</x-app-layout>
