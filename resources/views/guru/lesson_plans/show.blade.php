<x-app-layout>
    <x-slot name="header">
        Detail Modul Ajar: {{ $lessonPlan->title }}
    </x-slot>

    <div class="space-y-8">
        <!-- Tombol Aksi di Atas -->
        <div class="p-4 bg-white rounded-lg shadow-md flex justify-end items-center gap-4">
            <a href="{{ route('teacher.lesson-plans.edit', $lessonPlan) }}" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Edit</a>
            <a href="{{ route('teacher.lesson-plans.download', $lessonPlan) }}" class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">Unduh PDF</a>
            <a href="{{ route('teacher.lesson-plans.print', $lessonPlan) }}" target="_blank" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">Cetak</a>
            <a href="{{ route('teacher.lesson-plans.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Kembali</a>
        </div>

        <!-- Informasi Umum -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">A. Informasi Umum</h3>
            @php
                $schoolName = \App\Models\Setting::where('key', 'school_name')->first()->value ?? 'Nama Sekolah Belum Diatur';
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-4 gap-x-8 text-sm">
                <div>
                    <dt class="font-medium text-gray-500">Sekolah</dt>
                    <dd class="mt-1 text-gray-900">{{ $schoolName }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Mata Pelajaran</dt>
                    <dd class="mt-1 text-gray-900">{{ $lessonPlan->subject->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Penyusun</dt>
                    <dd class="mt-1 text-gray-900">{{ $lessonPlan->user->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Tahun Ajaran</dt>
                    <dd class="mt-1 text-gray-900">{{ $lessonPlan->academic_year }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Semester</dt>
                    <dd class="mt-1 text-gray-900">{{ $lessonPlan->semester }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Kelas / Fase</dt>
                    <dd class="mt-1 text-gray-900">{{ $lessonPlan->gradeLevel->name }} / {{ $lessonPlan->gradeLevel->phase->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Alokasi Waktu</dt>
                    <dd class="mt-1 text-gray-900">{{ $lessonPlan->duration_in_minutes ?? 'N/A' }} menit</dd>
                </div>
            </div>
        </div>

        <!-- Komponen Inti -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">B. Komponen Inti</h3>
            <div class="space-y-6 text-sm">
                <div>
                    <h4 class="font-semibold text-gray-800">1. Tujuan Pembelajaran</h4>
                    <ul class="mt-2 list-disc list-inside pl-4 text-gray-700 space-y-1">
                        @foreach ($lessonPlan->learningObjectives as $objective)
                            <li>{{ $objective->description }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">2. Dimensi Profil Lulusan</h4>
                    <p class="mt-2 text-gray-700">{{ implode(', ', $lessonPlan->graduate_profile_dimensions ?? []) ?: 'Tidak ada.' }}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">3. Praktik Pedagogis</h4>
                    <p class="mt-2 text-gray-700">{{ $lessonPlan->pedagogical_practices ?? 'Tidak ada.' }}</p>
                </div>
            </div>
        </div>

        <!-- Pengalaman Belajar -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">C. Pengalaman Belajar</h3>
            <div class="space-y-6 text-sm">
                @php
                    $activities = collect($lessonPlan->learning_activities);
                @endphp
                <div>
                    <h4 class="font-semibold text-gray-800">Memahami</h4>
                    <div class="prose max-w-none prose-sm mt-2 text-gray-700">{!! nl2br(e($activities->get('memahami')['description'] ?? 'Tidak ada.')) !!}</div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Mengaplikasi</h4>
                    <div class="prose max-w-none prose-sm mt-2 text-gray-700">{!! nl2br(e($activities->get('mengaplikasi')['description'] ?? 'Tidak ada.')) !!}</div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Merefleksi</h4>
                    <div class="prose max-w-none prose-sm mt-2 text-gray-700">{!! nl2br(e($activities->get('merefleksi')['description'] ?? 'Tidak ada.')) !!}</div>
                </div>
            </div>
        </div>
        
        <!-- Asesmen -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">D. Asesmen Pembelajaran</h3>
            <div class="space-y-6 text-sm">
                <div>
                    <h4 class="font-semibold text-gray-800">Asesmen pada Awal Pembelajaran</h4>
                    <p class="mt-2 text-gray-700">{{ $lessonPlan->initial_assessment ?? 'Tidak ada.' }}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Asesmen Formatif</h4>
                    <div class="prose max-w-none prose-sm mt-2 text-gray-700">{!! nl2br(e($lessonPlan->assessment['formatif'] ?? 'Tidak ada.')) !!}</div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Asesmen Sumatif</h4>
                    <div class="prose max-w-none prose-sm mt-2 text-gray-700">{!! nl2br(e($lessonPlan->assessment['sumatif'] ?? 'Tidak ada.')) !!}</div>
                </div>
            </div>
        </div>

    </div> <!-- Penutup untuk div.space-y-8 -->

    <!-- ================= PANEL VALIDASI KEPALA SEKOLAH ================= -->
    @if(Auth::user()->role == 'kepala_sekolah')
    <div class="mt-8 p-6 bg-yellow-50 border-t-4 border-yellow-400 rounded-b-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Panel Validasi & Umpan Balik</h3>
        <form action="{{ route('headmaster.monitoring.lessonPlans.validate', $lessonPlan) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Validasi</label>
                    <select name="status" id="status" class="block w-full max-w-xs mt-1">
                        <option value="Menunggu Tinjauan" @selected($lessonPlan->status == 'Menunggu Tinjauan')>Menunggu Tinjauan</option>
                        <option value="Disetujui" @selected($lessonPlan->status == 'Disetujui')>Disetujui</option>
                        <option value="Perlu Revisi" @selected($lessonPlan->status == 'Perlu Revisi')>Perlu Revisi</option>
                    </select>
                </div>
                <div>
                    <label for="feedback" class="block text-sm font-medium text-gray-700">Catatan Umpan Balik</label>
                    <textarea name="feedback" id="feedback" rows="4" class="block w-full mt-1" placeholder="Berikan masukan yang konstruktif untuk guru...">{{ $lessonPlan->feedback }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 text-white bg-yellow-600 rounded-md hover:bg-yellow-700">
                        Simpan Tinjauan
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif
    <!-- =================================================================== -->

</x-app-layout>
