<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
