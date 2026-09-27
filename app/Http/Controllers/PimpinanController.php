<?php

namespace App\Http\Controllers;

use App\Models\PaketSunat;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();
        $thisMonth = Carbon::now()->format('Y-m');

        // Total pendapatan
        $totalPendapatan = Pendaftaran::whereIn('status_pembayaran', ['dp_lunas', 'lunas'])
            ->selectRaw("SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_biaya ELSE nominal_dp END) as total")
            ->value('total') ?? 0;

        $pendapatanBulanIni = Pendaftaran::whereIn('status_pembayaran', ['dp_lunas', 'lunas'])
            ->where('tanggal_kunjungan', 'LIKE', "{$thisMonth}%")
            ->selectRaw("SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_biaya ELSE nominal_dp END) as total")
            ->value('total') ?? 0;

        $totalPasien = Pendaftaran::where('status_pelayanan', 'selesai')->count();
        $layananKlinik = Pendaftaran::where('jenis_layanan', 'klinik')->count();
        $layananHomeCare = Pendaftaran::where('jenis_layanan', 'home_care')->count();

        // Tren Metode
        $metodeStats = DB::table('pendaftaran')
            ->join('paket_sunat', 'pendaftaran.id_paket', '=', 'paket_sunat.id')
            ->select('paket_sunat.metode_sunat', DB::raw('count(*) as total'))
            ->groupBy('paket_sunat.metode_sunat')
            ->get();

        $transaksiTerbaru = Pendaftaran::with(['pasien', 'paket'])
            ->whereIn('status_pembayaran', ['dp_lunas', 'lunas'])
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        return view('pimpinan.dashboard', compact(
            'totalPendapatan',
            'pendapatanBulanIni',
            'totalPasien',
            'layananKlinik',
            'layananHomeCare',
            'metodeStats',
            'transaksiTerbaru'
        ));
    }

    public function laporan(Request $request)
    {
        $tglMulai = $request->query('tgl_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tglSelesai = $request->query('tgl_selesai', Carbon::now()->endOfMonth()->toDateString());

        $laporans = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->whereBetween('tanggal_kunjungan', [$tglMulai, $tglSelesai])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        $totalPendapatan = 0;
        $totalDpMasuk = 0;
        $totalPelunasan = 0;

        foreach ($laporans as $item) {
            if ($item->status_pembayaran === 'lunas') {
                $totalPendapatan += $item->total_biaya;
                $totalPelunasan += $item->total_biaya;
            } elseif ($item->status_pembayaran === 'dp_lunas') {
                $totalPendapatan += $item->nominal_dp;
                $totalDpMasuk += $item->nominal_dp;
            }
        }

        return view('pimpinan.laporan', compact(
            'laporans',
            'tglMulai',
            'tglSelesai',
            'totalPendapatan',
            'totalDpMasuk',
            'totalPelunasan'
        ));
    }
}
