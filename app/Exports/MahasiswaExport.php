<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    public function collection()
    {
        return Mahasiswa::with(['krs.jadwal.mataKuliah'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'Jenis Kelamin',
            'Angkatan',
            'Semester',
            'No. HP',
            'Alamat',
        ];
    }

    public function map($m): array
    {
        static $no = 0;
        $no++;

        $semester = $m->krs->first()?->jadwal?->mataKuliah?->semester ?? '-';

        return [
            $no,
            $m->nim,
            $m->nama,
            $m->jk === 'L' ? 'Laki-laki' : 'Perempuan',
            $m->angkatan,
            $semester,
            $m->no_hp ?? '-',
            $m->alamat ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris header (baris 1) bold + background biru
            1 => [
                'font'    => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'    => ['fillType' => 'solid', 'startColor' => ['rgb' => '6366F1']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}