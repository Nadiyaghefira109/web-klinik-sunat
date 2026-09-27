<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    private function getDokter()
    {
        $user = Auth::user();
        return Dokter::where('user_id', $user->id)->first() ?? Dokter::first();
    }

    public function dashboard()
    {
        $dokter = $this->getDokter();
        $today = Carbon::today()->toDateString();

        $antreanHariIni = Pendaftaran::with(['pasien', 'paket'])
            ->where('tanggal_kunjungan', $today)
            ->where('id_dokter', $dokter->id)
            ->orderBy('no_antrean', 'asc')
            ->get();

        $selesaiHariIni = $antreanHariIni->where('status_pelayanan', 'selesai')->count();
        $menungguHariIni = $antreanHariIni->whereIn('status_pelayanan', ['menunggu', 'terkonfirmasi', 'tindakan'])->count();

        return view('dokter.dashboard', compact('dokter', 'antreanHariIni', 'selesaiHariIni', 'menungguHariIni', 'today'));
    }

    public function antrean()
    {
        $dokter = $this->getDokter();
        $today = Carbon::today()->toDateString();

        $antreans = Pendaftaran::with(['pasien', 'paket', 'rekamMedis'])
            ->where('tanggal_kunjungan', $today)
            ->where('id_dokter', $dokter->id)
            ->orderBy('no_antrean', 'asc')
            ->get();

        return view('dokter.antrean', compact('dokter', 'antreans', 'today'));
    }

    public function rekamMedis($id_pendaftaran)
    {
        $dokter = $this->getDokter();
        $pendaftaran = Pendaftaran::with(['pasien', 'paket', 'rekamMedis'])->findOrFail($id_pendaftaran);
        $rekamMedis = $pendaftaran->rekamMedis;

        return view('dokter.rekam_medis', compact('dokter', 'pendaftaran', 'rekamMedis'));
    }

    public function storeRekamMedis(Request $request, $id_pendaftaran)
    {
        $dokter = $this->getDokter();
        $pendaftaran = Pendaftaran::findOrFail($id_pendaftaran);

        $request->validate([
            'metode_digunakan' => 'required|string',
            'kondisi_anatomis' => 'nullable|string',
            'catatan_tindakan' => 'required|string',
            'resep_obat' => 'required|string',
            'instruksi_pasca_sunat' => 'nullable|string',
            'tanggal_kontrol_ulang' => 'nullable|date',
        ]);

        RekamMedis::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id],
            [
                'id_pasien' => $pendaftaran->id_pasien,
                'id_dokter' => $dokter->id,
                'tanggal_tindakan' => Carbon::now(),
                'berat_badan' => $request->input('berat_badan'),
                'tensi_darah' => $request->input('tensi_darah'),
                'riwayat_alergi_obat' => $request->input('riwayat_alergi_obat'),
                'kondisi_anatomis' => $request->input('kondisi_anatomis'),
                'metode_digunakan' => $request->input('metode_digunakan'),
                'catatan_tindakan' => $request->input('catatan_tindakan'),
                'resep_obat' => $request->input('resep_obat'),
                'instruksi_pasca_sunat' => $request->input('instruksi_pasca_sunat'),
                'tanggal_kontrol_ulang' => $request->input('tanggal_kontrol_ulang'),
            ]
        );

        $pendaftaran->update(['status_pelayanan' => 'selesai']);

        return redirect()->route('dokter.antrean')
            ->with('success', "Rekam medis pasien {$pendaftaran->no_registrasi} berhasil disimpan dan tindakan selesai!");
    }

    public function cetakRme($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'paket', 'dokter', 'rekamMedis'])->findOrFail($id_pendaftaran);
        return view('dokter.cetak_rme', compact('pendaftaran'));
    }
}
