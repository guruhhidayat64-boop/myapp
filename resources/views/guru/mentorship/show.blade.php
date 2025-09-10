<x-app-layout>
    <x-slot name="header">
        Jurnal Perkembangan: {{ $student->name }}
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Form Tambah Catatan -->
        <div class="lg:col-span-1">
            <form action="{{ route('teacher.mentorship.student.log.store', $student) }}" method="POST"
                class="p-6 bg-white rounded-lg shadow-md space-y-4">
                @csrf
                <h3 class="text-lg font-semibold text-gray-800">Tambah Catatan Baru</h3>
                <div>
                    <label for="log_date" class="block text-sm font-medium">Tanggal</label>
                    <input type="date" name="log_date" id="log_date" required class="block w-full mt-1"
                        value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium">Kategori Pendampingan</label>
                    <select name="category" id="category" required class="block w-full mt-1">
                        <option value="Akademik">Akademik</option>
                        <option value="Kompetensi & Keterampilan">Kompetensi & Keterampilan</option>
                        <option value="Karakter">Karakter</option>
                    </select>
                </div>
                <div>
                    <label for="content" class="block text-sm font-medium">Isi Catatan / Observasi</label>
                    <textarea name="content" id="content" rows="5" required class="block w-full mt-1"
                        placeholder="Tuliskan hasil observasi atau percakapan dengan siswa..."></textarea>
                </div>
                <div>
                    <label for="follow_up" class="block text-sm font-medium">Tindak Lanjut (Opsional)</label>
                    <textarea name="follow_up" id="follow_up" rows="3" class="block w-full mt-1"
                        placeholder="Rencana tindak lanjut atau hal yang perlu didiskusikan..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan
                        Catatan</button>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Riwayat Catatan -->
        <div class="lg:col-span-2">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Jurnal Perkembangan</h3>
                <div class="space-y-6">
                    @forelse ($student->developmentLogs as $log)
                        <div
                            class="border-l-4 pl-4 
                                @if ($log->category == 'Akademik') border-blue-500 @endif
                                @if ($log->category == 'Kompetensi & Keterampilan') border-green-500 @endif
                                @if ($log->category == 'Karakter') border-yellow-500 @endif
                            ">
                            <div class="flex justify-between items-baseline">
                                <span
                                    class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                        @if ($log->category == 'Akademik') bg-blue-100 text-blue-800 @endif
                                        @if ($log->category == 'Kompetensi & Keterampilan') bg-green-100 text-green-800 @endif
                                        @if ($log->category == 'Karakter') bg-yellow-100 text-yellow-800 @endif
                                    ">{{ $log->category }}</span>
                                <span
                                    class="text-xs text-gray-500">{{ $log->log_date->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                            <p class="mt-2 text-gray-700">{{ $log->content }}</p>
                            @if ($log->follow_up)
                                <div class="mt-2 p-2 text-sm bg-gray-50 border-t rounded-b-md">
                                    <strong>Tindak Lanjut:</strong> {{ $log->follow_up }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Belum ada catatan perkembangan untuk siswa ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
