@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('page_title', 'Dashboard Utama Administrator')
@section('page_subtitle', 'Ringkasan operasional harian Rumah Sunat Elnara (Klinik El Medika)')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pasien</span>
            <span class="text-3xl font-black text-slate-900 mt-1 block">{{ $totalPasien }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block"><i class="bi bi-person-check"></i> Terdaftar di sistem</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
            <i class="bi bi-people-fill"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Antrean Hari Ini</span>
            <span class="text-3xl font-black text-blue-600 mt-1 block">{{ $totalAntreanHariIni }}</span>
            <span class="text-[11px] text-blue-500 font-semibold mt-1 block"><i class="bi bi-calendar-event"></i> Jadwal {{ date('d M Y') }}</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
            <i class="bi bi-clock-history"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Menunggu Verifikasi</span>
            <span class="text-3xl font-black text-amber-500 mt-1 block">{{ $menungguVerifikasi }}</span>
            <span class="text-[11px] text-amber-600 font-semibold mt-1 block"><i class="bi bi-hourglass-split"></i> Bukti DP masuk</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">
            <i class="bi bi-receipt-cutoff"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Omzet Kas</span>
            <span class="text-2xl font-black text-emerald-700 mt-1 block">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</span>
            <span class="text-[11px] text-slate-400 font-medium mt-1 block">DP & Pelunasan Masuk</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center text-2xl">
            <i class="bi bi-cash-coin"></i>
        </div>
    </div>
</div>

<!-- Tables Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Pendaftaran Terbaru -->
    <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Pendaftaran Terbaru Masuk</h3>
                <p class="text-xs text-slate-400">7 transaksi reservasi terakhir</p>
            </div>
            <a href="{{ route('admin.pendaftaran') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase font-bold border-b border-slate-200/60">
                        <th class="p-4 pl-6">No. Reg / Pasien</th>
                        <th class="p-4">Paket Khitan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4 pr-6">Status Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pendaftaranTerbaru as $p)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 pl-6">
                            <span class="font-mono font-bold text-slate-900 block">{{ $p->no_registrasi }}</span>
                            <span class="text-slate-500 font-semibold">{{ $p->pasien->nama_pasien }}</span>
                        </td>
                        <td class="p-4 text-slate-700">{{ $p->paket->nama_paket }}</td>
                        <td class="p-4 text-slate-500">{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="p-4 pr-6">
                            @if($p->status_pembayaran === 'dp_lunas')
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full font-bold">DP Lunas</span>
                            @elseif($p->status_pembayaran === 'menunggu_verifikasi')
                            <span class="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-full font-bold">Perlu Cek DP</span>
                            @elseif($p->status_pembayaran === 'lunas')
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold">Lunas</span>
                            @else
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full font-bold">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Antrean Hari Ini -->
    <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Antrean Siap Hari Ini</h3>
                <p class="text-xs text-slate-400">{{ date('d M Y') }}</p>
            </div>
            <a href="{{ route('admin.antrean') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                Buka Panggilan <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="p-6 space-y-4">
            @forelse($antreanHariIni as $ant)
            <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="w-12 h-12 rounded-xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center shrink-0">
                        {{ $ant->no_antrean }}
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $ant->pasien->nama_pasien }}</h4>
                        <p class="text-xs text-slate-500">{{ $ant->paket->nama_paket }}</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 text-xs font-bold uppercase rounded-full {{ $ant->status_pelayanan === 'tindakan' ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-700' }}">
                    {{ $ant->status_pelayanan }}
                </span>
            </div>
            @empty
            <p class="text-center text-xs text-slate-400 py-6">Belum ada pasien antrean untuk hari ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection