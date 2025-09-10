<x-app-layout>
    <x-slot name="header">
        Database Siswa
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">{!! session('success') !!}</div>
        @endif
        @if (session('error'))
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">{!! session('error') !!}</div>
        @endif

        <!-- ==================== PANEL IMPOR BARU ==================== -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Impor Data Siswa dari Excel</h3>
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data"
                class="flex items-center gap-4">
                @csrf
                <input type="file" name="file" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <button type="submit"
                    class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700 whitespace-nowrap">Impor
                    Data</button>
            </form>
            <p class="mt-2 text-xs text-gray-500">
                Unduh <a href="{{ route('admin.students.downloadTemplate') }}"
                    class="text-blue-600 hover:underline font-semibold">template Excel</a> untuk memastikan format data
                sudah benar.
            </p>
        </div>
        <!-- ========================================================== -->

        <div class="p-6 bg-white rounded-md shadow-md">
            <div class="mb-4">
                <a href="{{ route('admin.students.create') }}"
                    class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    + Tambah Siswa (Manual)
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Siswa</th>
                            <th class="px-6 py-3 text-left">NISN</th>
                            <th class="px-6 py-3 text-left">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($students as $student)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $student->name }}</td>
                                <td class="px-6 py-4">{{ $student->nisn ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $student->gender }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus data siswa ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $students->links() }}</div>
        </div>
    </div>
</x-app-layout>
