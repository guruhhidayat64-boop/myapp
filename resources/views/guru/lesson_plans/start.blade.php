    <x-app-layout>
        <x-slot name="header">
            Buat Modul Ajar Baru (Langkah 1 dari 2)
        </x-slot>

        <div class="p-6 bg-white rounded-md shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pilih Alur Tujuan Pembelajaran (ATP)</h3>
            <p class="text-gray-600 mb-6">Pilih ATP yang akan Anda jadikan dasar untuk membuat Modul Ajar. Tujuan Pembelajaran dari ATP tersebut akan tersedia untuk dipilih di langkah berikutnya.</p>

            @if($teachingFlows->isEmpty())
                <div class="p-4 text-center text-yellow-800 bg-yellow-100 border-l-4 border-yellow-500">
                    <p>Anda belum memiliki Alur Tujuan Pembelajaran (ATP). Silakan buat ATP terlebih dahulu sebelum membuat Modul Ajar.</p>
                    <a href="{{ route('teacher.teaching-flows.create') }}" class="inline-block mt-4 font-semibold text-yellow-900 hover:underline">
                        Buat ATP Sekarang &rarr;
                    </a>
                </div>
            @else
                <form action="{{ route('teacher.lesson-plans.create') }}" method="GET"> <!-- Aksi form ini akan kita tentukan di langkah selanjutnya -->
                    <div class="space-y-4">
                        <div>
                            <label for="teaching_flow_id" class="block text-sm font-medium text-gray-700">Pilih ATP yang sudah ada:</label>
                            <select name="teaching_flow_id" id="teaching_flow_id" required class="block w-full max-w-lg mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">-- Pilih sebuah ATP --</option>
                                @foreach($teachingFlows as $flow)
                                    <option value="{{ $flow->id }}">{{ $flow->name }} ({{ $flow->subject->name }} - {{ $flow->gradeLevel->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-start mt-6">
                        <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Lanjutkan ke Pemilihan TP &rarr;
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </x-app-layout>
    