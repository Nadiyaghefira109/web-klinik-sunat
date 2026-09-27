@extends('layouts.admin')

@section('title', 'Antrean Tindakan Pasien')
@section('page_title', 'Antrean Pasien Tindakan Khitan')
@section('page_subtitle', 'Kelola antrean dan rekam medis tindakan sirkumsisi pasien hari ini')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Daftar Antrean Hari Ini</h3>
            <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</p>
        </div>
        <span class="px-3.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
            {{ $antreans->count() }} Pasien Terdaftar
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-400 uppercase font-bold border-b border-slate-200/60">
                    <th class="p-4 pl-6">Antrean</th>
                    <th class="p-4">Identitas Pasien</th>
                    <th class="p-4">Paket & Metode</th>
                    <th class="p-4">Keluhan Awal</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 pr-6 text-center">Aksi Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($antreans as $ant)
                <tr class="hover:bg-slate-50/80 transition {{ $ant->status_pelayanan === 'tindakan' ? 'bg-amber-50/50' : '' }}">
                    <td class="p-4 pl-6 font-mono font-black text-emerald-700 text-base">
                        {{ $ant->no_antrean }}
                    </td>
                    <td class="p-4">
                        <span class="font-extrabold text-slate-800 text-sm block">{{ $ant->pasien->nama_pasien }}</span>
                        <span class="text-slate-500 text-xs">Usia: {{ $ant->pasien->usia_tahun }} thn • Wali: {{ $ant->pasien->nama_ortu_wali }}</span>
                    </td>
                    <td class="p-4">
                        <span class="font-bold text-slate-700 block">{{ $ant->paket->nama_paket }}</span>
                        <span class="text-xs text-emerald-600 font-semibold">{{ ucwords(str_replace('_', ' ', $ant->paket->metode_sunat)) }}</span>
                    </td>
                    <td class="p-4 text-slate-500 max-w-xs truncate">
                        {{ $ant->keluhan_awal ?: '-' }}
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 text-[11px] font-bold uppercase rounded-full {{ $ant->status_pelayanan === 'selesai' ? 'bg-emerald-100 text-emerald-800' : ($ant->status_pelayanan === 'tindakan' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                            {{ $ant->status_pelayanan }}
                        </span>
                    </td>
                    <td class="p-4 pr-6 text-center space-x-1">
                        <a href="{{ route('dokter.rekam_medis', $ant->id) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center">
                            <i class="bi bi-pencil-square mr-1"></i> Input RME
                        </a>

                        @if($ant->status_pelayanan === 'selesai')
                        <a href="{{ route('dokter.rekam_medis.cetak', $ant->id) }}" target="_blank" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center">
                            <i class="bi bi-printer mr-1"></i> Cetak
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">Tidak ada pasien antrean untuk hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection