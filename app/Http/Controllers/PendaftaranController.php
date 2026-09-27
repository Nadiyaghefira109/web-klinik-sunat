<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\PaketSunat;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function create(Request $request)
    {
        $pakets = PaketSunat::where('is_active', 1)->get();
        $dokters = Dokter::where('status', 'aktif')->get();
        $selectedPaketId = $request->query('paket');

        return view('public.daftar', compact('pakets', 'dokters', 'selectedPaketId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ortu_wali' => 'required|string|max:100',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'id_paket' => 'required|exists:paket_sunat,id',
            'id_dokter' => 'required|exists:dokter,id',
            'jenis_layanan' => 'required|in:klinik,home_care',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072',
        ]);

        return DB::transaction(function () use ($request) {
            $tglLahir = Carbon::parse($request->tanggal_lahir);
            $now = Carbon::now();
            $usiaTahun = $tglLahir->diffInYears($now);
            $usiaBulan = $tglLahir->diffInMonths($now) % 12;

            // 1. Simpan / Perbarui Pasien
            $nik = $request->input('nik') ?: null;
            $pasien = null;
            if ($nik) {
                $pasien = Pasien::where('nik', $nik)->first();
            }

            if (!$pasien) {
                // Generate No RM: RM-YYYYMM-XXX
                $prefixRm = 'RM-' . date('Ym') . '-';
                $lastRm = Pasien::where('no_rm', 'LIKE', $prefixRm . '%')
                    ->orderBy('id', 'desc')
                    ->value('no_rm');
                $seqRm = 1;
                if ($lastRm) {
                    $seqRm = (int) substr($lastRm, -3) + 1;
                }
                $noRm = $prefixRm . str_pad($seqRm, 3, '0', STR_PAD_LEFT);

                $pasien = Pasien::create([
                    'no_rm' => $noRm,
                    'nik' => $nik,
                    'nama_pasien' => $request->nama_pasien,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'usia_tahun' => $usiaTahun,
                    'usia_bulan' => $usiaBulan,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nama_ortu_wali' => $request->nama_ortu_wali,
                    'no_wa' => $request->no_wa,
                    'alamat_lengkap' => $request->alamat_lengkap,
                    'catatan_riwayat_penyakit' => $request->input('catatan_riwayat_penyakit'),
                ]);
            }

            // 2. Ambil Paket & Hitung Keuangan
            $paket = PaketSunat::findOrFail($request->id_paket);
            $totalBiaya = $paket->harga;
            $nominalDp = $paket->nominal_dp;
            $sisaPembayaran = max(0, $totalBiaya - $nominalDp);

            // 3. Generate No Registrasi
            $prefixReg = 'REG-' . date('Ymd') . '-';
            $lastReg = Pendaftaran::where('no_registrasi', 'LIKE', $prefixReg . '%')
                ->orderBy('id', 'desc')
                ->value('no_registrasi');
            $seqReg = 1;
            if ($lastReg) {
                $seqReg = (int) substr($lastReg, -3) + 1;
            }
            $noRegistrasi = $prefixReg . str_pad($seqReg, 3, '0', STR_PAD_LEFT);

            // 4. Generate No Antrean Harian
            $isHomeCare = ($request->jenis_layanan === 'home_care');
            $antreanPrefix = $isHomeCare ? 'H-' : 'A-';
            $lastAntrean = Pendaftaran::where('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->where('no_antrean', 'LIKE', $antreanPrefix . '%')
                ->orderBy('id', 'desc')
                ->value('no_antrean');
            $seqAntrean = 1;
            if ($lastAntrean) {
                $seqAntrean = (int) substr($lastAntrean, 2) + 1;
            }
            $noAntrean = $antreanPrefix . str_pad($seqAntrean, 2, '0', STR_PAD_LEFT);

            // 5. Penanganan Bukti Transfer
            $buktiFilename = null;
            $statusPembayaran = 'belum_bayar';
            $tglPembayaranDp = null;

            if ($request->hasFile('bukti_pembayaran') && $request->file('bukti_pembayaran')->isValid()) {
                $file = $request->file('bukti_pembayaran');
                $ext = $file->getClientOriginalExtension();
                $buktiFilename = 'DP_' . $noRegistrasi . '_' . time() . '.' . $ext;
                $destinationPath = public_path('assets/uploads/bukti_dp');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $buktiFilename);
                $statusPembayaran = 'menunggu_verifikasi';
                $tglPembayaranDp = Carbon::now();
            }

            // 6. Simpan Pendaftaran
            $pendaftaran = Pendaftaran::create([
                'no_registrasi' => $noRegistrasi,
                'no_antrean' => $noAntrean,
                'id_pasien' => $pasien->id,
                'id_paket' => $paket->id,
                'id_dokter' => $request->id_dokter,
                'jenis_layanan' => $request->jenis_layanan,
                'alamat_home_care' => $isHomeCare ? ($request->input('alamat_home_care') ?: $request->alamat_lengkap) : null,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jam_kunjungan' => $request->jam_kunjungan,
                'keluhan_awal' => $request->input('keluhan_awal'),
                'total_biaya' => $totalBiaya,
                'nominal_dp' => $nominalDp,
                'sisa_pembayaran' => $sisaPembayaran,
                'metode_pembayaran' => $request->input('metode_pembayaran', 'Transfer Bank'),
                'bukti_pembayaran' => $buktiFilename,
                'tgl_pembayaran_dp' => $tglPembayaranDp,
                'status_pelayanan' => 'menunggu',
                'status_pembayaran' => $statusPembayaran,
            ]);

            return redirect()->route('tiket', ['no_registrasi' => $noRegistrasi])
                ->with('success', 'Pendaftaran sirkumsisi berhasil disimpan! Silakan simpan nomor tiket antrean Anda.');
        });
    }

    public function tiket($no_registrasi)
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->where('no_registrasi', $no_registrasi)
            ->firstOrFail();

        return view('public.tiket', compact('pendaftaran'));
    }

    public function uploadBukti(Request $request, $no_registrasi)
    {
        $pendaftaran = Pendaftaran::where('no_registrasi', $no_registrasi)->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3072',
            'metode_pembayaran' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('bukti_pembayaran') && $request->file('bukti_pembayaran')->isValid()) {
            $file = $request->file('bukti_pembayaran');
            $ext = $file->getClientOriginalExtension();
            $buktiFilename = 'DP_' . $pendaftaran->no_registrasi . '_' . time() . '.' . $ext;
            $destinationPath = public_path('assets/uploads/bukti_dp');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $buktiFilename);

            $pendaftaran->update([
                'bukti_pembayaran' => $buktiFilename,
                'tgl_pembayaran_dp' => Carbon::now(),
                'status_pembayaran' => 'menunggu_verifikasi',
                'metode_pembayaran' => $request->input('metode_pembayaran', $pendaftaran->metode_pembayaran ?: 'Transfer Bank'),
            ]);

            return redirect()->route('tiket', ['no_registrasi' => $no_registrasi])
                ->with('success', 'Bukti pembayaran DP berhasil diunggah! Petugas akan segera memverifikasi.');
        }

        return redirect()->route('tiket', ['no_registrasi' => $no_registrasi])
            ->with('error', 'Gagal mengunggah berkas bukti pembayaran.');
    }
}
