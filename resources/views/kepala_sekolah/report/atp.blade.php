    <x-app-layout>
        <x-slot name="header">
            Laporan Rekapitulasi Kelengkapan ATP
        </x-slot>

        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Rekapitulasi per Guru</h3>
                    <p class="text-sm text-gray-500">Berikut adalah daftar Alur Tujuan Pembelajaran (ATP) yang telah dibuat oleh setiap guru.</p>
                </div>
                <a href="{{ route('headmaster.report.atp.download') }}" target="_blank" class="inline-block px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">
                    Unduh Laporan PDF
                </a>
            </div>

            <div class="space-y-6">
                @foreach($teachers as $teacher)
                <div class="border rounded-md p-4">
                    <h4 class="font-bold text-gray-900">{{ $teacher->name }}</h4>
                    <table class="min-w-full mt-2">
                        <thead class="bg-gray-50 text-xs">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama ATP</th>
                                <th class="px-4 py-2 text-left">Konteks</th>
                                <th class="px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($teacher->teachingFlows as $flow)
                            <tr>
                                <td class="px-4 py-2">{{ $flow->name }}</td>
                                <td class="px-4 py-2">{{ $flow->subject->name }} / {{ $flow->gradeLevel->name }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($flow->status == 'Disetujui') bg-green-100 text-green-800 @endif
                                        @if($flow->status == 'Perlu Revisi') bg-red-100 text-red-800 @endif
                                        @if($flow->status == 'Menunggu Tinjauan') bg-gray-100 text-gray-800 @endif
                                    ">
                                        {{ $flow->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-400 italic">Belum ada ATP yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </x-app-layout>
    