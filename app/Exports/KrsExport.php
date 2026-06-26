<?php

namespace App\Exports;

use App\Models\Krs;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KrsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected ?string $tipe;
    protected int $no = 0;

    public function __construct(?string $tipe = null)
    {
        $this->tipe = $tipe;
    }

    public function query()
    {
        $query = Krs::with(['mahasiswa', 'jadwal.mataKuliah', 'jadwal.dosen']);

        if ($this->tipe === 'ganjil') {
            $query->whereIn('semester', [1, 3, 5, 7]);
        } elseif ($this->tipe === 'genap') {
            $query->whereIn('semester', [2, 4, 6, 8]);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama Mahasiswa',
            'Kode MK',
            'Mata Kuliah',
            'SKS',
            'Dosen',
            'Hari',
            'Jam',
            'Ruangan',
            'Semester',
            'Tahun Akademik',
        ];
    }

    public function map($row): array
    {
        $this->no++;
        $jadwal = $row->jadwal;
        $mk     = $jadwal?->mataKuliah;
        $dosen  = $jadwal?->dosen;

        return [
            $this->no,
            $row->mahasiswa?->nim,
            $row->mahasiswa?->nama,
            $mk?->kode_mk,
            $mk?->nama_mk,
            $mk?->sks,
            $dosen?->nama,
            $jadwal?->hari,
            ($jadwal?->jam_mulai ?? '') . ' – ' . ($jadwal?->jam_selesai ?? ''),
            $jadwal?->ruangan,
            'Semester ' . $row->semester,
            $row->tahun_akademik,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF6366F1']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}