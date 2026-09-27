<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'id_pendaftaran',
        'id_pasien',
        'id_dokter',
        'tanggal_tindakan',
        'berat_badan',
        'tensi_darah',
        'riwayat_alergi_obat',
        'kondisi_anatomis',
        'metode_digunakan',
        'catatan_tindakan',
        'resep_obat',
        'instruksi_pasca_sunat',
        'tanggal_kontrol_ulang',
    ];

    protected $casts = [
        'tanggal_tindakan' => 'datetime',
        'tanggal_kontrol_ulang' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }
}
