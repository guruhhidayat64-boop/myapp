<x-app-layout>
    <x-slot name="header">Tambah Mata Pelajaran</x-slot>
    <div class="p-6 bg-white rounded-md shadow-md">
        <form action="{{ route('admin.subjects.store') }}" method="POST">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 mr-2 text-gray-700 bg-white border rounded-md hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>