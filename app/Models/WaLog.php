<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaLog extends Model
{
    use HasFactory;

    protected $table = 'wa_logs';

    public $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'no_wa_tujuan',
        'jenis_notifikasi',
        'isi_pesan',
        'status_kirim',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }
}
