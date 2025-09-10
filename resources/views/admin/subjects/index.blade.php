<x-app-layout>
    <x-slot name="header">Kelola Mata Pelajaran</x-slot>
    <div class="p-6 bg-white rounded-md shadow-md">
        <div class="mb-4"><a href="{{ route('admin.subjects.create') }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">+ Tambah Data</a></div>
        @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left">Nama Mata Pelajaran</th><th class="px-6 py-3 text-right">Aksi</th></tr></thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($subjects as $subject)
                    <tr>
                        <td class="px-6 py-4">{{ $subject->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.subjects.edit', $subject) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="px-6 py-4 text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $subjects->links() }}</div>
    </div>
</x-app-layout>