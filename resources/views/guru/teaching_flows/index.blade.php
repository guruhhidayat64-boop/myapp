<x-app-layout>
    <x-slot name="header">
        Alur Tujuan Pembelajaran (ATP) Saya
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <div class="mb-4">
            <a href="{{ route('teacher.teaching-flows.create') }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Buat Alur Tujuan Pembelajaran Baru
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama ATP</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Konteks</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($teachingFlows as $flow)
                        <tr>
                            <td class="px-6 py-4 font-semibold">{{ $flow->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $flow->subject->name }} / {{ $flow->gradeLevel->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($flow->status == 'Disetujui') bg-green-100 text-green-800 @endif
                                    @if($flow->status == 'Perlu Revisi') bg-red-100 text-red-800 @endif
                                    @if($flow->status == 'Menunggu Tinjauan') bg-gray-100 text-gray-800 @endif
                                ">
                                    {{ $flow->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('teacher.teaching-flows.edit', $flow) }}" class="text-indigo-600 hover:text-indigo-900">Susun Alur</a>
                                <a href="{{ route('teacher.teaching-flows.download', $flow) }}" class="ml-4 text-green-600 hover:text-green-900">Unduh</a>
                                <a href="{{ route('teacher.teaching-flows.print', $flow) }}" target="_blank" class="ml-4 text-blue-600 hover:text-blue-900">Cetak</a>
                                <form action="{{ route('teacher.teaching-flows.destroy', $flow) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ATP ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Anda belum membuat ATP.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $teachingFlows->links() }}</div>
    </div>
</x-app-layout>
