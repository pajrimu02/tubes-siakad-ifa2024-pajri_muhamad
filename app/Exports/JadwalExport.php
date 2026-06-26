<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JadwalExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Jadwal::with(['mataKuliah', 'dosen'])
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
    }

    public function headings(): array
    {
        return ['No','Mata Kuliah','Kode MK','Dosen','Hari','Jam Mulai','Jam Selesai','Kelas','Ruangan'];
    }

    public function map($j): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $j->mataKuliah?->nama_mk ?? '-',
            $j->mataKuliah?->kode_mk ?? '-',
            $j->dosen?->nama ?? '-',
            $j->hari,
            $j->jam_mulai,
            $j->jam_selesai,
            $j->kelas,
            $j->ruangan,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '6366F1']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}