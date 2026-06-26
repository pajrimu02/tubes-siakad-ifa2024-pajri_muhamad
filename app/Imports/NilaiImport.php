<?php

namespace App\Imports;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class NilaiImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    /**
     * Kolom Excel yang diharapkan:
     * nim | kode_mk | semester | nilai | angka | keterangan
     */
    public function model(array $row): ?Nilai
    {
        $nim    = trim($row['nim']     ?? '');
        $kodeMk = trim($row['kode_mk'] ?? '');
        $grade  = strtoupper(trim($row['nilai'] ?? ''));

        if (! $nim || ! $kodeMk || ! in_array($grade, ['A','B','C','D','E'])) return null;

        $mahasiswa  = Mahasiswa::where('nim', $nim)->first();
        $matakuliah = Matakuliah::where('kode_mk', $kodeMk)->first();

        if (! $mahasiswa || ! $matakuliah) return null;

        return new Nilai([
            'mahasiswa_id'  => $mahasiswa->id,
            'matakuliah_id' => $matakuliah->id,
            'semester'      => (int) ($row['semester']   ?? 1),
            'nilai'         => $grade,
            'angka'         => $row['angka']      ?? null,
            'keterangan'    => $row['keterangan'] ?? null,
        ]);
    }
}