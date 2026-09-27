<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketSunat extends Model
{
    use HasFactory;

    protected $table = 'paket_sunat';

    protected $fillable = [
        'nama_paket',
        'kategori_layanan',
        'metode_sunat',
        'harga',
        'nominal_dp',
        'deskripsi',
        'keunggulan',
        'fasilitas_include',
        'gambar',
        'is_active',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_paket');
    }

    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getNominalDpFormatAttribute()
    {
        return 'Rp ' . number_format($this->nominal_dp, 0, ',', '.');
    }
}
