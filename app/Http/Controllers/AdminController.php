<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\PaketSunat;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\WaLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        $totalPasien = Pasien::count();
        $totalAntreanHariIni = Pendaftaran::where('tanggal_kunjungan', $today)->count();
        $menungguVerifikasi = Pendaftaran::where('status_pembayaran', 'menunggu_verifikasi')->count();
        $totalOmzet = Pendaftaran::whereIn('status_pembayaran', ['dp_lunas', 'lunas'])
            ->selectRaw("SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_biaya ELSE nominal_dp END) as total")
            ->value('total') ?? 0;

        $pendaftaranTerbaru = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->orderBy('id', 'desc')
            ->limit(7)
            ->get();

        $antreanHariIni = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->where('tanggal_kunjungan', $today)
            ->orderBy('no_antrean', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalAntreanHariIni',
            'menungguVerifikasi',
            'totalOmzet',
            'pendaftaranTerbaru',
            'antreanHariIni',
            'today'
        ));
    }

    public function pendaftaran(Request $request)
    {
        $statusBayar = $request->query('status_bayar');
        $statusPelayanan = $request->query('status_pelayanan');
        $search = $request->query('q');

        $query = Pendaftaran::with(['pasien', 'paket', 'dokter']);

        if ($statusBayar) {
            $query->where('status_pembayaran', $statusBayar);
        }
        if ($statusPelayanan) {
            $query->where('status_pelayanan', $statusPelayanan);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_registrasi', 'LIKE', "%{$search}%")
                    ->orWhere('no_antrean', 'LIKE', "%{$search}%")
                    ->orWhereHas('pasien', function ($qp) use ($search) {
                        $qp->where('nama_pasien', 'LIKE', "%{$search}%")
                            ->orWhere('no_wa', 'LIKE', "%{$search}%");
                    });
            });
        }

        $pendaftarans = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.pendaftaran', compact('pendaftarans', 'statusBayar', 'statusPelayanan', 'search'));
    }

    public function verifikasiDp(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_pembayaran' => 'dp_lunas',
            'status_pelayanan' => 'terkonfirmasi',
            'catatan_admin' => $request->input('catatan_admin', 'DP telah diverifikasi dan disetujui oleh Admin.'),
        ]);

        return back()->with('success', "Pembayaran DP untuk {$pendaftaran->no_registrasi} berhasil diverifikasi!");
    }

    public function pelunasan(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_pembayaran' => 'lunas',
            'sisa_pembayaran' => 0,
            'catatan_admin' => ($pendaftaran->catatan_admin ? $pendaftaran->catatan_admin . " | " : "") . 'Lunas di kasir klinik.',
        ]);

        return back()->with('success', "Pelunasan transaksi {$pendaftaran->no_registrasi} berhasil disimpan!");
    }

    public function antrean()
    {
        $today = Carbon::today()->toDateString();
        $antreans = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->where('tanggal_kunjungan', $today)
            ->orderBy('no_antrean', 'asc')
            ->get();

        return view('admin.antrean', compact('antreans', 'today'));
    }

    public function panggilAntrean($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status_pelayanan' => 'tindakan']);

        return back()->with('success', "Nomor antrean {$pendaftaran->no_antrean} berhasil dipanggil ke ruang tindakan!");
    }

    public function paket()
    {
        $pakets = PaketSunat::orderBy('id', 'asc')->get();
        return view('admin.paket', compact('pakets'));
    }

    public function storePaket(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:150',
            'kategori_layanan' => 'required|in:anak,rumah,bayi,dewasa,premium',
            'metode_sunat' => 'required|in:circum_pen,mahdian_klem,gun_stapler,konvensional_laser',
            'harga' => 'required|numeric|min:0',
            'nominal_dp' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'keunggulan' => 'nullable|string',
            'fasilitas_include' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $gambarFilename = 'mahdian_klem.jpg'; // default fallback
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $file = $request->file('gambar');
            $gambarFilename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $gambarFilename);
        }

        PaketSunat::create([
            'nama_paket' => $request->nama_paket,
            'kategori_layanan' => $request->kategori_layanan,
            'metode_sunat' => $request->metode_sunat,
            'harga' => $request->harga,
            'nominal_dp' => $request->nominal_dp,
            'deskripsi' => $request->deskripsi,
            'keunggulan' => $request->keunggulan,
            'fasilitas_include' => $request->fasilitas_include,
            'gambar' => $gambarFilename,
            'is_active' => 1,
        ]);

        return back()->with('success', 'Paket khitan baru berhasil ditambahkan!');
    }

    public function updatePaket(Request $request, $id)
    {
        $paket = PaketSunat::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|string|max:150',
            'kategori_layanan' => 'required|in:anak,rumah,bayi,dewasa,premium',
            'metode_sunat' => 'required|in:circum_pen,mahdian_klem,gun_stapler,konvensional_laser',
            'harga' => 'required|numeric|min:0',
            'nominal_dp' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'keunggulan' => 'nullable|string',
            'fasilitas_include' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = $request->only(['nama_paket', 'kategori_layanan', 'metode_sunat', 'harga', 'nominal_dp', 'deskripsi', 'keunggulan', 'fasilitas_include']);

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $file = $request->file('gambar');
            $gambarFilename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $gambarFilename);
            $data['gambar'] = $gambarFilename;
        }

        $paket->update($data);

        return back()->with('success', "Paket {$paket->nama_paket} berhasil diperbarui!");
    }

    public function togglePaket($id)
    {
        $paket = PaketSunat::findOrFail($id);
        $paket->update(['is_active' => $paket->is_active ? 0 : 1]);

        return back()->with('success', "Status aktif paket {$paket->nama_paket} berhasil diubah!");
    }

    public function pasien()
    {
        $pasiens = Pasien::with('pendaftaran.paket')->orderBy('id', 'desc')->paginate(15);
        return view('admin.pasien', compact('pasiens'));
    }

    public function dokter()
    {
        $dokters = Dokter::with('user')->orderBy('id', 'asc')->get();
        return view('admin.dokter', compact('dokters'));
    }

    public function toggleDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->update(['status' => $dokter->status === 'aktif' ? 'cuti' : 'aktif']);

        return back()->with('success', "Status tugas dokter {$dokter->nama_dokter} berhasil diperbarui!");
    }

    public function kirimWa(Request $request)
    {
        $logs = WaLog::with('pendaftaran.pasien')->orderBy('id', 'desc')->limit(20)->get();
        $pendaftarans = Pendaftaran::with('pasien')->whereIn('status_pelayanan', ['menunggu', 'terkonfirmasi'])->get();

        return view('admin.kirim_wa', compact('logs', 'pendaftarans'));
    }

    public function storeWa(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id',
            'no_wa_tujuan' => 'required|string',
            'jenis_notifikasi' => 'required|string',
            'isi_pesan' => 'required|string',
        ]);

        WaLog::create([
            'id_pendaftaran' => $request->id_pendaftaran,
            'no_wa_tujuan' => $request->no_wa_tujuan,
            'jenis_notifikasi' => $request->jenis_notifikasi,
            'isi_pesan' => $request->isi_pesan,
            'status_kirim' => 'terkirim',
            'sent_at' => Carbon::now(),
        ]);

        $cleanPhone = preg_replace('/[^0-9]/', '', $request->no_wa_tujuan);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }
        $waUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($request->isi_pesan);

        return redirect()->away($waUrl);
    }

    public function laporan(Request $request)
    {
        $tglMulai = $request->query('tgl_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tglSelesai = $request->query('tgl_selesai', Carbon::now()->endOfMonth()->toDateString());

        $laporans = Pendaftaran::with(['pasien', 'paket', 'dokter'])
            ->whereBetween('tanggal_kunjungan', [$tglMulai, $tglSelesai])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        $totalPemasukan = 0;
        $totalDpMasuk = 0;
        $totalPiutang = 0;

        foreach ($laporans as $item) {
            if ($item->status_pembayaran === 'lunas') {
                $totalPemasukan += $item->total_biaya;
            } elseif ($item->status_pembayaran === 'dp_lunas') {
                $totalPemasukan += $item->nominal_dp;
                $totalDpMasuk += $item->nominal_dp;
                $totalPiutang += $item->sisa_pembayaran;
            }
        }

        return view('admin.laporan', compact('laporans', 'tglMulai', 'tglSelesai', 'totalPemasukan', 'totalDpMasuk', 'totalPiutang'));
    }
}
