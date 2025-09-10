<x-app-layout>
    <x-slot name="header">
        Kelola Kriteria Ketercapaian Tujuan Pembelajaran (KKTP)
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Tujuan Pembelajaran:</h3>
        <p class="mt-1 text-gray-600">{{ $learningObjective->description }}</p>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('teacher.kktp.store', $learningObjective) }}" method="POST">
        @csrf
        <div class="p-6 bg-white rounded-lg shadow-md">
            <!-- Pemilihan Pendekatan -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Pilih Pendekatan KKTP</label>
                <select id="type" name="type"
                    class="block w-full max-w-sm mt-1 border-gray-300 rounded-md shadow-sm">
                    <option value="deskripsi" @selected(old('type', $kktp->type) == 'deskripsi')>1. Deskripsi Kriteria</option>
                    <option value="rubrik" @selected(old('type', $kktp->type) == 'rubrik')>2. Rubrik</option>
                    <option value="skala" @selected(old('type', $kktp->type) == 'skala')>3. Skala / Interval Nilai</option>
                </select>
            </div>

            <!-- Form Dinamis -->
            <div class="mt-6">
                <!-- Opsi 1: Form Deskripsi -->
                <div id="deskripsi-form" class="kktp-form space-y-4">
                    <h4 class="font-semibold">Deskripsi Kriteria</h4>
                    <p class="text-sm text-gray-500">Jelaskan bukti-bukti yang dapat diamati yang menunjukkan
                        ketercapaian TP.</p>
                    <textarea name="content[description]" rows="5" class="block w-full">{{ old('content.description', $kktp->content['description'] ?? '') }}</textarea>
                </div>

                <!-- Opsi 2: Form Rubrik -->
                <div id="rubrik-form" class="kktp-form space-y-4 hidden">
                    <h4 class="font-semibold">Rubrik Penilaian</h4>
                    <div id="rubrik-container" class="space-y-3">
                        <!-- Baris rubrik akan ditambahkan oleh JavaScript -->
                    </div>
                    <button type="button" id="add-rubrik-row" class="text-sm text-blue-600 hover:text-blue-800">+
                        Tambah Baris Kriteria</button>
                </div>

                <!-- Opsi 3: Form Skala -->
                <div id="skala-form" class="kktp-form space-y-4 hidden">
                    <h4 class="font-semibold">Skala / Interval Nilai</h4>
                    <div id="skala-container" class="space-y-3">
                        <!-- Baris skala akan ditambahkan oleh JavaScript -->
                    </div>
                    <button type="button" id="add-skala-row" class="text-sm text-blue-600 hover:text-blue-800">+ Tambah
                        Interval</button>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-8 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Simpan KKTP
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('type');
                const forms = document.querySelectorAll('.kktp-form');

                function toggleForm() {
                    const selectedType = typeSelect.value;
                    forms.forEach(form => {
                        if (form.id === `${selectedType}-form`) {
                            form.classList.remove('hidden');
                        } else {
                            form.classList.add('hidden');
                        }
                    });
                }

                typeSelect.addEventListener('change', toggleForm);

                // --- Logika untuk Rubrik Dinamis ---
                const rubrikContainer = document.getElementById('rubrik-container');
                const addRubrikBtn = document.getElementById('add-rubrik-row');
                let rubrikIndex = 0;
                const existingRubrik = @json(old('content.rubrik', $kktp->type === 'rubrik' ? $kktp->content['rubrik'] ?? [] : []));

                function addRubrikRow(kriteria = '', bb = '', c = '', l = '', m = '') {
                    const row = document.createElement('div');
                    row.className = 'p-3 border rounded-md space-y-2';
                    row.innerHTML = `
                    <div class="flex justify-between items-center">
                        <label class="font-medium text-sm">Kriteria Penilaian</label>
                        <button type="button" class="text-red-500 remove-row-btn">&times;</button>
                    </div>
                    <textarea name="content[rubrik][${rubrikIndex}][kriteria]" rows="2" class="w-full text-sm" placeholder="Contoh: Kemampuan mengidentifikasi bilangan bulat">${kriteria}</textarea>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <textarea name="content[rubrik][${rubrikIndex}][bb]" rows="3" class="w-full text-xs" placeholder="Baru Berkembang...">${bb}</textarea>
                        <textarea name="content[rubrik][${rubrikIndex}][c]" rows="3" class="w-full text-xs" placeholder="Cukup...">${c}</textarea>
                        <textarea name="content[rubrik][${rubrikIndex}][l]" rows="3" class="w-full text-xs" placeholder="Layak...">${l}</textarea>
                        <textarea name="content[rubrik][${rubrikIndex}][m]" rows="3" class="w-full text-xs" placeholder="Mahir...">${m}</textarea>
                    </div>
                `;
                    rubrikContainer.appendChild(row);
                    rubrikIndex++;
                }

                if (existingRubrik.length > 0) {
                    existingRubrik.forEach(item => addRubrikRow(item.kriteria, item.bb, item.c, item.l, item.m));
                } else if (typeSelect.value === 'rubrik') {
                    addRubrikRow(); // Tambah satu baris kosong jika rubrik dipilih tapi belum ada data
                }

                addRubrikBtn.addEventListener('click', () => addRubrikRow());
                rubrikContainer.addEventListener('click', e => {
                    if (e.target.classList.contains('remove-row-btn')) e.target.closest('.border').remove();
                });

                // ==================== KODE BARU UNTUK SKALA/INTERVAL ====================
                const skalaContainer = document.getElementById('skala-container');
                const addSkalaBtn = document.getElementById('add-skala-row');
                let skalaIndex = 0;
                const existingSkala = @json(old('content.skala', $kktp->type === 'skala' ? $kktp->content['skala'] ?? [] : []));

                function addSkalaRow(interval = '', description = '') {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-4';
                    row.innerHTML = `
                    <div class="w-1/3">
                        <label class="block text-xs font-medium text-gray-600">Interval Nilai</label>
                        <input type="text" name="content[skala][${skalaIndex}][interval]" class="w-full text-sm mt-1" placeholder="Contoh: 85 - 100" value="${interval}">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-600">Deskripsi</label>
                        <input type="text" name="content[skala][${skalaIndex}][description]" class="w-full text-sm mt-1" placeholder="Contoh: Sangat Kompeten" value="${description}">
                    </div>
                    <button type="button" class="mt-5 text-red-500 remove-row-btn">&times;</button>
                `;
                    skalaContainer.appendChild(row);
                    skalaIndex++;
                }

                if (existingSkala.length > 0) {
                    existingSkala.forEach(item => addSkalaRow(item.interval, item.description));
                } else if (typeSelect.value === 'skala') {
                    addSkalaRow(); // Tambah satu baris kosong jika skala dipilih tapi belum ada data
                }

                addSkalaBtn.addEventListener('click', () => addSkalaRow());
                skalaContainer.addEventListener('click', e => {
                    if (e.target.classList.contains('remove-row-btn')) e.target.closest('.flex').remove();
                });
                // =======================================================================

                // Panggil toggleForm di awal untuk menampilkan form yang benar
                toggleForm();
            });
        </script>
    @endpush
</x-app-layout>
