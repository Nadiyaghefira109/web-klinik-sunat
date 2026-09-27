@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Pelayanan')
@section('page_title', 'Rekapitulasi Keuangan & Pelayanan')
@section('page_subtitle', 'Laporan transaksi, uang muka (DP), pelunasan kas, dan performa layanan sirkumsisi')

@section('content')
<!-- Filter Date Header -->
<div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs mb-8 no-print">
    <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-wrap items-center justify-between gap-4">
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
                    <i class="bi bi-funnel mr-1"></i> Terapkan
                </button>
            </div>
        </div>

        <div class="pt-5">
            <button type="button" onclick="window.print()" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow flex items-center">
                <i class="bi bi-printer mr-1.5"></i> Cetak Laporan
            </button>
        </div>
    </form>
</div>

<!-- Printable Report Container -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-8" id="reportArea">
    <!-- Letterhead (Kop Surat) -->
    <div class="text-center pb-6 border-b-2 border-slate-900 mb-6">
        <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight">RUMAH SUNAT ELNARA (KLINIK EL MEDIKA)</h2>
        <p class="text-xs text-slate-600">Pelayanan Sirkumsisi Modern Ramah Anak, Home Care, Dewasa, & Bayi</p>
        <p class="text-xs text-slate-500">Jl. Raden Intan No. 88, Bandar Lampung • Telp/WA: 0812-3456-7890</p>
    </div>

    <!-- Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200">
            <span class="text-xs text-emerald-800 font-bold block">Total Kas Diterima (Riil)</span>
            <span class="text-2xl font-black text-emerald-700 mt-1 block">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
            <span class="text-[10px] text-emerald-600 mt-1 block">Akumulasi DP + Pelunasan</span>
        </div>

        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-200">
            <span class="text-xs text-blue-800 font-bold block">Penerimaan Uang Muka (DP)</span>
            <span class="text-2xl font-black text-blue-700 mt-1 block">Rp {{ number_format($totalDpMasuk, 0, ',', '.') }}</span>
            <span class="text-[10px] text-blue-600 mt-1 block">Setoran DP Terkonfirmasi</span>
        </div>

        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200">
            <span class="text-xs text-amber-800 font-bold block">Piutang Sisa Pelunasan</span>
            <span class="text-2xl font-black text-amber-700 mt-1 block">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</span>
            <span class="text-[10px] text-amber-600 mt-1 block">Sisa Dibayar Hari Tindakan</span>
        </div>
    </div>

    <!-- Table Report -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-700 uppercase font-bold border-b border-slate-300">
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">No. Reg</th>
                    <th class="p-3">Nama Pasien</th>
                    <th class="p-3">Paket Khitan</th>
                    <th class="p-3 text-right">Tarif</th>
                    <th class="p-3 text-right">DP Masuk</th>
                    <th class="p-3 text-right">Sisa Bayar</th>
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
                    <td class="p-3 text-right font-bold">Rp {{ number_format($lp->total_biaya, 0, ',', '.') }}</td>
                    <td class="p-3 text-right text-blue-700 font-bold">
                        Rp {{ number_format($lp->status_pembayaran !== 'belum_bayar' ? $lp->nominal_dp : 0, 0, ',', '.') }}
                    </td>
                    <td class="p-3 text-right text-slate-600">Rp {{ number_format($lp->sisa_pembayaran, 0, ',', '.') }}</td>
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

    <!-- Signature Section for Print -->
    <div class="mt-12 pt-8 flex justify-between text-xs text-slate-700">
        <div></div>
        <div class="text-center space-y-12">
            <p>Bandar Lampung, {{ date('d F Y') }}<br><strong>Pimpinan Klinik El Medika</strong></p>
            <p class="font-bold underline pt-6">( dr. Rizky / Management )</p>
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