<x-app-layout>
    <x-slot name="header">
        Tambah Kelas Baru (Rombongan Belajar)
    </x-slot>

    <div class="p-6 bg-white rounded-md shadow-md max-w-2xl mx-auto">
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

        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Nama Kelas -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="name" id="name" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}"
                        placeholder="Contoh: 7A, 10 MIPA 1, dll.">
                </div>

                <!-- Tingkat Kelas Induk -->
                <div>
                    <label for="grade_level_id" class="block text-sm font-medium text-gray-700">Tingkat Kelas
                        Induk</label>
                    <select name="grade_level_id" id="grade_level_id" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Tingkat Kelas --</option>
                        @foreach ($gradeLevels as $grade)
                            <option value="{{ $grade->id }}"
                                {{ old('grade_level_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end mt-6 space-x-4">
                <a href="{{ route('admin.classes.index') }}"
                    class="px-6 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
