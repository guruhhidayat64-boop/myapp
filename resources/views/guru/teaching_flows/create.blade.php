        <x-app-layout>
            <x-slot name="header">
                Buat Wadah Alur Tujuan Pembelajaran
            </x-slot>

            <div class="p-6 bg-white rounded-md shadow-md">
                <form action="{{ route('teacher.teaching-flows.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Alur Pembelajaran</label>
                            <input type="text" name="name" id="name" required class="block w-full mt-1" placeholder="Contoh: ATP Matematika Kelas 7 - Semester Ganjil">
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="subject_id" class="block text-sm font-medium">Mata Pelajaran</label>
                                <select name="subject_id" id="subject_id" required class="block w-full mt-1">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="grade_level_id" class="block text-sm font-medium">Tingkat Kelas</label>
                                <select name="grade_level_id" id="grade_level_id" required class="block w-full mt-1">
                                    <option value="">-- Pilih Tingkat Kelas --</option>
                                    @foreach($gradeLevels as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium">Deskripsi (Opsional)</label>
                            <textarea name="description" id="description" rows="3" class="block w-full mt-1"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Lanjutkan & Susun Alur
                        </button>
                    </div>
                </form>
            </div>
        </x-app-layout>
        