@extends('layouts.app')

@section('title', 'Tiket Antrean Sirkumsisi - ' . $pendaftaran->no_registrasi)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden" id="printArea">
        <!-- Header Tiket -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white p-8 text-center relative">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider mb-2">
                <i class="bi bi-ticket-perforated"></i>
                <span>E-Tiket Sirkumsisi Resmi</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight">RUMAH SUNAT ELNARA</h1>
            <p class="text-xs text-emerald-200 mt-0.5">Klinik El Medika • Jl. Raden Intan No. 88, Bandar Lampung</p>

            <!-- No Antrean Badge -->
            <div class="mt-6 inline-block bg-white text-emerald-900 px-8 py-3 rounded-2xl shadow-xl">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Nomor Antrean</span>
                <span class="text-4xl font-black tracking-tight text-emerald-700">{{ $pendaftaran->no_antrean }}</span>
            </div>
        </div>

        <!-- Body Tiket -->
        <div class="p-8 space-y-6">
            <!-- Status Bar -->
            <div class="flex flex-wrap justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-200 gap-3">
                <div>
                    <span class="text-xs text-slate-500 block">Nomor Registrasi:</span>
                    <span class="text-base font-mono font-bold text-slate-900">{{ $pendaftaran->no_registrasi }}</span>
                </div>

                <div class="text-right">
                    <span class="text-xs text-slate-500 block">Status Pembayaran:</span>
                    @if($pendaftaran->status_pembayaran === 'belum_bayar')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                        <i class="bi bi-x-circle mr-1"></i> Belum Bayar DP
                    </span>
                    @elseif($pendaftaran->status_pembayaran === 'menunggu_verifikasi')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        <i class="bi bi-hourglass-split mr-1"></i> Menunggu Verifikasi DP
                    </span>
                    @elseif($pendaftaran->status_pembayaran === 'dp_lunas')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                        <i class="bi bi-check2-circle mr-1"></i> DP Lunas (Terkonfirmasi)
                    </span>
                    @elseif($pendaftaran->status_pembayaran === 'lunas')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <i class="bi bi-check-all mr-1"></i> Lunas Seluruhnya
                    </span>
                    @endif
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div class="space-y-3">
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Nama Pasien:</span>
                        <span class="font-extrabold text-slate-800 text-base">{{ $pendaftaran->pasien->nama_pasien }}</span>
                        <span class="text-xs text-slate-500 block">Usia: {{ $pendaftaran->pasien->usia_tahun }} tahun ({{ $pendaftaran->pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }})</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Nama Orang Tua / Wali:</span>
                        <span class="font-semibold text-slate-700">{{ $pendaftaran->pasien->nama_ortu_wali }} ({{ $pendaftaran->pasien->no_wa }})</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Paket Layanan:</span>
                        <span class="font-bold text-emerald-700">{{ $pendaftaran->paket->nama_paket }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Jadwal Tindakan:</span>
                        <span class="font-extrabold text-slate-800 text-base">
                            {{ $pendaftaran->tanggal_kunjungan->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="text-xs text-emerald-600 font-bold block">Pukul {{ substr($pendaftaran->jam_kunjungan, 0, 5) }} WIB</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Dokter Bertugas:</span>
                        <span class="font-semibold text-slate-700">{{ $pendaftaran->dokter->nama_dokter }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Lokasi:</span>
                        <span class="font-semibold text-slate-700">
                            {{ $pendaftaran->jenis_layanan === 'home_care' ? 'Kunjungan ke Rumah (Home Care)' : 'Klinik El Medika' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Financial Breakdown -->
            <div class="p-5 bg-emerald-50/70 rounded-2xl border border-emerald-100 space-y-2">
                <div class="flex justify-between text-xs text-slate-600">
                    <span>Total Biaya Paket</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($pendaftaran->total_biaya, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs text-slate-600">
                    <span>Uang Muka (Wajib DP)</span>
                    <span class="font-bold text-amber-700">Rp {{ number_format($pendaftaran->nominal_dp, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm font-extrabold text-emerald-900 pt-2 border-t border-emerald-200">
                    <span>Sisa Pelunasan di Klinik</span>
                    <span class="text-emerald-700">Rp {{ number_format($pendaftaran->sisa_pembayaran, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Bukti Pembayaran Section -->
            @if($pendaftaran->status_pembayaran === 'belum_bayar')
            <div class="p-6 bg-amber-50 rounded-2xl border border-amber-200 space-y-4">
                <div class="flex items-start space-x-3">
                    <i class="bi bi-exclamation-triangle-fill text-amber-600 text-xl shrink-0 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-bold text-amber-900">Segera Bayar DP untuk Mengunci Jadwal Anda</h3>
                        <p class="text-xs text-amber-700 mt-1">
                            Silakan transfer DP sebesar <strong>Rp {{ number_format($pendaftaran->nominal_dp, 0, ',', '.') }}</strong> ke rekening:
                            <strong>BCA: 023-8899-123</strong> (Klinik El Medika) atau <strong>Mandiri: 114-00-1988221-1</strong> (Rumah Sunat Elnara).
                        </p>
                    </div>
                </div>

                <!-- Form Upload Bukti Susulan -->
                <form action="{{ route('tiket.upload_bukti', $pendaftaran->no_registrasi) }}" method="POST" enctype="multipart/form-data" class="pt-2 flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="file" name="bukti_pembayaran" required accept=".jpg,.jpeg,.png,.pdf" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 border border-slate-300 rounded-xl flex-grow bg-white">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow shrink-0">
                        <i class="bi bi-upload mr-1"></i> Upload Bukti DP
                    </button>
                </form>
            </div>
            @elseif($pendaftaran->bukti_pembayaran)
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="bi bi-file-earmark-image text-emerald-600 text-2xl"></i>
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Bukti Transfer Terlampir</span>
                        <span class="text-xs text-slate-400">{{ $pendaftaran->bukti_pembayaran }}</span>
                    </div>
                </div>
                <a href="{{ asset('assets/uploads/bukti_dp/' . $pendaftaran->bukti_pembayaran) }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 underline">
                    Lihat Bukti
                </a>
            </div>
            @endif
        </div>

        <!-- Action Footer -->
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex flex-wrap justify-between items-center gap-3">
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                <i class="bi bi-arrow-left mr-1"></i> Kembali ke Beranda
            </a>

            <div class="flex space-x-3">
                <button onclick="window.print()" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition shadow-sm">
                    <i class="bi bi-printer mr-1"></i> Cetak Tiket
                </button>

                @php
                $pesanWa = "Halo Admin Klinik El Medika, saya ingin mengonfirmasi pendaftaran khitan atas nama {$pendaftaran->pasien->nama_pasien} dengan No. Registrasi {$pendaftaran->no_registrasi} dan No. Antrean {$pendaftaran->no_antrean}.";
                $linkWa = "https://wa.me/6281234567890?text=" . urlencode($pesanWa);
                @endphp
                <a href="{{ $linkWa }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition">
                    <i class="bi bi-whatsapp mr-1"></i> Hubungi WhatsApp Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection