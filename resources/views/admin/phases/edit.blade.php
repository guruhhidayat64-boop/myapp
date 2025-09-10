<x-app-layout>
    <x-slot name="header">
        Edit Fase: {{ $phase->name }}
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

        <form action="{{ route('admin.phases.update', $phase) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Nama Fase -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Fase</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $phase->name) }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $phase->description) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.phases.index') }}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
