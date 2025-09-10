<x-app-layout>
    <x-slot name="header">
        Buat Soal Baru
    </x-slot>

    <div x-data="{ type: 'Pilihan Ganda' }" class="p-6 bg-white rounded-md shadow-md max-w-4xl mx-auto">
        <form action="{{ route('teacher.question-bank.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Konteks dan Jenis Soal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select name="subject_id" required class="block w-full">
                        <option value="">Pilih Mapel</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <select name="grade_level_id" required class="block w-full">
                        <option value="">Pilih Tingkat Kelas</option>
                        @foreach ($gradeLevels as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                    <select name="type" x-model="type" class="block w-full">
                        <option value="Pilihan Ganda">Pilihan Ganda</option>
                        <option value="Esai">Esai</option>
                    </select>
                </div>
                <!-- Badan Soal -->
                <div>
                    <label class="block font-medium">Isi Soal</label>
                    <textarea name="question_text" rows="5" required class="block w-full mt-1"></textarea>
                </div>
                <!-- Opsi Pilihan Ganda -->
                <div x-show="type === 'Pilihan Ganda'" class="space-y-3">
                    <h4 class="font-medium">Opsi Jawaban</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm">Opsi A</label><input type="text" name="options[a]"
                                class="w-full mt-1"></div>
                        <div><label class="block text-sm">Opsi B</label><input type="text" name="options[b]"
                                class="w-full mt-1"></div>
                        <div><label class="block text-sm">Opsi C</label><input type="text" name="options[c]"
                                class="w-full mt-1"></div>
                        <div><label class="block text-sm">Opsi D</label><input type="text" name="options[d]"
                                class="w-full mt-1"></div>
                    </div>
                </div>
                <!-- Kunci Jawaban -->
                <div>
                    <label class="block font-medium">Kunci Jawaban</label>
                    <div x-show="type === 'Pilihan Ganda'">
                        <select name="answer_key_pg" class="block w-full max-w-xs mt-1">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div x-show="type === 'Esai'">
                        <textarea name="answer_key_esai" rows="3" class="block w-full mt-1"
                            placeholder="Tuliskan jawaban ideal atau rubrik penilaian singkat..."></textarea>
                    </div>
                    <input type="hidden" name="answer_key"
                        x-bind:value="type === 'Pilihan Ganda' ? document.querySelector('[name=answer_key_pg]').value : document
                            .querySelector('[name=answer_key_esai]').value">
                </div>
                <!-- Tautkan ke TP -->
                <div>
                    <label class="block font-medium">Tautkan ke Tujuan Pembelajaran</label>
                    <div class="mt-2 space-y-2 max-h-48 overflow-y-auto p-3 border rounded-md">
                        @foreach ($learningObjectives as $objective)
                            <label class="flex items-center"><input type="checkbox" name="learning_objective_ids[]"
                                    value="{{ $objective->id }}" class="rounded"><span
                                    class="ml-2 text-sm">{{ $objective->description }}</span></label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6"><button type="submit"
                    class="px-6 py-2 text-white bg-blue-600 rounded-md">Simpan Soal</button></div>
        </form>
    </div>
</x-app-layout>
