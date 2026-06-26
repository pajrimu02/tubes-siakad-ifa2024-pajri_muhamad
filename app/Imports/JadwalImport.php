<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class JadwalImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    /**
     * Kolom Excel: kode_mk | nidn_dosen | hari | jam_mulai | jam_selesai | kelas | ruangan
     */
    public function model(array $row)
    {
        $mk    = MataKuliah::where('kode_mk', $row['kode_mk'])->first();
        $dosen = Dosen::where('nidn', $row['nidn_dosen'])->first();

        if (!$mk || !$dosen) return null;

        return new Jadwal([
            'mata_kuliah_id' => $mk->id,
            'dosen_id'       => $dosen->id,
            'hari'           => $row['hari'],
            'jam_mulai'      => $row['jam_mulai'],
            'jam_selesai'    => $row['jam_selesai'],
            'kelas'          => strtoupper($row['kelas']),
            'ruangan'        => $row['ruangan'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_mk'    => 'required',
            'nidn_dosen' => 'required',
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'  => 'required',
            'jam_selesai'=> 'required',
            'kelas'      => 'required|in:A,B,C,D,E,F',
            'ruangan'    => 'required',
        ];
    }
}