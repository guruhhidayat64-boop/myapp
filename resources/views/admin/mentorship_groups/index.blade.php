<x-app-layout>
    <x-slot name="header">
        Manajemen Kelompok Bimbingan Guru Wali
    </x-slot>

    <div class="space-y-8">
        @if (session('success'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">{!! session('success') !!}</div>
        @endif

        <!-- Panel 1: Buat Kelompok & Daftar Kelompok -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Buat Kelompok Baru</h3>
                <form action="{{ route('admin.mentorship-groups.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium">Nama Kelompok</label>
                            <input type="text" name="name" id="name" required class="block w-full mt-1"
                                placeholder="Contoh: Kelompok Angkatan 2025-A">
                        </div>
                        <div>
                            <label for="user_id" class="block text-sm font-medium">Pilih Guru Wali</label>
                            <select name="user_id" id="user_id" required class="block w-full mt-1">
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($availableTeachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Buat
                                Kelompok</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-2 p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Daftar Kelompok Bimbingan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Kelompok</th>
                                <th class="px-4 py-2 text-left">Guru Wali</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($groups as $group)
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ $group->name }}</td>
                                    <td class="px-4 py-3">{{ $group->mentor->name }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('admin.mentorship-groups.destroy', $group) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus kelompok ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-400">Belum ada kelompok
                                        bimbingan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel 2: Manajemen Anggota Kelompok -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Manajemen Anggota Kelompok</h3>
            <form action="{{ route('admin.mentorship-groups.index') }}" method="GET"
                class="flex items-end gap-4 mb-6">
                <div>
                    <label for="group_id" class="block text-sm font-medium">Pilih Kelompok untuk Dikelola</label>
                    <select name="group_id" id="group_id" required class="block w-full mt-1">
                        <option value="">-- Pilih Kelompok --</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" @selected(request('group_id') == $group->id)>{{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Tampilkan
                    Anggota</button>
            </form>

            @if ($selectedGroup)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold mb-2">Siswa Belum Punya Guru Wali</h4>
                        <div class="max-h-96 overflow-y-auto border rounded-md p-2">
                            @forelse($studentsNotInGroup as $student)
                                <div class="flex justify-between items-center p-2 hover:bg-gray-50">
                                    <span>{{ $student->name }}</span>
                                    <form action="{{ route('admin.mentorship-groups.assign') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="group_id" value="{{ $selectedGroup->id }}">
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <button type="submit" class="text-sm text-green-600">Tambahkan &rarr;</button>
                                    </form>
                                </div>
                            @empty
                                <p class="p-4 text-center text-gray-400">Semua siswa sudah memiliki Guru Wali.</p>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Anggota Kelompok: {{ $selectedGroup->name }}</h4>
                        <div class="max-h-96 overflow-y-auto border rounded-md p-2">
                            @forelse($studentsInGroup as $student)
                                <div class="flex justify-between items-center p-2 hover:bg-gray-50">
                                    <span>{{ $student->name }}</span>
                                    <form action="{{ route('admin.mentorship-groups.unassign') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="group_id" value="{{ $selectedGroup->id }}">
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <button type="submit" class="text-sm text-red-600">&larr; Keluarkan</button>
                                    </form>
                                </div>
                            @empty
                                <p class="p-4 text-center text-gray-400">Belum ada anggota.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
