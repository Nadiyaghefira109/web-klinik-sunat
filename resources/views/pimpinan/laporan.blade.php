@extends('layouts.admin')

@section('title', 'Laporan Finansial Eksekutif')
@section('page_title', 'Laporan Keuangan & Kinerja Eksekutif')
@section('page_subtitle', 'Rekapitulasi pendapatan kotor, setoran DP, dan pengesahan direksi Rumah Sunat Elnara')

@section('content')
<!-- Filter Header -->
<div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs mb-8 no-print">
    <form action="{{ route('pimpinan.laporan') }}" method="GET" class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="px-3 py-2 rounded-xl border border-slate-300 text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="tgl_selesai" value="{{ $tglSelesai }}" class="px-3 py-2 rounded-xl border border-slate-300 text-xs">
            </div>
            <div class="pt-5">
                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow">
                    <i class="bi bi-funnel mr-1"></i> Filter Periode
                </button>
            </div>
        </div>

        <div class="pt-5">
            <button type="button" onclick="window.print()" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow flex items-center">
                <i class="bi bi-printer mr-1.5"></i> Cetak Laporan Eksekutif
            </button>
        </div>
    </form>
</div>

<!-- Printable Report Container -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-8" id="reportArea">
    <!-- Letterhead -->
    <div class="text-center pb-6 border-b-2 border-slate-900 mb-6">
        <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight">RUMAH SUNAT ELNARA (KLINIK EL MEDIKA)</h2>
        <p class="text-xs text-slate-600">Laporan Eksekutif Perkembangan Layanan & Keuangan Sirkumsisi</p>
        <p class="text-xs text-slate-500">Periode: {{ \Carbon\Carbon::parse($tglMulai)->format('d/m/Y') }} s.d. {{ \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y') }}</p>
    </div>

    <!-- Metric Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200">
            <span class="text-xs text-emerald-800 font-bold block">Total Kas Diterima</span>
            <span class="text-2xl font-black text-emerald-700 mt-1 block">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            <span class="text-[10px] text-emerald-600 mt-1 block">Setoran DP + Pelunasan Kasir</span>
        </div>

        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-200">
            <span class="text-xs text-blue-800 font-bold block">Uang Muka (DP) Terkumpul</span>
            <span class="text-2xl font-black text-blue-700 mt-1 block">Rp {{ number_format($totalDpMasuk, 0, ',', '.') }}</span>
            <span class="text-[10px] text-blue-600 mt-1 block">Kunci Jadwal Pasien</span>
        </div>

        <div class="p-4 bg-teal-50 rounded-2xl border border-teal-200">
            <span class="text-xs text-teal-800 font-bold block">Pelunasan di Tempat</span>
            <span class="text-2xl font-black text-teal-700 mt-1 block">Rp {{ number_format($totalPelunasan, 0, ',', '.') }}</span>
            <span class="text-[10px] text-teal-600 mt-1 block">Tindakan Khitan Selesai</span>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-700 uppercase font-bold border-b border-slate-300">
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">No. Registrasi</th>
                    <th class="p-3">Nama Pasien</th>
                    <th class="p-3">Layanan & Metode</th>
                    <th class="p-3">Dokter</th>
                    <th class="p-3 text-right">Tarif</th>
                    <th class="p-3 text-right">DP Masuk</th>
                    <th class="p-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($laporans as $lp)
                <tr>
                    <td class="p-3 text-slate-600">{{ $lp->tanggal_kunjungan->format('d/m/Y') }}</td>
                    <td class="p-3 font-mono font-bold">{{ $lp->no_registrasi }}</td>
                    <td class="p-3 font-semibold text-slate-800">{{ $lp->pasien->nama_pasien }}</td>
                    <td class="p-3 text-slate-600">{{ $lp->paket->nama_paket }}</td>
                    <td class="p-3 text-slate-600">{{ $lp->dokter->nama_dokter }}</td>
                    <td class="p-3 text-right font-bold">Rp {{ number_format($lp->total_biaya, 0, ',', '.') }}</td>
                    <td class="p-3 text-right font-bold text-blue-700">
                        Rp {{ number_format($lp->status_pembayaran !== 'belum_bayar' ? $lp->nominal_dp : 0, 0, ',', '.') }}
                    </td>
                    <td class="p-3 text-center uppercase font-bold text-[10px]">
                        <span class="px-2 py-0.5 rounded {{ $lp->status_pembayaran === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $lp->status_pembayaran }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-6 text-center text-slate-400">Tidak ada transaksi pada periode tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Approval Signature -->
    <div class="mt-12 pt-8 flex justify-between text-xs text-slate-700">
        <div></div>
        <div class="text-center space-y-12">
            <p>Bandar Lampung, {{ date('d F Y') }}<br>Mengetahui & Menyetujui,<br><strong>Pimpinan / Direktur Klinik</strong></p>
            <p class="font-bold underline pt-6">( Management Rumah Sunat Elnara )</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        body {
            background: white !important;
        }

        aside,
        header,
        .no-print {
            display: none !important;
        }

        main {
            padding: 0 !important;
        }

        #reportArea {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush