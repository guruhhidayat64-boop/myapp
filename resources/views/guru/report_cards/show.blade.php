<x-app-layout>
    <x-slot name="header">
        Generator Rapor: {{ $student->name }}
    </x-slot>

    <div class="space-y-6">
        @forelse ($gradesBySubject as $subjectName => $grades)
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800">{{ $subjectName }}</h3>

                <div class="mt-4 text-sm text-gray-600 border-t pt-4">
                    <h4 class="font-semibold">Rekapitulasi Pencapaian Kompetensi:</h4>
                    <ul class="list-disc list-inside pl-2 mt-2">
                        @php $summary = ''; @endphp
                        @foreach ($grades->pluck('assessment.learningObjectives')->flatten()->unique('id') as $objective)
                            @php
                                // Cari nilai tertinggi untuk TP ini
                                $scores = $grades
                                    ->filter(fn($g) => $g->assessment->learningObjectives->contains($objective))
                                    ->pluck('score');
                                $highestScore = $scores->filter(fn($s) => is_numeric($s))->max() ?? $scores->first();
                                $summary .= "- TP: {$objective->description}, Nilai Tertinggi: {$highestScore}\n";
                            @endphp
                            <li>{{ $objective->description }} (Nilai Tertinggi: <strong>{{ $highestScore }}</strong>)
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold">Deskripsi Rapor:</h4>
                    <textarea id="narrative-{{ \Illuminate\Support\Str::slug($subjectName) }}" rows="5" class="block w-full mt-1"
                        placeholder="Deskripsi naratif akan muncul di sini..."></textarea>
                    <button
                        class="generate-narrative-btn mt-2 px-3 py-1 text-xs text-white bg-green-600 rounded-md hover:bg-green-700"
                        data-subject="{{ $subjectName }}" data-summary="{{ $summary }}"
                        data-target-id="narrative-{{ \Illuminate\Support\Str::slug($subjectName) }}">
                        Generate dengan AI 🪄
                    </button>
                </div>
            </div>
        @empty
            <div class="p-6 bg-white rounded-lg shadow-md text-center text-gray-500">
                Siswa ini belum memiliki nilai untuk ditampilkan.
            </div>
        @endforelse
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.generate-narrative-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const subject = this.dataset.subject;
                    const summary = this.dataset.summary;
                    const targetId = this.dataset.targetId;
                    const textarea = document.getElementById(targetId);

                    this.textContent = 'AI sedang menulis...';
                    this.disabled = true;

                    try {
                        const response = await fetch(
                            "{{ route('teacher.report-cards.generateNarrative') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    subject: subject,
                                    grades_summary: summary
                                })
                            });
                        if (!response.ok) throw new Error('Gagal mendapatkan respons dari AI.');
                        const data = await response.json();
                        textarea.value = data.narrative;
                    } catch (error) {
                        textarea.value = 'Terjadi kesalahan: ' + error.message;
                    } finally {
                        this.innerHTML = 'Generate dengan AI 🪄';
                        this.disabled = false;
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
