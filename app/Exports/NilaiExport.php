<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class NilaiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected ?string $kategori;
    protected int $no = 0;

    public function __construct(?string $kategori = null)
    {
        $this->kategori = $kategori;
    }

    public function query()
    {
        $query = Nilai::with(['mahasiswa', 'matakuliah']);

        if ($this->kategori) {
            $query->where('nilai', strtoupper($this->kategori));
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return ['No', 'NIM', 'Nama Mahasiswa', 'Kode MK', 'Mata Kuliah', 'SKS', 'Semester', 'Grade', 'Angka', 'Keterangan'];
    }

    public function map($row): array
    {
        $this->no++;
        return [
            $this->no,
            $row->mahasiswa?->nim,
            $row->mahasiswa?->nama,
            $row->matakuliah?->kode_mk,
            $row->matakuliah?->nama_mk,
            $row->matakuliah?->sks,
            'Semester ' . $row->semester,
            $row->nilai,
            $row->angka,
            $row->keterangan,
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