<x-app-layout>
    <x-slot name="header">
        Tambah Capaian Pembelajaran Baru
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <!-- Tampilkan Error Validasi -->
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.learning-outcomes.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Pilihan Fase -->
                <div>
                    <label for="phase_id" class="block text-sm font-medium text-gray-700">Fase</label>
                    <select name="phase_id" id="phase_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Pilih Fase --</option>
                        @foreach ($phases as $phase)
                            <option value="{{ $phase->id }}" {{ old('phase_id') == $phase->id ? 'selected' : '' }}>
                                {{ $phase->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilihan Mata Pelajaran -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select name="subject_id" id="subject_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilihan Elemen -->
                <div>
                    <label for="element_id" class="block text-sm font-medium text-gray-700">Elemen</label>
                    <select name="element_id" id="element_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Pilih Elemen --</option>
                        @foreach ($elements as $element)
                            <option value="{{ $element->id }}" {{ old('element_id') == $element->id ? 'selected' : '' }}>
                                {{ $element->name }} (Mapel: {{ $element->subject->name ?? ''}})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Tips: Untuk mempermudah, Anda bisa membuat dropdown Elemen ini dinamis berdasarkan pilihan Mata Pelajaran menggunakan JavaScript nanti.</p>
                </div>

                <!-- Deskripsi CP -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Capaian Pembelajaran</label>
                    <textarea name="description" id="description" rows="5" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.learning-outcomes.index') }}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
