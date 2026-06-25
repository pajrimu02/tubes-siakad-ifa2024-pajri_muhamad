<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MahasiswaImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnError
{
    use SkipsErrors;

    /**
     * Format kolom Excel yang diharapkan (sesuai heading row):
     * nim | nama | jk | angkatan | no_hp | alamat
     */
    public function model(array $row)
    {
        // Skip jika NIM sudah ada
        if (Mahasiswa::where('nim', $row['nim'])->exists()) {
            return null;
        }

        return DB::transaction(function () use ($row) {
            $user = User::create([
                'name'     => $row['nama'],
                'email'    => $row['nim'] . '@mahasiswa.ac.id',
                'password' => Hash::make($row['nim']),
            ]);

            $user->assignRole('mahasiswa');

            return new Mahasiswa([
                'user_id'  => $user->id,
                'nim'      => $row['nim'],
                'nama'     => $row['nama'],
                'jk'       => strtoupper($row['jk']),      // L atau P
                'angkatan' => $row['angkatan'],
                'no_hp'    => $row['no_hp']  ?? null,
                'alamat'   => $row['alamat'] ?? null,
            ]);
        });
    }

    public function rules(): array
    {
        return [
            'nim'      => 'required',
            'nama'     => 'required',
            'jk'       => 'required|in:L,P,l,p',
            'angkatan' => 'required|digits:4',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nim.required'      => 'Kolom NIM wajib diisi.',
            'nama.required'     => 'Kolom Nama wajib diisi.',
            'jk.in'             => 'Kolom JK harus berisi L atau P.',
            'angkatan.digits'   => 'Angkatan harus 4 digit.',
        ];
    }
}