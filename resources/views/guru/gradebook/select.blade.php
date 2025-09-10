<x-app-layout>
    <x-slot name="header">
        Asesmen & Penilaian
    </x-slot>

    <div class="p-6 bg-white rounded-md shadow-md max-w-2xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Pilih Buku Nilai</h3>
        <p class="text-gray-600 mb-6">Pilih kelas dan mata pelajaran yang ingin Anda kelola penilaiannya.</p>

        @if ($assignments->isEmpty())
            <div class="p-4 text-center text-yellow-800 bg-yellow-100 border-l-4 border-yellow-500">
                <p>Anda belum memiliki penugasan mengajar. Hubungi Admin untuk mendapatkan penugasan.</p>
            </div>
        @else
            <form id="select-gradebook-form">
                <div class="space-y-4">
                    <div>
                        <label for="context" class="block text-sm font-medium text-gray-700">Pilih Kelas & Mata
                            Pelajaran:</label>
                        <select id="context" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih --</option>
                            @foreach ($assignments as $assignment)
                                <option
                                    value="{{ route('teacher.gradebook.index', ['class' => $assignment->class_id, 'subject' => $assignment->subject_id]) }}">
                                    {{ $assignment->class_name }} - {{ $assignment->subject_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-start mt-6">
                    <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Buka Buku Nilai &rarr;
                    </button>
                </div>
            </form>
        @endif
    </div>

    @push('scripts')
        <script>
            document.getElementById('select-gradebook-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const select = document.getElementById('context');
                const url = select.value;
                if (url) {
                    window.location.href = url;
                }
            });
        </script>
    @endpush
</x-app-layout>
