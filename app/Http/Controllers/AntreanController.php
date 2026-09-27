<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function cekAntrean(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $q = $request->query('q');

        // Antrean hari ini
        $antreanHariIni = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->where('tanggal_kunjungan', $today)
            ->whereIn('status_pelayanan', ['menunggu', 'terkonfirmasi', 'tindakan'])
            ->orderByRaw("FIELD(status_pelayanan, 'tindakan', 'terkonfirmasi', 'menunggu')")
            ->orderBy('no_antrean', 'asc')
            ->get();

        // Antrean sedang tindakan saat ini
        $antreanSekarang = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->where('tanggal_kunjungan', $today)
            ->where('status_pelayanan', 'tindakan')
            ->first();

        // Hasil pencarian registrasi jika ada query q
        $searchResult = null;
        if ($q) {
            $searchResult = Pendaftaran::with(['pasien', 'paket', 'dokter'])
                ->where('no_registrasi', 'LIKE', "%{$q}%")
                ->orWhereHas('pasien', function ($query) use ($q) {
                    $query->where('nama_pasien', 'LIKE', "%{$q}%")
                        ->orWhere('no_wa', 'LIKE', "%{$q}%");
                })
                ->orderBy('id', 'desc')
                ->first();
        }

        return view('public.cek_antrean', compact('antreanHariIni', 'antreanSekarang', 'searchResult', 'q', 'today'));
    }
}
