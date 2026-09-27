<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'nama_dokter',
        'spesialisasi',
        'no_hp',
        'hari_praktik',
        'jam_praktik',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_dokter');
    }
}
