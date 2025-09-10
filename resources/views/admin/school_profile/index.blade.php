<x-app-layout>
    <x-slot name="header">
        Profil Sekolah
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.school_profile.update') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Nama Sekolah -->
                <div>
                    <label for="school_name" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                    <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $settings['school_name'] ?? '') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- NPSN -->
                <div>
                    <label for="school_npsn" class="block text-sm font-medium text-gray-700">NPSN</label>
                    <input type="text" name="school_npsn" id="school_npsn" value="{{ old('school_npsn', $settings['school_npsn'] ?? '') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="school_address" class="block text-sm font-medium text-gray-700">Alamat Sekolah</label>
                    <textarea name="school_address" id="school_address" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('school_address', $settings['school_address'] ?? '') }}</textarea>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="school_phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" name="school_phone" id="school_phone" value="{{ old('school_phone', $settings['school_phone'] ?? '') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label for="school_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="school_email" id="school_email" value="{{ old('school_email', $settings['school_email'] ?? '') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Nama Kepala Sekolah -->
                <div class="md:col-span-2">
                    <label for="school_headmaster" class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                    <input type="text" name="school_headmaster" id="school_headmaster" value="{{ old('school_headmaster', $settings['school_headmaster'] ?? '') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Visi -->
                <div class="md:col-span-2">
                    <label for="school_vision" class="block text-sm font-medium text-gray-700">Visi</label>
                    <textarea name="school_vision" id="school_vision" rows="4" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('school_vision', $settings['school_vision'] ?? '') }}</textarea>
                </div>

                <!-- Misi -->
                <div class="md:col-span-2">
                    <label for="school_mission" class="block text-sm font-medium text-gray-700">Misi</label>
                    <textarea name="school_mission" id="school_mission" rows="4" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('school_mission', $settings['school_mission'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>