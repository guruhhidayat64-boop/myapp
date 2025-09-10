<x-app-layout>
    <x-slot name="header">
        Kelola Fase Pembelajaran
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <!-- Tombol Tambah -->
        <div class="mb-4">
            <a href="{{ route('admin.phases.create') }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Tambah Fase
            </a>
        </div>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Fase -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Fase</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($phases as $phase)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $phase->name }}</td>
                            <td class="px-6 py-4">{{ $phase->description }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('admin.phases.edit', $phase) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.phases.destroy', $phase) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fase ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                Tidak ada data fase.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Link Paginasi -->
        <div class="mt-4">
            {{ $phases->links() }}
        </div>
    </div>
</x-app-layout>
