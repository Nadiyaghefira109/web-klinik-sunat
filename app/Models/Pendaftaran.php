<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'no_registrasi',
        'no_antrean',
        'id_pasien',
        'id_paket',
        'id_dokter',
        'jenis_layanan',
        'alamat_home_care',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'keluhan_awal',
        'total_biaya',
        'nominal_dp',
        'sisa_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'tgl_pembayaran_dp',
        'status_pelayanan',
        'status_pembayaran',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'tgl_pembayaran_dp' => 'datetime',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function paket()
    {
        return $this->belongsTo(PaketSunat::class, 'id_paket');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'id_pendaftaran');
    }

    public function waLogs()
    {
        return $this->hasMany(WaLog::class, 'id_pendaftaran');
    }
}
