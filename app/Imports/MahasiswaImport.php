<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Imports\MahasiswaImport;

class MahasiswaImport implements ToModel
{
    public function model(array $row)
    {
        return new Mahasiswa([
            'nim' => $row[0],
            'nama' => $row[1],
            'jk' => $row[2],
            'angkatan' => $row[3],
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(
            new MahasiswaImport,
            $request->file('file')
        );

        return redirect()
                ->back()
                ->with('success','Import berhasil');
    }
}
