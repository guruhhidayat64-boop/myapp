    <x-app-layout>
        <x-slot name="header">
            Tambah Data Siswa Baru
        </x-slot>

        <div class="p-6 bg-white rounded-md shadow-md max-w-4xl mx-auto">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="nisn" class="block text-sm font-medium">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium">Jenis Kelamin</label>
                        <select name="gender" id="gender" required class="block w-full mt-1">
                            <option value="Laki-laki" @selected(old('gender') == 'Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('gender') == 'Perempuan')>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="birth_place" class="block text-sm font-medium">Tempat Lahir</label>
                        <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}"
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                            class="block w-full mt-1">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium">Alamat</label>
                        <textarea name="address" id="address" rows="3" class="block w-full mt-1">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label for="parent_name" class="block text-sm font-medium">Nama Orang Tua/Wali</label>
                        <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}"
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="parent_phone" class="block text-sm font-medium">Kontak Orang Tua/Wali</label>
                        <input type="text" name="parent_phone" id="parent_phone" value="{{ old('parent_phone') }}"
                            class="block w-full mt-1">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan
                        Data Siswa</button>
                </div>
            </form>
        </div>
    </x-app-layout>
