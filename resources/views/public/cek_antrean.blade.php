@extends('layouts.app')

@section('title', 'Cek Antrean Sirkumsisi Realtime - Rumah Sunat Elnara')

@section('content')
<div class="bg-gradient-to-r from-emerald-900 to-teal-800 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3.5 py-1 bg-emerald-700/60 border border-emerald-500/40 rounded-full text-xs font-semibold text-emerald-200 uppercase tracking-wider mb-3">
            Live Status Antrean & Tracking Registrasi
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Monitor Antrean Tindakan Realtime</h1>
        <p class="mt-2 text-emerald-100 text-sm max-w-xl mx-auto">
            Pantau nomor antrean yang sedang berlangsung di ruang tindakan hari ini dan lacak status reservasi tiket Anda.
        </p>

        <!-- Search Form -->
        <form action="{{ route('cek_antrean') }}" method="GET" class="mt-8 max-w-xl mx-auto">
            <div class="flex bg-white rounded-2xl p-1.5 shadow-xl">
                <input type="text" name="q" value="{{ $q }}" placeholder="Masukkan No. Registrasi (REG-...) atau Nama Pasien" class="flex-grow px-4 py-3 text-slate-800 text-sm focus:outline-none rounded-xl">
                <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow">
                    <i class="bi bi-search mr-1.5"></i> Lacak
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Search Result Box if any -->
    @if($q)
    <div class="mb-12 bg-white rounded-3xl p-8 border border-emerald-200 shadow-lg">
        <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center">
            <i class="bi bi-search mr-2 text-emerald-600"></i> Hasil Pelacakan: "{{ $q }}"
        </h3>
        @if($searchResult)
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 p-5 bg-slate-50 rounded-2xl border border-slate-200">
            <div>
                <span class="text-xs text-slate-400 uppercase font-bold block">No. Registrasi</span>
                <span class="font-bold text-slate-800 text-sm">{{ $searchResult->no_registrasi }}</span>
            </div>
            <div>
                <span class="text-xs text-slate-400 uppercase font-bold block">No. Antrean</span>
                <span class="text-2xl font-black text-emerald-700">{{ $searchResult->no_antrean }}</span>
            </div>
            <div>
                <span class="text-xs text-slate-400 uppercase font-bold block">Status Pelayanan</span>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase {{ $searchResult->status_pelayanan === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $searchResult->status_pelayanan }}
                </span>
            </div>
            <div class="text-right">
                <a href="{{ route('tiket', $searchResult->no_registrasi) }}" class="inline-block px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow">
                    Lihat Tiket
                </a>
            </div>
        </div>
        @else
        <p class="text-sm text-slate-500">Data pendaftaran dengan kata kunci tersebut tidak ditemukan.</p>
        @endif
    </div>
    @endif

    <!-- Live Board Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Currently in Treatment Room -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-xl text-center">
                <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider mb-4 animate-pulse">
                    <i class="bi bi-broadcast mr-1"></i> Sedang Ditangani
                </span>
                <h3 class="text-sm text-emerald-100 font-medium">Nomor Antrean Ruang Tindakan</h3>
                <div class="my-6">
                    <span class="text-6xl sm:text-7xl font-black tracking-tight block">
                        {{ $antreanSekarang ? $antreanSekarang->no_antrean : '--' }}
                    </span>
                </div>
                @if($antreanSekarang)
                <p class="text-sm font-semibold text-emerald-100">
                    Dokter: {{ $antreanSekarang->dokter->nama_dokter }}
                </p>
                <p class="text-xs text-emerald-200 mt-1">
                    Metode: {{ ucwords(str_replace('_', ' ', $antreanSekarang->paket->metode_sunat)) }}
                </p>
                @else
                <p class="text-xs text-emerald-200">Tidak ada tindakan yang sedang berjalan saat ini.</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                <h4 class="font-bold text-slate-900 text-sm flex items-center">
                    <i class="bi bi-info-circle text-emerald-600 mr-2"></i> Informasi Antrean
                </h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Demi menjaga privasi medis keluarga pasien, nama pasien di papan monitor publik disamarkan secara otomatis.
                </p>
            </div>
        </div>

        <!-- Today's Queue Table -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Daftar Antrean Hari Ini</h3>
                        <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                        Total: {{ $antreanHariIni->count() }} Pasien
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-xs uppercase font-bold border-b border-slate-200/60">
                                <th class="p-4 pl-6">No. Antrean</th>
                                <th class="p-4">Inisial Pasien</th>
                                <th class="p-4">Paket Khitan</th>
                                <th class="p-4">Dokter</th>
                                <th class="p-4 pr-6">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($antreanHariIni as $ant)
                            @php
                            // Mask Name for Privacy
                            $nama = $ant->pasien->nama_pasien;
                            $len = strlen($nama);
                            $masked = $len > 3 ? substr($nama, 0, 2) . str_repeat('*', max(3, $len - 4)) . substr($nama, -2) : $nama;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition {{ $ant->status_pelayanan === 'tindakan' ? 'bg-emerald-50/50' : '' }}">
                                <td class="p-4 pl-6 font-mono font-black text-emerald-700 text-base">
                                    {{ $ant->no_antrean }}
                                </td>
                                <td class="p-4 font-semibold text-slate-800">
                                    {{ $masked }}
                                </td>
                                <td class="p-4 text-xs text-slate-600">
                                    {{ $ant->paket->nama_paket }}
                                </td>
                                <td class="p-4 text-xs text-slate-600">
                                    {{ $ant->dokter->nama_dokter }}
                                </td>
                                <td class="p-4 pr-6">
                                    @if($ant->status_pelayanan === 'tindakan')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-extrabold rounded-full animate-pulse">
                                        Diperiksa
                                    </span>
                                    @elseif($ant->status_pelayanan === 'terkonfirmasi')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full">
                                        Terkonfirmasi
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-full">
                                        Menunggu
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 text-sm">
                                    Belum ada antrean terdaftar untuk hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection