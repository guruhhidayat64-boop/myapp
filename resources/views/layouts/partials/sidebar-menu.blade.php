<!-- ==================== MENU UMUM ==================== -->
<a href="{{ route('calendar.index') }}"
    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('calendar.*') ? 'bg-gray-700' : '' }}">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
    </svg>
    <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Kalender Akademik</span>
</a>

<!-- ==================== MENU ADMIN ==================== -->
@if (auth()->user()->role == 'admin')
    <!-- Dropdown: Manajemen Sistem -->
    <div x-data="{ open: {{ request()->routeIs('admin.users.*', 'admin.school_profile.*', 'admin.assignments.*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
            <div class="flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Manajemen
                    Sistem</span>
            </div>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="open" class="pl-10 pr-4 py-1 space-y-1 bg-gray-700/50">
            <a href="{{ route('admin.users.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-600' : '' }}">Kelola
                Pengguna</a>
            <a href="{{ route('admin.school_profile.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.school_profile.*') ? 'bg-gray-600' : '' }}">Profil
                Sekolah</a>
            <a href="{{ route('admin.assignments.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.assignments.*') ? 'bg-gray-600' : '' }}">Penugasan
                Guru</a>
        </div>
    </div>

    <!-- Dropdown: Kesiswaan -->
    <div x-data="{ open: {{ request()->routeIs('admin.students.*', 'admin.student_classes.*', 'admin.mentorship-groups.*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
            <div class="flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.225-1.273-.639-1.756M17 20V5a2 2 0 00-2-2H9a2 2 0 00-2 2v15m7 0a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2z">
                    </path>
                </svg>
                <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Kesiswaan</span>
            </div>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="open" class="pl-10 pr-4 py-1 space-y-1 bg-gray-700/50">
            <a href="{{ route('admin.students.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.students.*') ? 'bg-gray-600' : '' }}">Database
                Siswa</a>
            <a href="{{ route('admin.classes.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.classes.*') ? 'bg-gray-600' : '' }}">Kelola
                Kelas</a>
            <a href="{{ route('admin.student_classes.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.student_classes.*') ? 'bg-gray-600' : '' }}">Manajemen
                Kelas</a>
            <a href="{{ route('admin.mentorship-groups.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.mentorship-groups.*') ? 'bg-gray-600' : '' }}">Kelompok
                Bimbingan</a>
        </div>
    </div>

    <!-- Dropdown: Data Master Kurikulum -->
    <div x-data="{ open: {{ request()->routeIs('admin.phases.*', 'admin.grade-levels.*', 'admin.subjects.*', 'admin.elements.*', 'admin.learning-outcomes.*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
            <div class="flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7l8-4 8 4m-8 4v10">
                    </path>
                </svg>
                <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Data
                    Master</span>
            </div>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="open" class="pl-10 pr-4 py-1 space-y-1 bg-gray-700/50">
            <a href="{{ route('admin.phases.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.phases.*') ? 'bg-gray-600' : '' }}">Kelola
                Fase</a>
            <a href="{{ route('admin.grade-levels.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.grade-levels.*') ? 'bg-gray-600' : '' }}">Kelola
                Tingkat Kelas</a>
            <a href="{{ route('admin.subjects.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.subjects.*') ? 'bg-gray-600' : '' }}">Kelola
                Mapel</a>
            <a href="{{ route('admin.elements.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.elements.*') ? 'bg-gray-600' : '' }}">Kelola
                Elemen</a>
            <a href="{{ route('admin.learning-outcomes.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.learning-outcomes.*') ? 'bg-gray-600' : '' }}">Kelola
                Capaian</a>
        </div>
    </div>
@endif

