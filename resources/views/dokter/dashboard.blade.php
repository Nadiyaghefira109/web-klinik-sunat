@extends('layouts.admin')

@section('title', 'Dashboard Tenaga Medis')
@section('page_title', 'Dashboard Dokter Pelaksana')
@section('page_subtitle', 'Selamat bertugas, ' . $dokter->nama_dokter)

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Antrean Hari Ini</span>
            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ $antreanHariIni->count() }}</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">{{ date('d M Y') }}</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
            <i class="bi bi-people"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Menunggu Tindakan</span>
            <span class="text-3xl font-black text-amber-500 mt-1 block">{{ $menungguHariIni }}</span>
            <span class="text-[11px] text-amber-600 font-semibold mt-1 block">Pasien siap dipanggil</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">
            <i class="bi bi-hourglass-split"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Tindakan Selesai</span>
            <span class="text-3xl font-black text-emerald-600 mt-1 block">{{ $selesaiHariIni }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Rekam medis terisi</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
            <i class="bi bi-check2-circle"></i>
        </div>
    </div>
</div>

<!-- Antrean Tindakan List -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Antrean Siap Tindakan Hari Ini</h3>
            <p class="text-xs text-slate-400">Pilih pasien untuk memulai pemeriksaan & tindakan</p>
        </div>
        <a href="{{ route('dokter.antrean') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
            Buka Antrean Lengkap <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="p-6 space-y-4">
        @forelse($antreanHariIni as $ant)
        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <span class="w-14 h-14 rounded-2xl bg-emerald-600 text-white font-black text-xl flex items-center justify-center shrink-0">
                    {{ $ant->no_antrean }}
                </span>
                <div>
                    <h4 class="font-extrabold text-slate-900 text-base">{{ $ant->pasien->nama_pasien }} ({{ $ant->pasien->usia_tahun }} thn)</h4>
                    <p class="text-xs text-slate-500 font-medium">Paket: <strong class="text-emerald-700">{{ $ant->paket->nama_paket }}</strong></p>
                    <p class="text-xs text-slate-400 mt-0.5">Keluhan Awal: {{ $ant->keluhan_awal ?: 'Tidak ada' }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 shrink-0">
                <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $ant->status_pelayanan === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $ant->status_pelayanan }}
                </span>
                <a href="{{ route('dokter.rekam_medis', $ant->id) }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">
                    <i class="bi bi-clipboard2-pulse mr-1"></i> Rekam Medis
                </a>
            </div>
        </div>
        @empty
        <p class="text-center text-xs text-slate-400 py-6">Tidak ada antrean tindakan untuk jadwal hari ini.</p>
        @endforelse
    </div>
</div>
@endsection