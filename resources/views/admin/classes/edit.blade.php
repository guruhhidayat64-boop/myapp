<x-app-layout>
    <x-slot name="header">
        Edit Kelas: {{ $class->name }}
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

        <form action="{{ route('admin.classes.update', $class) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Nama Kelas -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="name" id="name" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                        value="{{ old('name', $class->name) }}" placeholder="Contoh: 7A">
                </div>

                <!-- Tingkat Kelas Induk -->
                <div>
                    <label for="grade_level_id" class="block text-sm font-medium text-gray-700">Tingkat Kelas
                        Induk</label>
                    <select name="grade_level_id" id="grade_level_id" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Tingkat Kelas --</option>
                        @foreach ($gradeLevels as $grade)
                            <option value="{{ $grade->id }}" @selected(old('grade_level_id', $class->grade_level_id) == $grade->id)>
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
                <button type="submit"
                    class="px-6 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
