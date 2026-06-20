<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;

class MahasiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mahasiswa::all();
    }

    public function exportExcel()
    {
        return Excel::download(
            new MahasiswaExport,
            'mahasiswa.xlsx'
        );
    }
}