<!-- ==================== MENU GURU ==================== -->
@if (auth()->user()->role == 'guru')
    <!-- Dropdown: Perancangan Pembelajaran -->
    <div x-data="{ open: {{ request()->routeIs('teacher.learning-objectives.*', 'teacher.teaching-flows.*', 'teacher.lesson-plans.*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
            <div class="flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                <span class="ml-4"
                    x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Perancangan</span>
            </div>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="open" class="pl-10 pr-4 py-1 space-y-1 bg-gray-700/50">
            <a href="{{ route('teacher.learning-objectives.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.learning-objectives.*') ? 'bg-gray-600' : '' }}">Tujuan
                Pembelajaran</a>
            <a href="{{ route('teacher.teaching-flows.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.teaching-flows.*') ? 'bg-gray-600' : '' }}">Alur
                Tujuan Pembelajaran</a>
            <a href="{{ route('teacher.lesson-plans.start') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.lesson-plans.*') ? 'bg-gray-600' : '' }}">Rencana
                Pembelajaran</a>
            <a href="{{ route('teacher.gradebook.select') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.gradebook.*') ? 'bg-gray-600' : '' }}">Asesmen
                & Penilaian</a>
            <a href="{{ route('teacher.question-bank.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.question-bank.*') ? 'bg-gray-600' : '' }}">Bank
                Soal</a>
            <a href="{{ route('teacher.learning-objectives.index') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.kktp.*') ? 'bg-gray-600' : '' }}">Kelola
                KKTP</a>
        </div>
    </div>

    <!-- Dropdown: Perwalian -->
    @php
        $homeroomClass = Auth::user()->homeroomClass;
        $mentorshipGroup = Auth::user()->mentorshipGroup;
    @endphp
    @if ($homeroomClass || $mentorshipGroup)
        <div x-data="{ open: {{ request()->routeIs('teacher.homeroom.*', 'teacher.mentorship.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <div class="flex items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.225-1.273-.639-1.756M17 20V5a2 2 0 00-2-2H9a2 2 0 00-2 2v15m7 0a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2z">
                        </path>
                    </svg>
                    <span class="ml-4"
                        x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Perwalian</span>
                </div>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" class="pl-10 pr-4 py-1 space-y-1 bg-gray-700/50">
                @if ($homeroomClass)
                    <a href="{{ route('teacher.homeroom.index') }}"
                        class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.homeroom.*') ? 'bg-gray-600' : '' }}">Kelas
                        Wali ({{ $homeroomClass->name }})</a>
                    <a href="{{ route('teacher.report-cards.index') }}"
                        class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.report-cards.*') ? 'bg-gray-600' : '' }}">Laporan
                        Rapor</a>
                @endif
                @if ($mentorshipGroup)
                    <a href="{{ route('teacher.mentorship.index') }}"
                        class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('teacher.mentorship.*') ? 'bg-gray-600' : '' }}">Bimbingan
                        Wali</a>
                @endif
            </div>
        </div>
    @endif
@endif

<!-- ==================== MENU KEPALA SEKOLAH ==================== -->
@if (auth()->user()->role == 'kepala_sekolah')
    <div x-data="{ open: {{ request()->routeIs('headmaster.monitoring.*', 'headmaster.report.*') ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
            <div class="flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span class="ml-4"
                    x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Supervisi</span>
            </div>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="open" class="pl-10 pr-4 py-1 space-y-1 bg-gray-700/50">
            <a href="{{ route('headmaster.monitoring.atp') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('headmaster.monitoring.atp') ? 'bg-gray-600' : '' }}">Monitoring
                ATP</a>
            <a href="{{ route('headmaster.monitoring.lessonPlans') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('headmaster.monitoring.lessonPlans') ? 'bg-gray-600' : '' }}">Monitoring
                Modul Ajar</a>
            <a href="{{ route('headmaster.report.atp') }}"
                class="block text-sm py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('headmaster.report.*') ? 'bg-gray-600' : '' }}">Laporan
                & Rekap</a>
        </div>
    </div>
@endif

<!-- ==================== MENU SISWA ==================== -->
@if (auth()->user()->role == 'siswa')
    <a href="{{ route('student.dashboard') }}"
        class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('student.dashboard') ? 'bg-gray-600' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Dasbor Saya</span>
    </a>
    <a href="{{ route('student.portfolio') }}"
        class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('student.portfolio') ? 'bg-gray-600' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
        <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Portofolio
            Nilai</span>
    </a>
    <a href="{{ route('student.learning-map') }}"
        class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('student.learning-map') ? 'bg-gray-600' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 16.382V5.618a1 1 0 00-1.447-.894L15 7m-6 13v-3m6 3v-3m0 0V7">
            </path>
        </svg>
        <span class="ml-4" x-show="document.getElementById('sidebar-wrapper').__x.$data.open">Peta Belajar</span>
    </a>
@endif
