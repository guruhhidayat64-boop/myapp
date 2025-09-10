<x-app-layout>
    <x-slot name="header">
        Tambah Elemen Baru
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

        <form action="{{ route('admin.elements.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
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

                <!-- Nama Elemen -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: Bilangan">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: Meliputi pemahaman, operasi, dan aplikasi bilangan cacah, bulat, dan pecahan.">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.elements.index') }}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
