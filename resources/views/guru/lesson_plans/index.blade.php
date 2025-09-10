<x-app-layout>
    <x-slot name="header">
        Rencana Pembelajaran / Modul Ajar Saya
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <div class="mb-4">
            <a href="{{ route('teacher.lesson-plans.start') }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Buat Modul Ajar Baru
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
                        <th class="px-6 py-3 text-left">Judul Modul Ajar</th>
                        <th class="px-6 py-3 text-left">Konteks</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($lessonPlans as $plan)
        <tr>
            <td class="px-6 py-4 font-semibold">{{ $plan->title }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">{{ $plan->subject->name ?? 'N/A' }} / {{ $plan->gradeLevel->name ?? 'N/A' }}</td>
            <!-- DATA KOLOM BARU -->
            <td class="px-6 py-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    @if($plan->status == 'Disetujui') bg-green-100 text-green-800 @endif
                    @if($plan->status == 'Perlu Revisi') bg-red-100 text-red-800 @endif
                    @if($plan->status == 'Menunggu Tinjauan') bg-gray-100 text-gray-800 @endif
                ">
                    {{ $plan->status }}
                </span>
            </td>
            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                <a href="{{ route('teacher.lesson-plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                <form action="{{ route('teacher.lesson-plans.destroy', $plan) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Modul Ajar ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-4 text-center">Anda belum membuat Modul Ajar.</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
        <div class="mt-4">{{ $lessonPlans->links() }}</div>
    </div>
</x-app-layout>