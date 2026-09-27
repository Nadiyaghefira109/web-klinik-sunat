<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nik',
        'nama_pasien',
        'tanggal_lahir',
        'usia_tahun',
        'usia_bulan',
        'jenis_kelamin',
        'nama_ortu_wali',
        'no_wa',
        'alamat_lengkap',
        'catatan_riwayat_penyakit',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_pasien');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_pasien');
    }
}
