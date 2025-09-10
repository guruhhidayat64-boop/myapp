<x-app-layout>
    <x-slot name="header">
        Kalender Akademik
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <div id="calendar"></div>
    </div>

    <!-- Modal untuk Tambah/Edit Agenda -->
    <div id="event-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <h3 id="modal-title" class="text-lg font-semibold mb-4">Tambah Agenda</h3>
            <form id="event-form">
                <input type="hidden" id="event-id">
                <div class="space-y-4">
                    <div>
                        <label for="event-title" class="block text-sm font-medium">Judul Agenda</label>
                        <input type="text" id="event-title" class="w-full mt-1" required>
                    </div>
                    <div>
                        <label for="event-start" class="block text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" id="event-start" class="w-full mt-1" required>
                    </div>
                    <div>
                        <label for="event-color" class="block text-sm font-medium">Kategori</label>
                        <select id="event-color" class="w-full mt-1">
                            <option value="#3b82f6">Kegiatan Sekolah (Biru)</option>
                            <option value="#ef4444">Hari Libur (Merah)</option>
                            <option value="#8b5cf6">Jadwal Ujian (Ungu)</option>
                            <option value="#f97316">Batas Waktu (Oranye)</option>
                            @if (auth()->user()->role == 'guru')
                                <option value="#10b981">Agenda Pribadi (Hijau)</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <div>
                        <button type="button" id="delete-event-btn"
                            class="px-4 py-2 text-sm text-white bg-red-600 rounded-md hidden">Hapus</button>
                    </div>
                    <div class="flex gap-4">
                        <button type="button" id="close-modal-btn"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-md">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const modal = document.getElementById('event-modal');
                const modalTitle = document.getElementById('modal-title');
                const eventForm = document.getElementById('event-form');
                const eventIdInput = document.getElementById('event-id');
                const eventTitleInput = document.getElementById('event-title');
                const eventStartInput = document.getElementById('event-start');
                const eventColorInput = document.getElementById('event-color');
                const deleteBtn = document.getElementById('delete-event-btn');
                const closeBtn = document.getElementById('close-modal-btn');
                const userRole = "{{ Auth::user()->role }}";

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    events: "{{ route('calendar.events') }}",
                    editable: userRole === 'admin', // Hanya admin yang bisa drag-and-drop
                    selectable: true,
                    select: function(info) {
                        if (userRole === 'kepala_sekolah') return; // Kepsek tidak bisa buat agenda
                        openModal(info.startStr);
                    },
                    eventClick: function(info) {
                        if (userRole === 'kepala_sekolah') return;
                        openModal(info.event.startStr, info.event);
                    }
                });
                calendar.render();

                function openModal(date, event = null) {
                    eventForm.reset();
                    if (event) {
                        modalTitle.textContent = 'Edit Agenda';
                        eventIdInput.value = event.id;
                        eventTitleInput.value = event.title;
                        eventStartInput.value = event.startStr.split('T')[0];
                        eventColorInput.value = event.backgroundColor;
                        deleteBtn.classList.remove('hidden');
                    } else {
                        modalTitle.textContent = 'Tambah Agenda';
                        eventIdInput.value = '';
                        eventStartInput.value = date;
                        deleteBtn.classList.add('hidden');
                    }
                    modal.classList.remove('hidden');
                }

                function closeModal() {
                    modal.classList.add('hidden');
                }

                closeBtn.addEventListener('click', closeModal);
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) closeModal();
                });

                eventForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const id = eventIdInput.value;
                    const url = id ? `/calendar/events/${id}` : "{{ route('calendar.events.store') }}";
                    const method = id ? 'PUT' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: eventTitleInput.value,
                            start: eventStartInput.value,
                            color: eventColorInput.value,
                        })
                    });

                    if (response.ok) {
                        calendar.refetchEvents();
                        closeModal();
                    } else {
                        alert('Gagal menyimpan agenda.');
                    }
                });

                deleteBtn.addEventListener('click', async function() {
                    const id = eventIdInput.value;
                    if (id && confirm('Anda yakin ingin menghapus agenda ini?')) {
                        const response = await fetch(`/calendar/events/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        if (response.ok) {
                            calendar.refetchEvents();
                            closeModal();
                        } else {
                            alert('Gagal menghapus agenda.');
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
