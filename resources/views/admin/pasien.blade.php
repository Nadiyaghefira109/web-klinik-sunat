@extends('layouts.admin')

@section('title', 'Master Data Pasien')
@section('page_title', 'Database Pasien & Rekam Medis')
@section('page_subtitle', 'Data identitas pasien khitan dan riwayat nomor rekam medis (No. RM)')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Arsip Pasien Sirkumsisi</h3>
            <p class="text-xs text-slate-400">Total {{ $pasiens->total() }} pasien terdata</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-400 uppercase font-bold border-b border-slate-200/60">
                    <th class="p-4 pl-6">No. RM</th>
                    <th class="p-4">Nama Pasien</th>
                    <th class="p-4">Usia & Tgl Lahir</th>
                    <th class="p-4">Orang Tua / Wali</th>
                    <th class="p-4">No. WhatsApp</th>
                    <th class="p-4 pr-6">Alamat Lengkap</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pasiens as $pas)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 pl-6 font-mono font-bold text-emerald-700 text-sm">
                        {{ $pas->no_rm }}
                    </td>
                    <td class="p-4">
                        <span class="font-extrabold text-slate-800 text-sm block">{{ $pas->nama_pasien }}</span>
                        <span class="text-slate-400 text-[11px]">{{ $pas->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </td>
                    <td class="p-4 text-slate-600">
                        <span class="font-semibold block">{{ $pas->usia_tahun }} tahun {{ $pas->usia_bulan }} bln</span>
                        <span class="text-slate-400 text-[11px]">{{ $pas->tanggal_lahir }}</span>
                    </td>
                    <td class="p-4 font-semibold text-slate-700">
                        {{ $pas->nama_ortu_wali }}
                    </td>
                    <td class="p-4">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pas->no_wa) }}" target="_blank" class="font-mono text-emerald-600 hover:text-emerald-700 font-bold">
                            <i class="bi bi-whatsapp mr-1"></i> {{ $pas->no_wa }}
                        </a>
                    </td>
                    <td class="p-4 pr-6 text-slate-500 max-w-xs truncate">
                        {{ $pas->alamat_lengkap }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data pasien di sistem.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-slate-100">
        {{ $pasiens->links() }}
    </div>
</div>
@endsection