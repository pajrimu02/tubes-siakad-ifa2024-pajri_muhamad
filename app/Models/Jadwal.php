<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'mata_kuliah_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kelas',
        'ruangan',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function krs()
    {
        return $this->hasMany(Krs::class);
    }

    // 🔥 TAMBAHAN AMAN (biar filtering gampang nanti)
    public function scopeKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}