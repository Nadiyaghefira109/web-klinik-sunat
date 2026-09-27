@extends('layouts.admin')

@section('title', 'Executive Summary')
@section('page_title', 'Executive Summary & Analitik Klinik')
@section('page_subtitle', 'Monitoring pendapatan real-time, volume tindakan, dan tren pilihan metode sirkumsisi')

@section('content')
<!-- Stat Metrics -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Omzet Kas Masuk</span>
            <span class="text-2xl font-black text-emerald-700 mt-1 block">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Akumulasi DP & Pelunasan</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
            <i class="bi bi-wallet2"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Omzet Bulan Ini</span>
            <span class="text-2xl font-black text-blue-700 mt-1 block">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</span>
            <span class="text-[11px] text-blue-600 font-semibold mt-1 block">{{ date('F Y') }}</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pasien Selesai</span>
            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ $totalPasien }}</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Selesai Tindakan Khitan</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center text-2xl">
            <i class="bi bi-patch-check"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Rasio Lokasi Tindakan</span>
            <span class="text-base font-black text-slate-900 mt-1 block">{{ $layananKlinik }} Klinik : {{ $layananHomeCare }} Rumah</span>
            <span class="text-[11px] text-slate-400 font-semibold mt-1 block">Layanan Tersebar</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">
            <i class="bi bi-houses"></i>
        </div>
    </div>
</div>

<!-- Charts & Analytics Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Metode Stats -->
    <div class="lg:col-span-6 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
        <h3 class="text-base font-extrabold text-slate-900 mb-2">Tren Metode Sirkumsisi</h3>
        <p class="text-xs text-slate-400 mb-6">Distribusi pemilihan metode khitan oleh orang tua pasien</p>

        <div class="space-y-4">
            @foreach($metodeStats as $ms)
            @php
            $pct = $totalPasien > 0 ? round(($ms->total / max(1, $totalPasien)) * 100) : 25;
            @endphp
            <div>
                <div class="flex justify-between text-xs font-bold mb-1">
                    <span class="text-slate-700 uppercase">{{ ucwords(str_replace('_', ' ', $ms->metode_sunat)) }}</span>
                    <span class="text-emerald-700">{{ $ms->total }} Pasien ({{ $pct }}%)</span>
                </div>
                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full" style="width: {{ min(100, $pct) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Revenue Feed -->
    <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-base font-extrabold text-slate-900">Arus Transaksi Terkini</h3>
            <a href="{{ route('pimpinan.laporan') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                Laporan Lengkap <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="p-6 space-y-3">
            @forelse($transaksiTerbaru as $tr)
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 flex justify-between items-center text-xs">
                <div>
                    <span class="font-bold text-slate-800 block text-sm">{{ $tr->pasien->nama_pasien }}</span>
                    <span class="text-[11px] text-slate-500">{{ $tr->paket->nama_paket }} • {{ $tr->tanggal_kunjungan->format('d/m/Y') }}</span>
                </div>
                <div class="text-right">
                    <span class="font-bold text-emerald-700 block text-sm">
                        Rp {{ number_format($tr->status_pembayaran === 'lunas' ? $tr->total_biaya : $tr->nominal_dp, 0, ',', '.') }}
                    </span>
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $tr->status_pembayaran === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $tr->status_pembayaran === 'lunas' ? 'Lunas' : 'DP' }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-center text-xs text-slate-400 py-6">Belum ada transaksi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection