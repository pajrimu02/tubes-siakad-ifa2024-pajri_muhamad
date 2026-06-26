<?php

namespace App\Imports;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class KrsImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    /**
     * Kolom yang diharapkan di file Excel:
     * nim | kode_mk | semester | tahun_akademik
     *
     * Kolom nim dipakai untuk lookup mahasiswa_id.
     * Kolom kode_mk dipakai untuk lookup jadwal_id via mataKuliah.
     */
    public function model(array $row): ?Krs
    {
        $nim    = trim($row['nim']    ?? '');
        $kodeMk = trim($row['kode_mk'] ?? '');

        if (! $nim || ! $kodeMk) return null;

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        if (! $mahasiswa) return null;

        // Cari jadwal pertama yang punya mataKuliah dengan kode ini
        $jadwal = Jadwal::whereHas('mataKuliah', fn($q) =>
            $q->where('kode_mk', $kodeMk)
        )->first();

        if (! $jadwal) return null;

        $semester       = (int) ($row['semester'] ?? 0);
        $tahunAkademik  = trim($row['tahun_akademik'] ?? '');

        // Hindari duplikat
        $exists = Krs::where('mahasiswa_id', $mahasiswa->id)
                     ->where('jadwal_id', $jadwal->id)
                     ->where('tahun_akademik', $tahunAkademik)
                     ->exists();

        if ($exists) return null;

        return new Krs([
            'mahasiswa_id'   => $mahasiswa->id,
            'jadwal_id'      => $jadwal->id,
            'semester'       => $semester,
            'tahun_akademik' => $tahunAkademik,
        ]);
    }
}