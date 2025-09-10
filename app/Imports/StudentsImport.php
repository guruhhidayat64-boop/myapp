<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // 1. Buat akun user baru untuk setiap baris
        $user = User::create([
            'name'     => $row['nama_lengkap'],
            'email'    => $row['nisn'] . '@sekolah.test',
            'role'     => 'siswa',
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat profil siswa dan tautkan
        return new Student([
            'user_id'      => $user->id,
            'name'         => $row['nama_lengkap'],
            'nisn'         => $row['nisn'],
            'gender'       => $row['jenis_kelamin'],
            'birth_place'  => $row['tempat_lahir'],
            'birth_date'   => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']),
            'address'      => $row['alamat'],
            'parent_name'  => $row['nama_orang_tua'],
            'parent_phone' => $row['kontak_orang_tua'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string',
            'nisn' => 'required|numeric|unique:students,nisn', // NISN wajib untuk email
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|numeric',
        ];
    }
}
