<x-app-layout>
    <x-slot name="header">
        Susun Alur: {{ $teachingFlow->name }}
    </x-slot>

    <form id="atp-form" action="{{ route('teacher.teaching-flows.update', $teachingFlow) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Panel Kiri: Bank TP -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Bank Tujuan Pembelajaran (TP)</h3>
                    @if (Auth::user()->role == 'guru')
                        <button type="button" id="ai-sort-btn"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                            Minta AI Susunkan
                        </button>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mb-4">Seret TP dari sini ke panel kanan, atau klik "Minta AI Susunkan"
                    untuk membuat draf otomatis.</p>
                <div id="bank-tp" class="min-h-[300px] p-2 bg-gray-50 rounded-md border border-dashed">
                    @forelse ($availableObjectives as $objective)
                        <div class="p-3 mb-2 bg-white border rounded-md shadow-sm cursor-move"
                            data-id="{{ $objective->id }}">
                            <p class="font-medium text-gray-800">{{ $objective->description }}</p>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-400">
                            Semua TP yang relevan sudah ada di alur Anda, atau Anda belum membuat TP untuk konteks ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Panel Kanan: Kanvas ATP -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Kanvas Alur Tujuan Pembelajaran (ATP)</h3>
                <p class="text-sm text-gray-500 mb-4">Susun urutan, isi JP, dan tambahkan catatan di sini.</p>
                <div id="canvas-atp" class="min-h-[300px] p-2 bg-blue-50 rounded-md border border-dashed">
                    @foreach ($flowObjectives as $objective)
                        <div class="p-3 mb-2 bg-white border rounded-md shadow-sm cursor-move"
                            data-id="{{ $objective->id }}">
                            <p class="font-medium text-gray-800">{{ $objective->description }}</p>
                            <div class="grid grid-cols-1 gap-2 mt-3 md:grid-cols-5">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-medium text-gray-600">Perkiraan JP</label>
                                    <input type="number" name="objectives[{{ $objective->id }}][estimated_hours]"
                                        value="{{ $objective->pivot->estimated_hours }}"
                                        class="w-full p-1 mt-1 text-sm border-gray-300 rounded-md shadow-sm"
                                        placeholder="JP" @if (Auth::user()->role == 'kepala_sekolah') readonly @endif>
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-600">Materi / Aktivitas</label>
                                    <input type="text" name="objectives[{{ $objective->id }}][notes]"
                                        value="{{ $objective->pivot->notes }}"
                                        class="w-full p-1 mt-1 text-sm border-gray-300 rounded-md shadow-sm"
                                        placeholder="Catatan singkat..."
                                        @if (Auth::user()->role == 'kepala_sekolah') readonly @endif>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tombol Aksi (hanya untuk guru) -->
        @if (Auth::user()->role == 'guru')
            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('teacher.teaching-flows.index') }}"
                    class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Simpan Alur Pembelajaran
                </button>
            </div>
        @endif
    </form>

    {{-- Panel Validasi hanya untuk Kepala Sekolah --}}
    @if (Auth::user()->role == 'kepala_sekolah')
        <div class="mt-8 p-6 bg-yellow-50 border-t-4 border-yellow-400 rounded-b-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Panel Validasi & Umpan Balik</h3>
            <form action="{{ route('headmaster.monitoring.atp.validate', $teachingFlow) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Validasi</label>
                        <select name="status" id="status" class="block w-full max-w-xs mt-1">
                            <option value="Menunggu Tinjauan" @selected($teachingFlow->status == 'Menunggu Tinjauan')>Menunggu Tinjauan</option>
                            <option value="Disetujui" @selected($teachingFlow->status == 'Disetujui')>Disetujui</option>
                            <option value="Perlu Revisi" @selected($teachingFlow->status == 'Perlu Revisi')>Perlu Revisi</option>
                        </select>
                    </div>
                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700">Catatan Umpan
                            Balik</label>
                        <textarea name="feedback" id="feedback" rows="4" class="block w-full mt-1"
                            placeholder="Berikan masukan yang konstruktif untuk guru...">{{ $teachingFlow->feedback }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 text-white bg-yellow-600 rounded-md hover:bg-yellow-700">
                            Simpan Tinjauan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @push('scripts')
        <script>
            const CSRF_TOKEN = '{{ csrf_token() }}';
            document.addEventListener('DOMContentLoaded', function() {
                const bankTpEl = document.getElementById('bank-tp');
                const canvasAtpEl = document.getElementById('canvas-atp');
                const atpForm = document.getElementById('atp-form');
                const aiSortBtn = document.getElementById('ai-sort-btn');
                const userRole = "{{ Auth::user()->role }}";
                const isDraggable = userRole === 'guru';

                new Sortable(bankTpEl, {
                    group: 'atp-group',
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    sort: isDraggable
                });
                new Sortable(canvasAtpEl, {
                    group: 'atp-group',
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    sort: isDraggable,
                    onEnd: function(evt) {
                        if (!isDraggable) return;
                        const itemEl = evt.item;
                        const objectiveId = itemEl.dataset.id;
                        if (!itemEl.querySelector('input[type="number"]')) {
                            const detailsDiv = document.createElement('div');
                            detailsDiv.className = 'grid grid-cols-1 gap-2 mt-3 md:grid-cols-5';
                            detailsDiv.innerHTML =
                                `<div class="md:col-span-1"><label class="block text-xs font-medium text-gray-600">Perkiraan JP</label><input type="number" name="objectives[${objectiveId}][estimated_hours]" class="w-full p-1 mt-1 text-sm border-gray-300 rounded-md shadow-sm" placeholder="JP"></div><div class="md:col-span-4"><label class="block text-xs font-medium text-gray-600">Materi / Aktivitas</label><input type="text" name="objectives[${objectiveId}][notes]" class="w-full p-1 mt-1 text-sm border-gray-300 rounded-md shadow-sm" placeholder="Catatan singkat..."></div>`;
                            itemEl.appendChild(detailsDiv);
                        }
                    }
                });

                if (aiSortBtn) {
                    aiSortBtn.addEventListener('click', async function() {
                        const bankItems = Array.from(bankTpEl.querySelectorAll('.cursor-move'));
                        if (bankItems.length < 2) {
                            alert('Perlu ada minimal 2 TP di Bank untuk dapat diurutkan oleh AI.');
                            return;
                        }
                        aiSortBtn.disabled = true;
                        aiSortBtn.innerHTML = 'AI sedang berpikir...';
                        const objectivesData = bankItems.map(item => ({
                            id: item.dataset.id,
                            description: item.querySelector('p').textContent
                        }));

                        try {
                            const response = await fetch(
                                "{{ route('teacher.teaching-flows.generateAtpAi') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': CSRF_TOKEN
                                    },
                                    body: JSON.stringify({
                                        objectives: objectivesData,
                                        subject: "{{ $teachingFlow->subject->name }}",
                                        grade_level: "{{ $teachingFlow->gradeLevel->name }}"
                                    })
                                });

                            if (!response.ok) throw new Error('Gagal mendapatkan urutan dari AI.');
                            const data = await response.json();

                            // ==================== LOGIKA BARU DI SINI ====================
                            const sortedObjectives = data.sorted_objectives;

                            sortedObjectives.forEach(sortedObj => {
                                const itemToMove = bankTpEl.querySelector(
                                    `[data-id="${sortedObj.id}"]`);
                                if (itemToMove) {
                                    // 1. Pindahkan item ke kanvas
                                    canvasAtpEl.appendChild(itemToMove);

                                    // 2. Buat input fields jika belum ada
                                    let detailsDiv = itemToMove.querySelector('.grid');
                                    if (!detailsDiv) {
                                        detailsDiv = document.createElement('div');
                                        detailsDiv.className =
                                            'grid grid-cols-1 gap-2 mt-3 md:grid-cols-5';
                                        itemToMove.appendChild(detailsDiv);
                                    }
                                    detailsDiv.innerHTML = `
                                    <div class="md:col-span-1">
                                        <label class="block text-xs font-medium text-gray-600">Perkiraan JP</label>
                                        <input type="number" name="objectives[${sortedObj.id}][estimated_hours]" class="w-full p-1 mt-1 text-sm border-gray-300 rounded-md shadow-sm" placeholder="JP">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-xs font-medium text-gray-600">Materi / Aktivitas</label>
                                        <input type="text" name="objectives[${sortedObj.id}][notes]" class="w-full p-1 mt-1 text-sm border-gray-300 rounded-md shadow-sm" placeholder="Catatan singkat...">
                                    </div>
                                `;

                                    // 3. Isi input fields dengan data dari AI
                                    itemToMove.querySelector(
                                        `input[name="objectives[${sortedObj.id}][estimated_hours]"]`
                                    ).value = sortedObj.estimated_hours;
                                    itemToMove.querySelector(
                                            `input[name="objectives[${sortedObj.id}][notes]"]`)
                                        .value = sortedObj.notes;
                                }
                            });
                            // ==========================================================

                        } catch (error) {
                            alert(error.message);
                        } finally {
                            aiSortBtn.disabled = false;
                            aiSortBtn.innerHTML =
                                `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg> Minta AI Susunkan`;
                        }
                    });
                }

                if (atpForm && userRole === 'guru') {
                    atpForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const canvasItems = canvasAtpEl.querySelectorAll('.cursor-move');
                        const oldOrderInputs = atpForm.querySelectorAll('input[name$="[order]"]');
                        oldOrderInputs.forEach(input => input.remove());
                        canvasItems.forEach((item, index) => {
                            const objectiveId = item.dataset.id;
                            const orderInput = document.createElement('input');
                            orderInput.type = 'hidden';
                            orderInput.name = `objectives[${objectiveId}][order]`;
                            orderInput.value = index;
                            item.appendChild(orderInput);
                            const idInput = document.createElement('input');
                            idInput.type = 'hidden';
                            idInput.name = `objectives[${objectiveId}][id]`;
                            idInput.value = objectiveId;
                            item.appendChild(idInput);
                        });
                        atpForm.submit();
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
